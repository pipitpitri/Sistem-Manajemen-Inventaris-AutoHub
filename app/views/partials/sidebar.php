<?php
$role = $_SESSION['user']['role'] ?? 'User';
?>
<aside class="sidebar">
    <div class="sidebar-brand justify-content-center flex-column text-center">
        <img src="<?= e(asset('assets/images/logo-autohub-sm.png')) ?>" 
             alt="Logo Polije AutoHub" 
             class="brand-logo-image">
    </div>

    <nav class="sidebar-nav">

        <!-- Dashboard -->
        <a class="sidebar-link <?= route_is('dashboard') || route_is('dasbor') || current_route() === '' ? 'active' : '' ?>" 
           href="<?= e(route('dasbor')) ?>">
            <i class="bi bi-house-door"></i>
            <span>Dashboard</span>
        </a>

        <!-- MASTER -->
        <?php
        $masterOpen =
            route_starts_with('products') ||
            route_starts_with('barang') ||
            route_starts_with('suppliers') ||
            route_starts_with('pemasok');
        ?>

        <div class="sidebar-group">
            <button class="sidebar-group-title <?= $masterOpen ? 'open' : '' ?>" 
                    type="button"
                    data-target="masterMenu">

                <span>
                    <i class="bi bi-window"></i> Master
                </span>

                <i class="bi bi-caret-down-fill accordion-icon"></i>
            </button>

            <div class="sidebar-submenu <?= $masterOpen ? 'show' : '' ?>" 
                 id="masterMenu">

                <a class="sidebar-link sub <?= route_starts_with('products') || route_starts_with('barang') ? 'active' : '' ?>" 
                   href="<?= e(route('barang')) ?>">
                    <i class="bi bi-box"></i>
                    <span>Data Barang</span>
                </a>

                <a class="sidebar-link sub <?= route_starts_with('suppliers') || route_starts_with('pemasok') ? 'active' : '' ?>" 
                   href="<?= e(route('pemasok')) ?>">
                    <i class="bi bi-truck"></i>
                    <span>Data Supplier</span>
                </a>

            </div>
        </div>

        <!-- TRANSAKSI -->
        <?php
        $transaksiOpen =
            route_starts_with('incoming') ||
            route_starts_with('barang-masuk') ||
            route_starts_with('outgoing') ||
            route_starts_with('barang-keluar');
        ?>

        <div class="sidebar-group">
            <button class="sidebar-group-title <?= $transaksiOpen ? 'open' : '' ?>" 
                    type="button"
                    data-target="transaksiMenu">

                <span>
                    <i class="bi bi-tags"></i> Transaksi
                </span>

                <i class="bi bi-caret-down-fill accordion-icon"></i>
            </button>

            <div class="sidebar-submenu <?= $transaksiOpen ? 'show' : '' ?>" 
                 id="transaksiMenu">

                <a class="sidebar-link sub <?= route_starts_with('incoming') || route_starts_with('barang-masuk') ? 'active' : '' ?>" 
                   href="<?= e(route('barang-masuk')) ?>">
                    <i class="bi bi-clipboard-check"></i>
                    <span>Barang Masuk</span>
                </a>

                <a class="sidebar-link sub <?= route_starts_with('outgoing') || route_starts_with('barang-keluar') ? 'active' : '' ?>" 
                   href="<?= e(route('barang-keluar')) ?>">
                    <i class="bi bi-x-circle"></i>
                    <span>Barang Keluar</span>
                </a>

            </div>
        </div>

        <!-- Stok -->
        <a class="sidebar-link <?= route_starts_with('stock') || route_starts_with('stok') ? 'active' : '' ?>" 
           href="<?= e(route('stok')) ?>">
            <i class="bi bi-bar-chart"></i>
            <span>Stok Barang</span>
        </a>

        <!-- Laporan -->
        <a class="sidebar-link <?= route_starts_with('reports') || route_starts_with('laporan') ? 'active' : '' ?>" 
           href="<?= e(route('laporan')) ?>">
            <i class="bi bi-file-earmark-text"></i>
            <span>Laporan</span>
        </a>

    </nav>

    <button type="button" class="logout-button" id="btn-logout">
    <i class="bi bi-box-arrow-left"></i>
    Keluar
</button>
<!-- Overlay -->
<div class="logout-overlay" id="logoutOverlay"></div>

<!-- Alert Logout -->
<div class="logout-alert" id="logoutAlert">
    <div class="logout-alert-icon">
        <i class="bi bi-exclamation-triangle-fill"></i>
    </div>

    <h5>Konfirmasi Logout</h5>

    <p>
        Apakah Anda yakin ingin logout sebagai
        <strong><?= ucfirst($role) ?></strong>
    </p>

    <div class="logout-actions">
        <button type="button" class="btn btn-secondary" id="cancelLogout">
            Kembali
        </button>

        <button type="button" class="btn btn-danger" id="confirmLogout">
            OK
        </button>
    </div>
</div>
</aside>