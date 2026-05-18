<?php
/** @var array $rows */
/** @var string $selectedType */
/** @var int $selectedMonth */
/** @var int $selectedYear */
/** @var string|null $selectedCategory */
/** @var array $categories */
/** @var array $years */
/** @var string $heading */
/** @var string $periodLabel */
/** @var string $categoryLabel */
/** @var float $totalSubtotal */
?>
<form method="get" action="index.php" class="report-filter-layout" id="reportFilterForm">
    <input type="hidden" name="route" value="reports">

    <div class="filter-block">
        <label>Filter Periode</label>
        <div class="filter-inline">
            <select name="month" class="app-select" onchange="this.form.submit()">
                <option value="0">Bulan</option>
                <?php foreach (months_list() as $monthNumber => $monthName): ?>
                    <option value="<?= e((string) $monthNumber) ?>" <?= selected($selectedMonth, $monthNumber) ?>><?= e($monthName) ?></option>
                <?php endforeach; ?>
            </select>
            <select name="year" class="app-select" onchange="this.form.submit()">
                <?php foreach ($years as $year): ?>
                    <option value="<?= e((string) $year) ?>" <?= selected($selectedYear, $year) ?>><?= e((string) $year) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="filter-block">
        <label>Jenis Laporan</label>
        <select name="type" class="app-select wide" onchange="this.form.submit()">
            <option value="products" <?= selected($selectedType, 'products') ?>>Laporan Data Barang</option>
            <option value="incoming" <?= selected($selectedType, 'incoming') ?>>Laporan Barang Masuk</option>
            <option value="outgoing" <?= selected($selectedType, 'outgoing') ?>>Laporan Barang Keluar</option>
        </select>
    </div>

    <div class="filter-block">
        <label>Kategori</label>
        <select name="category" class="app-select wide" onchange="this.form.submit()">
            <option value="">Semua Kategori</option>
            <?php foreach ($categories as $category): ?>
                <option value="<?= e($category) ?>" <?= selected($selectedCategory, $category) ?>><?= e($category) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="report-actions">
        <a
            class="btn btn-green"
            href="<?= e(route('reports/print') . '&type=' . $selectedType . '&month=' . $selectedMonth . '&year=' . $selectedYear . '&category=' . urlencode($selectedCategory)) ?>"
            onclick="return openPrintPopup(this.href);"
        >Cetak PDF</a>
        <a class="btn btn-green" href="<?= e(route('reports/export') . '&type=' . $selectedType . '&month=' . $selectedMonth . '&year=' . $selectedYear . '&category=' . urlencode($selectedCategory)) ?>">Export Excel</a>
    </div>
</form>

<div class="panel-card mb-3">
    <div class="d-flex flex-wrap justify-content-between gap-3 align-items-center">
        <div>
            <h3 class="section-title mb-1"><?= e($heading) ?></h3>
            <div class="text-muted">Periode: <?= e($periodLabel) ?></div>
            <div class="text-muted">Kategori: <?= e($categoryLabel) ?></div>
        </div>
        <?php if ($selectedType !== 'products'): ?>
            <div class="text-end">
                <div class="text-muted small">Total Nilai</div>
                <div class="fw-bold fs-5 text-success"><?= e(format_currency($totalSubtotal)) ?></div>
            </div>
        <?php endif; ?>
    </div>
</div>

<section class="table-shell">
    <table class="table app-table align-middle mb-0">
        <thead>
            <?php if ($selectedType === 'incoming'): ?>
                <tr><th>Tanggal</th><th>Kode</th><th>Nama Barang</th><th>Kategori</th><th>Harga</th><th>Jumlah</th><th>Subtotal</th><th>Supplier</th></tr>
            <?php elseif ($selectedType === 'outgoing'): ?>
                <tr><th>Tanggal</th><th>Kode</th><th>Nama Barang</th><th>Kategori</th><th>Harga</th><th>Jumlah</th><th>Subtotal</th><th>Keterangan</th></tr>
            <?php else: ?>
                <tr><th>Kode</th><th>Nama Barang</th><th>Kategori</th><th>Stok</th><th>Harga</th><th>Supplier</th></tr>
            <?php endif; ?>
        </thead>
        <tbody>
            <?php foreach ($rows as $row): ?>
                <?php if ($selectedType === 'incoming'): ?>
                    <tr>
                        <td><?= e(format_date($row['tanggal'])) ?></td>
                        <td><?= e($row['kode_barang']) ?></td>
                        <td><?= e($row['nama_barang']) ?></td>
                        <td><?= e($row['kategori']) ?></td>
                        <td><?= e(format_currency($row['harga'])) ?></td>
                        <td><?= e((string) $row['jumlah']) ?></td>
                        <td><?= e(format_currency($row['subtotal'])) ?></td>
                        <td><?= e($row['nama_supplier']) ?></td>
                    </tr>
                <?php elseif ($selectedType === 'outgoing'): ?>
                    <tr>
                        <td><?= e(format_date($row['tanggal'])) ?></td>
                        <td><?= e($row['kode_barang']) ?></td>
                        <td><?= e($row['nama_barang']) ?></td>
                        <td><?= e($row['kategori']) ?></td>
                        <td><?= e(format_currency($row['harga'])) ?></td>
                        <td><?= e((string) $row['jumlah']) ?></td>
                        <td><?= e(format_currency($row['subtotal'])) ?></td>
                        <td><?= e(ucfirst($row['keterangan'])) ?></td>
                    </tr>
                <?php else: ?>
                    <tr>
                        <td><?= e($row['kode_barang']) ?></td>
                        <td><?= e($row['nama_barang']) ?></td>
                        <td><?= e($row['kategori']) ?></td>
                        <td><?= e((string) $row['stok']) ?></td>
                        <td><?= e(format_currency($row['harga'])) ?></td>
                        <td><?= e($row['nama_supplier']) ?></td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>

<script>
function openPrintPopup(url) {
    const width = 980;
    const height = 760;
    const left = Math.max(0, Math.round((window.screen.width - width) / 2));
    const top = Math.max(0, Math.round((window.screen.height - height) / 2));
    const features = [
        'width=' + width,
        'height=' + height,
        'left=' + left,
        'top=' + top,
        'resizable=yes',
        'scrollbars=yes',
        'toolbar=no',
        'menubar=no',
        'location=no',
        'status=no'
    ].join(',');

    const popup = window.open(url, 'report_print_popup', features);

    if (popup) {
        popup.focus();
        return false;
    }

    window.location.href = url;
    return false;
}

</script>
