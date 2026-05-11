<section class="toolbar-row between">
    <form method="get" action="index.php" class="search-form">
        <input type="hidden" name="route" value="suppliers">
        <i class="bi bi-search"></i>
        <input type="text" name="q" value="<?= e($keyword) ?>" placeholder="Cari nama, telepon, alamat, atau email supplier...">
    </form>
    <?php if (is_admin()): ?>
        <a href="<?= e(route('suppliers/create')) ?>" class="btn btn-green">+ Tambah Supplier</a>
    <?php endif; ?>
</section>

<section class="table-shell">
    <table class="table app-table align-middle mb-0">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Supplier</th>
                <th>Telepon</th>
                <th>Alamat</th>
                <?php if (is_admin()): ?><th>Aksi</th><?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($suppliers as $index => $supplier): ?>
                <tr>
                    <td><?= e((string) ($index + 1)) ?></td>
                    <td><?= e($supplier['nama_supplier']) ?></td>
                    <td><?= e($supplier['telepon']) ?></td>
                    <td><?= e($supplier['alamat']) ?></td>
                    <?php if (is_admin()): ?>
                        <td class="action-cell">
                            <a href="<?= e(route('suppliers/edit') . '&id=' . $supplier['id_supplier']) ?>" class="icon-btn warning"><i class="bi bi-pencil-fill"></i></a>
                            <a href="<?= e(route('suppliers/delete') . '&id=' . $supplier['id_supplier']) ?>" class="icon-btn danger" onclick="return confirm('Hapus data supplier ini?')"><i class="bi bi-trash-fill"></i></a>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>
