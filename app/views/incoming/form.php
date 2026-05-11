<?php
/** @var array $products */
/** @var string $action */
/** @var string|null $modalTitle */
/** @var string|null $cancelRoute */
?>
<div class="modal-page-overlay">
    <div class="modal-form-card">
        <div class="modal-form-header">
            <h2><?= e($modalTitle ?? 'Input Barang Masuk') ?></h2>
            <a href="<?= e(route($cancelRoute ?? 'incoming')) ?>" class="modal-close-btn" aria-label="Tutup">
                <i class="bi bi-x-circle"></i>
            </a>
        </div>

        <form method="post" action="<?= e(route($action)) ?>">
            <div class="modal-form-body">
                <?php
                $showStock = false;
                require __DIR__ . '/../partials/product_search_field.php';
                ?>

                <div class="modal-field">
                    <label>Jumlah</label>
                    <input type="number" name="jumlah" class="app-input" min="1" placeholder="Masukkan jumlah..." required>
                </div>

                <div class="modal-field">
                    <label>Tanggal</label>
                    <input type="date" name="tanggal" class="app-input" value="<?= e(date('Y-m-d')) ?>" required>
                </div>
            </div>

            <div class="modal-form-footer">
                <a href="<?= e(route($cancelRoute ?? 'incoming')) ?>" class="btn-modal-secondary">Batal</a>
                <button class="btn-modal-primary"><i class="bi bi-check-lg me-2"></i>Simpan</button>
            </div>
        </form>
    </div>
</div>
