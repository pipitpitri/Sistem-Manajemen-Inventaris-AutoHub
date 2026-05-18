<?php
/** @var string $action */
?>
<?php
$modalId = $modalId ?? null;
$modalHidden = $modalHidden ?? false;
?>
<div class="modal-page-overlay"<?= $modalId ? ' id="' . e($modalId) . '"' : '' ?><?= $modalHidden ? ' hidden' : '' ?>>
    <div class="modal-form-card">
        <div class="modal-form-header">
            <h2><?= e($modalTitle ?? 'Input Barang Keluar') ?></h2>
            <a href="<?= e(route($cancelRoute ?? 'outgoing')) ?>" class="modal-close-btn" aria-label="Tutup" data-modal-close>
                <i class="bi bi-x-circle"></i>
            </a>
        </div>

        <form method="post" action="<?= e(route($action)) ?>">
            <div class="modal-form-body">
                <?php
                $showStock = true;
                require __DIR__ . '/../partials/product_search_field.php';
                ?>

                <div class="modal-field">
                    <label>Jumlah</label>
                    <input type="number" name="jumlah" class="app-input" min="1" placeholder="Masukkan jumlah..." required>
                </div>

                <div class="modal-field">
                    <label>Keterangan</label>
                    <select name="jenis" class="app-input app-select-input" required>
                        <option value="terjual">Terjual</option>
                        <option value="terpakai">Terpakai</option>
                    </select>
                </div>

                <div class="modal-field full">
                    <label>Tanggal</label>
                    <input type="date" name="tanggal" class="app-input" value="<?= e(date('Y-m-d')) ?>" required>
                </div>
            </div>

            <div class="modal-form-footer">
                <a href="<?= e(route($cancelRoute ?? 'outgoing')) ?>" class="btn-modal-secondary" data-modal-close>Batal</a>
                <button class="btn-modal-primary"><i class="bi bi-check-lg me-2"></i>Simpan</button>
            </div>
        </form>
    </div>
</div>
