<?php

class Dashboard extends Model
{
    public function summary(): array
    {
        $productModel = new Product();
        $supplierModel = new Supplier();
        $incomingModel = new IncomingTransaction();
        $outgoingModel = new OutgoingTransaction();
        $currentYear = (int) date('Y');

        return [
            'total_barang' => $productModel->totalItems(),
            'total_supplier' => $supplierModel->totalItems(),
            'barang_masuk' => $incomingModel->totalQuantity(),
            'barang_keluar' => $outgoingModel->totalQuantity(),
            'stok_minim' => count($productModel->lowStock()),
            'chart_year' => $currentYear,
            'chart_labels' => array_values(months_list()),
            'chart_incoming' => array_values($incomingModel->monthlyTotals($currentYear)),
            'chart_outgoing' => array_values($outgoingModel->monthlyTotals($currentYear)),
        ];
    }
}
