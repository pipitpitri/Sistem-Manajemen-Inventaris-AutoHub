<div class="modal-page-overlay">
    <div class="modal-form-card">
        <div class="modal-form-header">
            <h2><?= e($modalTitle ?? 'Form Supplier') ?></h2>
            <a href="<?= e(route($cancelRoute ?? 'suppliers')) ?>" class="modal-close-btn" aria-label="Tutup">
                <i class="bi bi-x-circle"></i>
            </a>
        </div>

        <form method="post" action="<?= e(route($action)) ?>">
            <div class="modal-form-body">
                <div class="modal-field full">
                    <label>Nama Supplier</label>
                    <input type="text" name="nama_supplier" class="app-input" placeholder="Masukkan nama supplier..." value="<?= e($supplier['nama_supplier'] ?? old('nama_supplier')) ?>" required>
                </div>

                <div class="modal-field full">
                    <label>Telepon</label>
                    <input type="text" name="telepon" class="app-input" placeholder="Masukkan nomor telepon..." value="<?= e($supplier['telepon'] ?? old('telepon')) ?>" required>
                </div>

                <div class="modal-field full">
                    <label>Alamat</label>
                    <textarea name="alamat" class="app-input app-textarea" rows="4" placeholder="Masukkan alamat supplier..." required><?= e($supplier['alamat'] ?? old('alamat')) ?></textarea>
                </div>
            </div>

            <div class="modal-form-footer">
                <a href="<?= e(route($cancelRoute ?? 'suppliers')) ?>" class="btn-modal-secondary">Batal</a>
                <button class="btn-modal-primary"><i class="bi bi-check-lg me-2"></i>Simpan</button>
            </div>
        </form>
    </div>
</div>
