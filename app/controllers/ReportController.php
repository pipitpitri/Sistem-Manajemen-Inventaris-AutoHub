<?php

class ReportController extends BaseController
{
    private function resolveReportFilters(): array
    {
        $hasType = array_key_exists('type', $_GET);
        $hasMonth = array_key_exists('month', $_GET);
        $hasYear = array_key_exists('year', $_GET);
        $hasCategory = array_key_exists('category', $_GET);

        return [
            'type' => $hasType ? (string) $_GET['type'] : 'incoming',
            'month' => $hasMonth ? (int) $_GET['month'] : (int) date('n'),
            'year' => $hasYear ? (int) $_GET['year'] : (int) date('Y'),
            'category' => $hasCategory ? trim((string) $_GET['category']) : '',
        ];
    }

    private function getReportPayload(string $type, int $month, int $year, string $category = ''): array
    {
        $report = new Report();
        $rows = [];
        $label = 'Laporan Barang';
        $selectedCategory = $category !== '' ? $category : null;

        if ($type === 'incoming') {
            $rows = $report->incoming($month ?: null, $year ?: null, $selectedCategory);
            $label = 'Laporan Barang Masuk';
        } elseif ($type === 'outgoing') {
            $rows = $report->outgoing($month ?: null, $year ?: null, $selectedCategory);
            $label = 'Laporan Barang Keluar';
        } else {
            $rows = $report->products(null, $month ?: null, $year ?: null, $selectedCategory);
            $label = 'Laporan Data Barang';
        }

        $totalSubtotal = 0;
        if ($type !== 'products') {
            foreach ($rows as $row) {
                $totalSubtotal += (float) ($row['subtotal'] ?? 0);
            }
        }

        return [
            'rows' => $rows,
            'columns' => $this->getReportColumns($type),
            'tableRows' => $this->buildReportTableRows($type, $rows),
            'label' => $label,
            'periodLabel' => $this->buildPeriodLabel($type, $month, $year),
            'categoryLabel' => $category !== '' ? $category : 'Semua Kategori',
            'totalSubtotal' => $totalSubtotal,
        ];
    }

    private function getReportColumns(string $type): array
    {
        if ($type === 'incoming') {
            return [
                ['label' => 'Tanggal', 'width' => 65],
                ['label' => 'Kode', 'width' => 60],
                ['label' => 'Nama Barang', 'width' => 155],
                ['label' => 'Kategori', 'width' => 95],
                ['label' => 'Harga', 'width' => 90, 'align' => 'right'],
                ['label' => 'Jumlah', 'width' => 55, 'align' => 'center'],
                ['label' => 'Subtotal', 'width' => 100, 'align' => 'right'],
                ['label' => 'Supplier', 'width' => 150],
            ];
        }

        if ($type === 'outgoing') {
            return [
                ['label' => 'Tanggal', 'width' => 65],
                ['label' => 'Kode', 'width' => 60],
                ['label' => 'Nama Barang', 'width' => 160],
                ['label' => 'Kategori', 'width' => 90],
                ['label' => 'Harga', 'width' => 90, 'align' => 'right'],
                ['label' => 'Jumlah', 'width' => 55, 'align' => 'center'],
                ['label' => 'Subtotal', 'width' => 100, 'align' => 'right'],
                ['label' => 'Keterangan', 'width' => 150],
            ];
        }

        return [
            ['label' => 'Kode', 'width' => 85],
            ['label' => 'Nama Barang', 'width' => 245],
            ['label' => 'Kategori', 'width' => 120],
            ['label' => 'Stok', 'width' => 65, 'align' => 'center'],
            ['label' => 'Harga', 'width' => 105, 'align' => 'right'],
            ['label' => 'Supplier', 'width' => 150],
        ];
    }

    private function buildReportTableRows(string $type, array $rows): array
    {
        $tableRows = [];

        foreach ($rows as $row) {
            if ($type === 'incoming') {
                $tableRows[] = [
                    format_date($row['tanggal']),
                    $row['kode_barang'],
                    $row['nama_barang'],
                    $row['kategori'],
                    format_currency($row['harga']),
                    (string) $row['jumlah'],
                    format_currency($row['subtotal']),
                    $row['nama_supplier'],
                ];
                continue;
            }

            if ($type === 'outgoing') {
                $tableRows[] = [
                    format_date($row['tanggal']),
                    $row['kode_barang'],
                    $row['nama_barang'],
                    $row['kategori'],
                    format_currency($row['harga']),
                    (string) $row['jumlah'],
                    format_currency($row['subtotal']),
                    ucfirst($row['keterangan']),
                ];
                continue;
            }

            $tableRows[] = [
                $row['kode_barang'],
                $row['nama_barang'],
                $row['kategori'],
                (string) $row['stok'],
                format_currency($row['harga']),
                $row['nama_supplier'],
            ];
        }

        return $tableRows;
    }

