<?php
class App
{
    public function run(): void
    {
        Seeder::run();

        $route = trim($_GET['route'] ?? '', '/');
        $segments = $route === '' ? [] : explode('/', $route);

        $controllerName = $segments[0] ?? 'dashboard';
        $action = $segments[1] ?? 'index';

        $actionAliases = [
            'masuk' => 'index',
            'keluar' => 'logout',
            'tambah' => 'create',
            'simpan' => 'store',
            'ubah' => 'edit',
            'perbarui' => 'update',
            'hapus' => 'delete',
            'cetak' => 'print',
            'ekspor' => 'export',
        ];

        if (isset($actionAliases[$action])) {
            $action = $actionAliases[$action];
        }

        if ($controllerName === 'login') {
            $controllerName = 'auth';
            $action = 'showLogin';
        }

        if ($controllerName === 'logout') {
            $controllerName = 'auth';
            $action = 'logout';
        }

        if ($controllerName === 'masuk') {
            $controllerName = 'auth';
            $action = 'showLogin';
        }

        $map = [
            'auth' => 'AuthController',
            'dashboard' => 'DashboardController',
            'dasbor' => 'DashboardController',
            'products' => 'ProductController',
            'barang' => 'ProductController',
            'suppliers' => 'SupplierController',
            'pemasok' => 'SupplierController',
            'incoming' => 'IncomingController',
            'barang-masuk' => 'IncomingController',
            'outgoing' => 'OutgoingController',
            'barang-keluar' => 'OutgoingController',
            'stock' => 'StockController',
            'stok' => 'StockController',
            'reports' => 'ReportController',
            'laporan' => 'ReportController',
        ];

        if (!isset($map[$controllerName])) {
            http_response_code(404);
            echo 'Page not found';
            return;
        }

        $controllerClass = $map[$controllerName];
        $controller = new $controllerClass();

        if (!method_exists($controller, $action)) {
            http_response_code(404);
            echo 'Action not found';
            return;
        }

        $controller->{$action}();
    }
}
