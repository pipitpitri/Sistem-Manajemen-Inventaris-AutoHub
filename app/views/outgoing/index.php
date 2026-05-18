<?php
/** @var array $transactions */
/** @var array $years */
/** @var int $selectedMonth */
/** @var int $selectedYear */
?>
<section class="toolbar-row between">
    <form method="get" action="index.php" class="filter-inline">
        <input type="hidden" name="route" value="barang-keluar">
        <select name="month" class="app-select">
            <option value="0">Bulan</option>
            <?php foreach (months_list() as $monthNumber => $monthName): ?>
                <option value="<?= e((string) $monthNumber) ?>" <?= selected($selectedMonth, $monthNumber) ?>><?= e($monthName) ?></option>
            <?php endforeach; ?>
        </select>
        <select name="year" class="app-select">
            <?php foreach ($years as $year): ?>
                <option value="<?= e((string) $year) ?>" <?= selected($selectedYear, $year) ?>><?= e((string) $year) ?></option>
            <?php endforeach; ?>
        </select>
        <button class="btn btn-green">Tampilkan</button>
    </form>
    <?php if (is_admin()): ?>
        <a href="<?= e(route('barang-keluar/tambah')) ?>" class="btn btn-green" data-modal-target="outgoing-create-modal">+ Input Barang Keluar</a>
    <?php endif; ?>
</section>

<section class="table-shell">
    <table class="table app-table align-middle mb-0">
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>SubTotal</th>
                <th>Keterangan</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($transactions as $item): ?>
                <tr>
                    <td><?= e($item['kode_barang']) ?></td>
                    <td><?= e($item['nama_barang']) ?></td>
                    <td><?= e($item['kategori']) ?></td>
                    <td><?= e(format_currency($item['harga'])) ?></td>
                    <td><?= e((string) $item['jumlah']) ?></td>
                    <td><?= e(format_currency($item['subtotal'])) ?></td>
                    <td><?= e(ucfirst($item['keterangan'])) ?></td>
                    <td><?= e(format_date($item['tanggal'])) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>

<?php if (is_admin()): ?>
    <?php
    $modalId = 'outgoing-create-modal';
    $modalHidden = true;
    $modalTitle = 'Input Barang Keluar';
    $action = 'barang-keluar/simpan';
    $cancelRoute = 'barang-keluar';
    require __DIR__ . '/form.php';
    ?>
<?php endif; ?>
