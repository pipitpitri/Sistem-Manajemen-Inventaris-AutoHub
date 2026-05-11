<section class="toolbar-row between">
    <form method="get" action="index.php" class="search-form">
        <input type="hidden" name="route" value="products">
        <input type="hidden" name="category" value="<?= e($selectedCategory) ?>">
        <input type="hidden" name="month" value="<?= e((string) $selectedMonth) ?>">
        <input type="hidden" name="year" value="<?= e((string) $selectedYear) ?>">
        <i class="bi bi-search"></i>
        <input type="text" name="q" value="<?= e($keyword) ?>" placeholder="Cari Kode atau Nama Barang">
    </form>
    <form method="get" action="index.php" class="filter-inline products-filter-form">
        <input type="hidden" name="route" value="products">
        <input type="hidden" name="q" value="<?= e($keyword) ?>">
        <select name="category" class="app-select" onchange="this.form.submit()">
            <option value="">Semua Kategori</option>
            <?php foreach ($categories as $category): ?>
                <option value="<?= e($category) ?>" <?= selected($selectedCategory, $category) ?>><?= e($category) ?></option>
            <?php endforeach; ?>
        </select>
        <select name="month" class="app-select" onchange="this.form.submit()">
            <?php foreach (months_list() as $monthNumber => $monthName): ?>
                <option value="<?= e((string) $monthNumber) ?>" <?= selected($selectedMonth, $monthNumber) ?>><?= e($monthName) ?></option>
            <?php endforeach; ?>
        </select>
        <select name="year" class="app-select" onchange="this.form.submit()">
            <?php foreach ($years as $year): ?>
                <option value="<?= e((string) $year) ?>" <?= selected($selectedYear, $year) ?>><?= e((string) $year) ?></option>
            <?php endforeach; ?>
        </select>
    </form>
    <?php if (is_admin()): ?>
        <a href="<?= e(route('products/create')) ?>" class="btn btn-green">+ Tambah Barang</a>
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
                            <a href="<?= e(route('products/edit') . '&id=' . $product['id_barang']) ?>" class="icon-btn warning"><i class="bi bi-pencil-fill"></i></a>
                            <a href="<?= e(route('products/delete') . '&id=' . $product['id_barang']) ?>" class="icon-btn danger" onclick="return confirm('Hapus data barang ini?')"><i class="bi bi-trash-fill"></i></a>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>
