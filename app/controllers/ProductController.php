<?php

class ProductController extends BaseController
{
    private Product $productModel;
    private Supplier $supplierModel;

    public function __construct()
    {
        $this->productModel = new Product();
        $this->supplierModel = new Supplier();
    }

    public function index(): void
    {
        $this->authRequired();
        $keyword = trim($_GET['q'] ?? '');
        $month = (int) ($_GET['month'] ?? date('n'));
        $year = (int) ($_GET['year'] ?? date('Y'));
        $category = trim($_GET['category'] ?? '');

        $this->render('products/index', [
            'title' => 'Data Barang',
            'keyword' => $keyword,
            'selectedCategory' => $category,
            'selectedMonth' => $month,
            'selectedYear' => $year,
            'years' => range((int) date('Y') - 4, (int) date('Y') + 1),
            'categories' => ['Sparepart', 'Oli', 'Ban'],
            'products' => $this->productModel->all($keyword, $month, $year, $category ?: null),
        ]);
    }

    public function create(): void
    {
        $this->adminRequired();

        $this->render('products/form', [
            'title' => 'Data Barang',
            'modalTitle' => 'Tambah Barang',
            'product' => null,
            'suppliers' => $this->supplierModel->all(),
            'nextCodes' => $this->productModel->nextCodesByCategory(),
            'action' => 'products/store',
            'cancelRoute' => 'products',
        ]);
    }

    public function store(): void
    {
        $this->adminRequired();
        set_old($_POST);

        try {
            $category = trim($_POST['kategori'] ?? '');
            $code = $this->productModel->nextCodeForCategory($category);
            if ($code === '') {
                throw new RuntimeException('Kategori barang tidak valid.');
            }

            $this->productModel->create([
                'kode_barang' => $code,
                'nama_barang' => trim($_POST['nama_barang'] ?? ''),
                'kategori' => $category,
                'stok' => max(0, (int) ($_POST['stok'] ?? 0)),
                'harga' => max(0, (float) ($_POST['harga'] ?? 0)),
                'id_supplier' => (int) ($_POST['id_supplier'] ?? 0),
            ]);

            clear_old();
            flash('success', 'Data barang berhasil ditambahkan.');
            redirect('products');
        } catch (Throwable $exception) {
            flash('error', 'Gagal menyimpan data barang. Periksa kode barang dan supplier.');
            redirect('products/create');
        }
    }

    public function edit(): void
    {
        $this->adminRequired();
        $id = (int) ($_GET['id'] ?? 0);

        $this->render('products/form', [
            'title' => 'Data Barang',
            'modalTitle' => 'Edit Barang',
            'product' => $this->productModel->find($id),
            'suppliers' => $this->supplierModel->all(),
            'nextCodes' => $this->productModel->nextCodesByCategory(),
            'action' => 'products/update&id=' . $id,
            'cancelRoute' => 'products',
        ]);
    }

    public function update(): void
    {
        $this->adminRequired();
        $id = (int) ($_GET['id'] ?? 0);

        try {
            $this->productModel->update($id, [
                'kode_barang' => trim($_POST['kode_barang'] ?? ''),
                'nama_barang' => trim($_POST['nama_barang'] ?? ''),
                'kategori' => trim($_POST['kategori'] ?? ''),
                'stok' => max(0, (int) ($_POST['stok'] ?? 0)),
                'harga' => max(0, (float) ($_POST['harga'] ?? 0)),
                'id_supplier' => (int) ($_POST['id_supplier'] ?? 0),
            ]);

            flash('success', 'Data barang berhasil diperbarui.');
        } catch (Throwable $exception) {
            flash('error', 'Gagal memperbarui data barang.');
        }

        redirect('products');
    }

    public function delete(): void
    {
        $this->adminRequired();
        $id = (int) ($_GET['id'] ?? 0);

        try {
            $this->productModel->delete($id);
            flash('success', 'Data barang berhasil dihapus.');
        } catch (Throwable $exception) {
            flash('error', 'Data barang tidak dapat dihapus karena masih terkait transaksi.');
        }

        redirect('products');
    }
}
