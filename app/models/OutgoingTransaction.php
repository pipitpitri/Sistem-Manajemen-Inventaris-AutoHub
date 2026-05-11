<?php

class OutgoingTransaction extends Model
{
    public function all(?int $month = null, ?int $year = null, ?string $category = null): array
    {
        $sql = 'SELECT o.*, p.kode_barang, p.nama_barang, p.kategori, p.harga,
                       (o.jumlah * p.harga) AS subtotal, o.jenis AS keterangan
                FROM outgoing_transactions o
                INNER JOIN products p ON p.id_barang = o.id_barang
                WHERE 1=1';

        $params = [];

        if ($month) {
            $sql .= ' AND MONTH(o.tanggal) = :month';
            $params['month'] = $month;
        }

        if ($year) {
            $sql .= ' AND YEAR(o.tanggal) = :year';
            $params['year'] = $year;
        }

        if ($category) {
            $sql .= ' AND p.kategori = :category';
            $params['category'] = $category;
        }

        $sql .= ' ORDER BY o.tanggal DESC, o.id_keluar DESC';
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function create(array $data): bool
    {
        $productModel = new Product();
        $product = $productModel->find((int) $data['id_barang']);

        if (!$product) {
            throw new RuntimeException('Barang tidak ditemukan.');
        }

        $remaining = (int) $product['stok'] - (int) $data['jumlah'];
        if ($remaining < 0) {
            throw new RuntimeException('Stok tidak mencukupi untuk transaksi barang keluar.');
        }

        $this->db->beginTransaction();

        try {
            $stmt = $this->db->prepare(
                'INSERT INTO outgoing_transactions (id_barang, jumlah, jenis, tanggal)
                 VALUES (:id_barang, :jumlah, :jenis, :tanggal)'
            );
            $stmt->execute($data);

            $productModel->updateStock((int) $data['id_barang'], $remaining);
            $this->db->commit();
            return true;
        } catch (Throwable $exception) {
            $this->db->rollBack();
            throw $exception;
        }
    }

    public function totalTransactions(): int
    {
        $stmt = $this->db->query('SELECT COUNT(*) AS total FROM outgoing_transactions');
        return (int) $stmt->fetch()['total'];
    }

    public function totalQuantity(): int
    {
        $stmt = $this->db->query('SELECT COALESCE(SUM(jumlah), 0) AS total FROM outgoing_transactions');
        return (int) $stmt->fetch()['total'];
    }

    public function monthlyTotals(int $year): array
    {
        $stmt = $this->db->prepare(
            'SELECT MONTH(tanggal) AS month_num, COALESCE(SUM(jumlah), 0) AS total
             FROM outgoing_transactions
             WHERE YEAR(tanggal) = :year
             GROUP BY MONTH(tanggal)'
        );
        $stmt->execute(['year' => $year]);
        $rows = $stmt->fetchAll();

        $totals = array_fill(1, 12, 0);
        foreach ($rows as $row) {
            $totals[(int) $row['month_num']] = (int) $row['total'];
        }

        return $totals;
    }
}
