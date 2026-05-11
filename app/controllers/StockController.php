<?php

class StockController extends BaseController
{
    public function index(): void
    {
        $this->authRequired();

        $keyword = trim($_GET['q'] ?? '');
        $productModel = new Product();

        $this->render('stock/index', [
            'title' => 'Stok Barang',
            'keyword' => $keyword,
            'products' => $productModel->stockStatusList($keyword),
        ]);
    }
}
