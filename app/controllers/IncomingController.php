<?php

class IncomingController extends BaseController
{
    private IncomingTransaction $incomingModel;
    private Product $productModel;

    public function __construct()
    {
        $this->incomingModel = new IncomingTransaction();
        $this->productModel = new Product();
    }

    public function index(): void
    {
        $this->authRequired();
        $month = (int) ($_GET['month'] ?? 0);
        $year = (int) ($_GET['year'] ?? date('Y'));

        $this->render('incoming/index', [
            'title' => 'Barang Masuk',
            'selectedMonth' => $month,
            'selectedYear' => $year,
            'years' => range((int) date('Y') - 4, (int) date('Y') + 1),
            'transactions' => $this->incomingModel->all($month ?: null, $year ?: null),
            'products' => $this->productModel->all(),
        ]);
    }

    public function create(): void
    {
        $this->adminRequired();

        $this->render('incoming/form', [
            'title' => 'Barang Masuk',
            'modalTitle' => 'Input Barang Masuk',
            'products' => $this->productModel->all(),
            'action' => 'barang-masuk/simpan',
            'cancelRoute' => 'barang-masuk',
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

            $this->incomingModel->create([
                'id_barang' => $productId,
                'jumlah' => $jumlah,
                'tanggal' => $_POST['tanggal'] ?? date('Y-m-d'),
            ]);
            flash('success', 'Barang masuk berhasil disimpan dan stok diperbarui.');
        } catch (Throwable $exception) {
            flash('error', $exception->getMessage());
        }

        redirect('barang-masuk');
    }
}
