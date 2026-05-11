<div class="modal-page-overlay">
    <div class="modal-form-card modal-form-product">
        <div class="modal-form-header">
            <h2><?= e($modalTitle ?? 'Form Barang') ?></h2>
            <a href="<?= e(route($cancelRoute ?? 'products')) ?>" class="modal-close-btn" aria-label="Tutup">
                <i class="bi bi-x-circle"></i>
            </a>
        </div>

        <?php
        $selectedCategory = $product['kategori'] ?? old('kategori');
        $isEdit = !empty($product);
        ?>
        <form method="post" action="<?= e(route($action)) ?>">
            <div class="modal-form-body">
                <div class="modal-field">
                    <label>Kode Barang</label>
                    <input
                        type="text"
                        name="kode_barang"
                        class="app-input"
                        placeholder="Kode dibuat otomatis setelah kategori dipilih"
                        value="<?= e($product['kode_barang'] ?? old('kode_barang')) ?>"
                        data-code-input
                        readonly
                        required
                    >
                </div>

                <div class="modal-field">
                    <label>Nama Barang</label>
                    <input type="text" name="nama_barang" class="app-input" placeholder="Masukkan nama barang..." value="<?= e($product['nama_barang'] ?? old('nama_barang')) ?>" required>
                </div>

                <div class="modal-field">
                    <label>Kategori</label>
                    <select name="kategori" class="app-input app-select-input" data-category-select required>
                        <option value="">-- Pilih Kategori --</option>
                        <?php foreach (['Sparepart', 'Oli', 'Ban'] as $category): ?>
                            <option value="<?= e($category) ?>" <?= selected($selectedCategory, $category) ?>>
                                <?= e($category) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="modal-field">
                    <label>Jumlah Stok</label>
                    <input type="number" name="stok" class="app-input" min="0" placeholder="Masukkan jumlah stok..." value="<?= e((string) ($product['stok'] ?? old('stok', '0'))) ?>" required>
                </div>

                <div class="modal-field">
                    <label>Harga</label>
                    <input type="number" name="harga" class="app-input" min="0" step="0.01" placeholder="Masukkan harga barang..." value="<?= e((string) ($product['harga'] ?? old('harga', '0'))) ?>" required>
                </div>

                <div class="modal-field full">
                    <label>Supplier</label>
                    <select name="id_supplier" class="app-input app-select-input" required>
                        <option value="">-- Pilih Supplier --</option>
                        <?php foreach ($suppliers as $supplier): ?>
                            <?php $selected = (int) ($product['id_supplier'] ?? old('id_supplier', '0')) === (int) $supplier['id_supplier']; ?>
                            <option value="<?= e((string) $supplier['id_supplier']) ?>" <?= $selected ? 'selected' : '' ?>>
                                <?= e($supplier['nama_supplier']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="modal-form-footer">
                <a href="<?= e(route($cancelRoute ?? 'products')) ?>" class="btn-modal-secondary">Batal</a>
                <button class="btn-modal-primary"><i class="bi bi-check-lg me-2"></i>Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
(() => {
    const nextCodes = <?= json_encode($nextCodes ?? [], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) ?>;
    const originalCategory = <?= json_encode($product['kategori'] ?? '', JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) ?>;
    const originalCode = <?= json_encode($product['kode_barang'] ?? '', JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) ?>;
    const isEdit = <?= $isEdit ? 'true' : 'false' ?>;
    const categorySelect = document.querySelector('[data-category-select]');
    const codeInput = document.querySelector('[data-code-input]');

    if (!categorySelect || !codeInput) {
        return;
    }

    const syncCode = () => {
        const category = categorySelect.value;

        if (isEdit && category === originalCategory) {
            codeInput.value = originalCode;
            return;
        }

        codeInput.value = nextCodes[category] || '';
    };

    categorySelect.addEventListener('change', syncCode);
    syncCode();
})();
</script>
