<?php
/** @var array $products */
/** @var array $categories */
/** @var string $keyword */
/** @var string|null $selectedCategory */
?>
<section class="toolbar-row between">
    <form method="get" action="index.php" class="products-toolbar-left">
        <div class="search-form">
            <input type="hidden" name="route" value="products">
            <i class="bi bi-search"></i>
            <input type="text" name="q" value="<?= e($keyword) ?>" placeholder="Cari Kode atau Nama Barang">
        </div>
        <select name="category" class="app-select products-category-select" onchange="this.form.submit()">
            <option value="">Semua Kategori</option>
            <?php foreach ($categories as $category): ?>
                <option value="<?= e($category) ?>" <?= selected($selectedCategory, $category) ?>><?= e($category) ?></option>
            <?php endforeach; ?>
        </select>
    </form>
    <?php if (is_admin()): ?>
        <a href="<?= e(route('products/create')) ?>" class="btn btn-green" data-modal-target="product-create-modal">+ Tambah Barang</a>
    <?php endif; ?>
</section>

<section class="table-shell">
    <table class="table app-table align-middle mb-0">
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Stok</th>
                <th>Harga</th>
                <th>Supplier</th>
                <?php if (is_admin()): ?><th>Aksi</th><?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?= e($product['kode_barang']) ?></td>
                    <td><?= e($product['nama_barang']) ?></td>
                    <td><?= e($product['kategori']) ?></td>
                    <td><?= e((string) $product['stok']) ?></td>
                    <td><?= e(format_currency($product['harga'])) ?></td>
                    <td><?= e($product['nama_supplier'] ?? '-') ?></td>
                    <?php if (is_admin()): ?>
                        <td class="action-cell">
                            <a href="<?= e(route('products/edit') . '&id=' . $product['id_barang']) ?>" class="icon-btn warning" data-modal-target="product-edit-modal-<?= e((string) $product['id_barang']) ?>"><i class="bi bi-pencil-fill"></i></a>
                            <a href="<?= e(route('products/delete') . '&id=' . $product['id_barang']) ?>" class="icon-btn danger" onclick="return confirm('Hapus data barang ini?')"><i class="bi bi-trash-fill"></i></a>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>

<?php if (is_admin()): ?>
    <?php
    $modalId = 'product-create-modal';
    $modalHidden = true;
    $modalTitle = 'Tambah Barang';
    $product = null;
    $action = 'products/store';
    $cancelRoute = 'products';
    require __DIR__ . '/form.php';

    foreach ($products as $modalProduct) {
        $modalId = 'product-edit-modal-' . $modalProduct['id_barang'];
        $modalHidden = true;
        $modalTitle = 'Edit Barang';
        $product = $modalProduct;
        $action = 'products/update&id=' . $modalProduct['id_barang'];
        $cancelRoute = 'products';
        require __DIR__ . '/form.php';
    }
    ?>
<?php endif; ?>
