<?php
/** @var array $products */
/** @var string $keyword */
?>
<section class="toolbar-row">
    <form method="get" action="index.php" class="search-form">
        <input type="hidden" name="route" value="stock">
        <i class="bi bi-search"></i>
        <input type="text" name="q" value="<?= e($keyword) ?>" placeholder="Cari Kode atau Nama Barang">
    </form>
</section>

<section class="table-shell">
    <table class="table app-table align-middle mb-0">
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Stok</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?= e($product['kode_barang']) ?></td>
                    <td><?= e($product['nama_barang']) ?></td>
                    <td><?= e($product['kategori']) ?></td>
                    <td><?= e((string) $product['stok']) ?></td>
                    <td>
                        <span class="status-pill <?= (int) $product['stok'] < STOCK_MINIMUM_ALERT ? 'low' : 'safe' ?>">
                            <?= (int) $product['stok'] < STOCK_MINIMUM_ALERT ? 'Menipis' : 'Aman' ?>
                        </span>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>
