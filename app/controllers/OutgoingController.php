<?php

class OutgoingController extends BaseController
{
    private OutgoingTransaction $outgoingModel;
    private Product $productModel;

    public function __construct()
    {
        $this->outgoingModel = new OutgoingTransaction();
        $this->productModel = new Product();
    }

    public function index(): void
    {
        $this->authRequired();
        $month = (int) ($_GET['month'] ?? 0);
        $year = (int) ($_GET['year'] ?? date('Y'));

        $this->render('outgoing/index', [
            'title' => 'Barang Keluar',
            'selectedMonth' => $month,
            'selectedYear' => $year,
            'years' => range((int) date('Y') - 4, (int) date('Y') + 1),
            'transactions' => $this->outgoingModel->all($month ?: null, $year ?: null),
            'products' => $this->productModel->all(),
        ]);
    }

    public function create(): void
    {
        $this->adminRequired();

        $this->render('outgoing/form', [
            'title' => 'Barang Keluar',
            'modalTitle' => 'Input Barang Keluar',
            'products' => $this->productModel->all(),
            'action' => 'barang-keluar/simpan',
            'cancelRoute' => 'barang-keluar',
        ]);
    }

    public function store(): void
    {
        $this->adminRequired();

        try {
            $jumlah = max(1, (int) ($_POST['jumlah'] ?? 0));
            $productId = (int) ($_POST['id_barang'] ?? 0);

            if ($productId <= 0) {
                throw new RuntimeException('Silakan pilih barang dari hasil pencarian.');
            }

            $this->outgoingModel->create([
                'id_barang' => $productId,
                'jumlah' => $jumlah,
                'jenis' => $_POST['jenis'] ?? 'terjual',
                'tanggal' => $_POST['tanggal'] ?? date('Y-m-d'),
            ]);
            flash('success', 'Barang keluar berhasil disimpan dan stok diperbarui.');
        } catch (Throwable $exception) {
            flash('error', $exception->getMessage());
        }

        redirect('barang-keluar');
    }
}