    private function buildPeriodLabel(string $type, int $month, int $year): string
    {
        if ($type === 'products') {
            if ($month > 0) {
                $months = months_list();
                return $months[$month] . ' ' . $year;
            }

            return 'Tahun ' . $year;
        }

        if ($month > 0) {
            $months = months_list();
            return $months[$month] . ' ' . $year;
        }

        return 'Tahun ' . $year;
    }

    public function index(): void
    {
        $this->authRequired();

        $filters = $this->resolveReportFilters();
        $type = $filters['type'];
        $month = $filters['month'];
        $year = $filters['year'];
        $category = $filters['category'];
        $payload = $this->getReportPayload($type, $month, $year, $category);

        $this->render('reports/index', [
            'title' => 'Laporan',
            'selectedType' => $type,
            'selectedCategory' => $category,
            'selectedMonth' => $month,
            'selectedYear' => $year,
            'years' => range((int) date('Y') - 4, (int) date('Y') + 1),
            'categories' => ['Sparepart', 'Oli', 'Ban'],
            'heading' => $payload['label'],
            'rows' => $payload['rows'],
            'periodLabel' => $payload['periodLabel'],
            'categoryLabel' => $payload['categoryLabel'],
            'totalSubtotal' => $payload['totalSubtotal'],
        ]);
    }

    public function print(): void
    {
        $this->authRequired();

        $filters = $this->resolveReportFilters();
        $type = $filters['type'];
        $month = $filters['month'];
        $year = $filters['year'];
        $category = $filters['category'];
        $payload = $this->getReportPayload($type, $month, $year, $category);

        $this->render('reports/print', [
            'title' => $payload['label'],
            'type' => $type,
            'columns' => $payload['columns'],
            'tableRows' => $payload['tableRows'],
            'periodLabel' => $payload['periodLabel'],
            'categoryLabel' => $payload['categoryLabel'],
            'printedAt' => date('d M Y H:i'),
            'totalSubtotal' => $payload['totalSubtotal'],
            'returnUrl' => route('reports') . '&type=' . $type . '&month=' . $month . '&year=' . $year . '&category=' . urlencode($category),
        ], 'print');
    }

    public function export(): void
    {
        $this->authRequired();

        $filters = $this->resolveReportFilters();
        $type = $filters['type'];
        $month = $filters['month'];
        $year = $filters['year'];
        $category = $filters['category'];
        $payload = $this->getReportPayload($type, $month, $year, $category);

        if ($type === 'incoming') {
            $filename = 'laporan-barang-masuk.xls';
        } elseif ($type === 'outgoing') {
            $filename = 'laporan-barang-keluar.xls';
        } else {
            $filename = 'laporan-data-barang.xls';
        }

        header('Content-Type: application/vnd.ms-excel; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        echo "\xEF\xBB\xBF";
        ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #1f2937;
        }

        .report-title {
            font-size: 18px;
            font-weight: bold;
        }

        .report-meta {
            color: #4b5563;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th {
            background: #eaf1f8;
            border: 1px solid #9ca3af;
            font-weight: bold;
            text-align: left;
        }

        td {
            border: 1px solid #d1d5db;
        }

        th,
        td {
            padding: 8px;
            vertical-align: top;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .total-label,
        .total-value {
            background: #f8fafc;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="report-title"><?= e(APP_NAME) ?></div>
    <div><?= e($payload['label']) ?></div>
    <div class="report-meta">Periode: <?= e($payload['periodLabel']) ?></div>
    <div class="report-meta">Kategori: <?= e($payload['categoryLabel']) ?></div>
    <div class="report-meta">Diekspor: <?= e(date('d M Y H:i')) ?></div>
    <br>

    <table>
        <thead>
            <tr>
                <?php foreach ($payload['columns'] as $column): ?>
                    <th class="<?= e($this->excelAlignClass($column['align'] ?? 'left')) ?>">
                        <?= e($column['label']) ?>
                    </th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($payload['tableRows'] as $values): ?>
                <tr>
                    <?php foreach ($values as $index => $value): ?>
                        <?php $align = $payload['columns'][$index]['align'] ?? 'left'; ?>
                        <td class="<?= e($this->excelAlignClass($align)) ?>">
                            <?= e((string) $value) ?>
                        </td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <?php if ($type !== 'products'): ?>
            <tfoot>
                <tr>
                    <td class="total-label text-right" colspan="6">Total Keseluruhan</td>
                    <td class="total-value" colspan="2"><?= e(format_currency($payload['totalSubtotal'])) ?></td>
                </tr>
            </tfoot>
        <?php endif; ?>
    </table>
</body>
</html>
        <?php
        exit;
    }

    private function excelAlignClass(string $align): string
    {
        return match ($align) {
            'right' => 'text-right',
            'center' => 'text-center',
            default => '',
        };
    }
}
