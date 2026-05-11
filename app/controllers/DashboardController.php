<?php

class DashboardController extends BaseController
{
    public function index(): void
    {
        $this->authRequired();

        $dashboard = new Dashboard();
        $productModel = new Product();

        $this->render('dashboard/index', [
            'title' => 'Dashboard',
            'summary' => $dashboard->summary(),
            'lowStockProducts' => $productModel->lowStock(),
            'stockOverview' => array_slice($productModel->all(), 0, 6),
        ]);
    }
}
