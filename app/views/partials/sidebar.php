<aside class="sidebar">
    <div class="sidebar-brand justify-content-center flex-column text-center">
        <img src="<?= e(asset('assets/images/logo-autohub-sm.png')) ?>" alt="Logo Polije AutoHub" class="brand-logo-image">
    </div>

    <nav class="sidebar-nav">
        <a class="sidebar-link <?= route_is('dashboard') || route_is('dasbor') || current_route() === '' ? 'active' : '' ?>" href="<?= e(route('dasbor')) ?>">
            <i class="bi bi-house-door"></i><span>Dashboard</span>
        </a>

        <div class="sidebar-group">
            <div class="sidebar-group-title">
                <span><i class="bi bi-window"></i>Master</span>
                <i class="bi bi-caret-down-fill"></i>
            </div>
            <a class="sidebar-link sub <?= route_starts_with('products') || route_starts_with('barang') ? 'active' : '' ?>" href="<?= e(route('barang')) ?>">
                <i class="bi bi-box"></i><span>Data Barang</span>
            </a>
            <a class="sidebar-link sub <?= route_starts_with('suppliers') || route_starts_with('pemasok') ? 'active' : '' ?>" href="<?= e(route('pemasok')) ?>">
                <i class="bi bi-truck"></i><span>Data Supplier</span>
            </a>
        </div>

        <div class="sidebar-group">
            <div class="sidebar-group-title">
                <span><i class="bi bi-tags"></i>Transaksi</span>
                <i class="bi bi-caret-down-fill"></i>
            </div>
            <a class="sidebar-link sub <?= route_starts_with('incoming') || route_starts_with('barang-masuk') ? 'active' : '' ?>" href="<?= e(route('barang-masuk')) ?>">
                <i class="bi bi-clipboard-check"></i><span>Barang Masuk</span>
            </a>
            <a class="sidebar-link sub <?= route_starts_with('outgoing') || route_starts_with('barang-keluar') ? 'active' : '' ?>" href="<?= e(route('barang-keluar')) ?>">
                <i class="bi bi-x-circle"></i><span>Barang Keluar</span>
            </a>
        </div>

        <a class="sidebar-link <?= route_starts_with('stock') || route_starts_with('stok') ? 'active' : '' ?>" href="<?= e(route('stok')) ?>">
            <i class="bi bi-bar-chart"></i><span>Stok Barang</span>
        </a>
        <a class="sidebar-link <?= route_starts_with('reports') || route_starts_with('laporan') ? 'active' : '' ?>" href="<?= e(route('laporan')) ?>">
            <i class="bi bi-file-earmark-text"></i><span>Laporan</span>
        </a>
    </nav>

    <a class="logout-button" href="<?= e(route('logout')) ?>">
        <i class="bi bi-box-arrow-left"></i> Keluar
    </a>
</aside>
