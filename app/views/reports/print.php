<?php
/** @var string $title */
/** @var string $periodLabel */
/** @var string $categoryLabel */
/** @var string $printedAt */
/** @var array $columns */
/** @var array $tableRows */
/** @var string $type */
/** @var float $totalSubtotal */
?>
<div class="print-toolbar no-print">
    <button class="btn btn-outline-secondary" onclick="window.print()">Print</button>
</div>

<div class="print-report">
    <div class="print-header">
        <div class="print-brand">
            <img src="<?= e(asset('assets/images/logo-autohub-sm.png')) ?>" alt="Logo Polije AutoHub">
            <div>
                <h1><?= e(APP_NAME) ?></h1>
                <p>Sistem Manajemen Inventaris TEFA AutoHub</p>
            </div>
        </div>
        <div class="print-meta">
            <div><strong>Jenis Laporan:</strong> <?= e($title) ?></div>
            <div><strong>Periode:</strong> <?= e($periodLabel) ?></div>
            <div><strong>Kategori:</strong> <?= e($categoryLabel) ?></div>
            <div><strong>Dicetak:</strong> <?= e($printedAt) ?></div>
        </div>
    </div>

    <div class="print-divider"></div>

    <table class="table table-bordered print-table">
        <thead>
            <tr>
                <?php foreach ($columns as $column): ?>
                    <th class="<?= e(($column['align'] ?? '') === 'right' ? 'text-end' : (($column['align'] ?? '') === 'center' ? 'text-center' : '')) ?>">
                        <?= e($column['label']) ?>
                    </th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tableRows as $values): ?>
                <tr>
                    <?php foreach ($values as $index => $value): ?>
                        <?php $align = $columns[$index]['align'] ?? ''; ?>
                        <td class="<?= e($align === 'right' ? 'text-end' : ($align === 'center' ? 'text-center' : '')) ?>">
                            <?= e((string) $value) ?>
                        </td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <?php if ($type !== 'products'): ?>
            <tfoot>
                <tr>
                    <td colspan="6" class="text-end"><strong>Total Keseluruhan</strong></td>
                    <td colspan="2"><strong><?= e(format_currency($totalSubtotal)) ?></strong></td>
                </tr>
            </tfoot>
        <?php endif; ?>
    </table>
</div>
