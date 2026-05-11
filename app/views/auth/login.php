<div class="login-screen">
    <div class="login-hero">
        <div class="login-hero-inner">
            <img src="<?= e(asset('assets/images/logo-autohub-sm.png')) ?>" alt="Logo Polije AutoHub" class="login-logo-image">
            <p class="login-hero-caption">Sistem inventori bengkel dan sparepart dengan alur yang rapi, cepat, dan mudah dipantau.</p>
        </div>
    </div>

    <div class="login-panel">
        <div class="login-card simple">
            <div class="login-card-header">
                <span class="login-eyebrow">TEFA AutoHub Inventory</span>
                <h2 class="login-title">Masuk ke Sistem</h2>
                <p class="login-subtitle">Gunakan akun Anda untuk mengakses dashboard inventaris.</p>
            </div>

            <div class="login-form-shell simple">
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
                <?php require __DIR__ . '/../partials/alerts.php'; ?>

                <form method="post" action="<?= e(route('auth/index')) ?>">
                    <div class="mb-3">
                        <label class="form-label"><i class="bi bi-person me-2"></i>Username</label>
                        <input type="text" name="username" class="form-control" placeholder="Masukkan Username" value="<?= e(old('username')) ?>" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label"><i class="bi bi-lock me-2"></i>Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Masukkan Password" required>
                    </div>
                    <button class="btn btn-login w-100"><i class="bi bi-box-arrow-in-right me-2"></i>LOGIN</button>
                </form>
                <div class="login-footer">2026 Tefa Autohub</div>
            </div>
        </div>
    </div>
</div>
