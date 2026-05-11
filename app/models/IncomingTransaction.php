<?php

class IncomingTransaction extends Model
{
    public function all(?int $month = null, ?int $year = null, ?string $category = null): array
    {
        $sql = 'SELECT i.*, p.kode_barang, p.nama_barang, p.kategori, p.harga,
                       (i.jumlah * p.harga) AS subtotal, s.nama_supplier
                FROM incoming_transactions i
                INNER JOIN products p ON p.id_barang = i.id_barang
                LEFT JOIN suppliers s ON s.id_supplier = p.id_supplier
                WHERE 1=1';

        $params = [];

        if ($month) {
            $sql .= ' AND MONTH(i.tanggal) = :month';
            $params['month'] = $month;
        }

        if ($year) {
            $sql .= ' AND YEAR(i.tanggal) = :year';
            $params['year'] = $year;
        }

        if ($category) {
            $sql .= ' AND p.kategori = :category';
            $params['category'] = $category;
        }

        $sql .= ' ORDER BY i.tanggal DESC, i.id_masuk DESC';
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

        $this->db->beginTransaction();

        try {
            $stmt = $this->db->prepare(
                'INSERT INTO incoming_transactions (id_barang, jumlah, tanggal)
                 VALUES (:id_barang, :jumlah, :tanggal)'
            );
            $stmt->execute($data);

            $productModel->updateStock((int) $data['id_barang'], (int) $product['stok'] + (int) $data['jumlah']);
            $this->db->commit();
            return true;
        } catch (Throwable $exception) {
            $this->db->rollBack();
            throw $exception;
        }
    }

    public function totalTransactions(): int
    {
        $stmt = $this->db->query('SELECT COUNT(*) AS total FROM incoming_transactions');
        return (int) $stmt->fetch()['total'];
    }

    public function totalQuantity(): int
    {
        $stmt = $this->db->query('SELECT COALESCE(SUM(jumlah), 0) AS total FROM incoming_transactions');
        return (int) $stmt->fetch()['total'];
    }

    public function monthlyTotals(int $year): array
    {
        $stmt = $this->db->prepare(
            'SELECT MONTH(tanggal) AS month_num, COALESCE(SUM(jumlah), 0) AS total
             FROM incoming_transactions
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
