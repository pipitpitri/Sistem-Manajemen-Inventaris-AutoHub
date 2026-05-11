<?php

class SupplierController extends BaseController
{
    private Supplier $supplierModel;

    public function __construct()
    {
        $this->supplierModel = new Supplier();
    }

    public function index(): void
    {
        $this->authRequired();
        $keyword = trim($_GET['q'] ?? '');

        $this->render('suppliers/index', [
            'title' => 'Data Supplier',
            'keyword' => $keyword,
            'suppliers' => $this->supplierModel->all($keyword),
        ]);
    }

    public function create(): void
    {
        $this->adminRequired();

        $this->render('suppliers/form', [
            'title' => 'Data Supplier',
            'modalTitle' => 'Tambah Supplier',
            'supplier' => null,
            'action' => 'suppliers/store',
            'cancelRoute' => 'suppliers',
        ]);
    }

    public function store(): void
    {
        $this->adminRequired();
        set_old($_POST);

        try {
            $this->supplierModel->create([
                'nama_supplier' => trim($_POST['nama_supplier'] ?? ''),
                'telepon' => trim($_POST['telepon'] ?? ''),
                'alamat' => trim($_POST['alamat'] ?? ''),
            ]);

            clear_old();
            flash('success', 'Supplier berhasil ditambahkan.');
            redirect('suppliers');
        } catch (Throwable $exception) {
            flash('error', 'Gagal menambahkan supplier.');
            redirect('suppliers/create');
        }
    }

    public function edit(): void
    {
        $this->adminRequired();
        $id = (int) ($_GET['id'] ?? 0);

        $this->render('suppliers/form', [
            'title' => 'Data Supplier',
            'modalTitle' => 'Edit Supplier',
            'supplier' => $this->supplierModel->find($id),
            'action' => 'suppliers/update&id=' . $id,
            'cancelRoute' => 'suppliers',
        ]);
    }

    public function update(): void
    {
        $this->adminRequired();
        $id = (int) ($_GET['id'] ?? 0);

        try {
            $this->supplierModel->update($id, [
                'nama_supplier' => trim($_POST['nama_supplier'] ?? ''),
                'telepon' => trim($_POST['telepon'] ?? ''),
                'alamat' => trim($_POST['alamat'] ?? ''),
            ]);

            flash('success', 'Supplier berhasil diperbarui.');
        } catch (Throwable $exception) {
            flash('error', 'Gagal memperbarui supplier.');
        }

        redirect('suppliers');
    }

    public function delete(): void
    {
        $this->adminRequired();
        $id = (int) ($_GET['id'] ?? 0);

        try {
            $this->supplierModel->delete($id);
            flash('success', 'Supplier berhasil dihapus.');
        } catch (Throwable $exception) {
            flash('error', 'Supplier tidak dapat dihapus karena masih dipakai oleh data barang.');
        }

        redirect('suppliers');
    }
}
