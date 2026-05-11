<?php

class Product extends Model
{
    public function all(?string $keyword = null, ?int $month = null, ?int $year = null, ?string $category = null): array
    {
        $cutoffDate = $this->resolveCutoffDate($month, $year);
        $params = [];

        if ($cutoffDate !== null) {
            $sql = 'SELECT p.id_barang, p.kode_barang, p.nama_barang, p.kategori,
                           (p.stok - COALESCE(i_after.total_incoming, 0) + COALESCE(o_after.total_outgoing, 0)) AS stok,
                           p.harga, p.id_supplier, p.created_at, s.nama_supplier
                    FROM products p
                    LEFT JOIN suppliers s ON s.id_supplier = p.id_supplier
                    LEFT JOIN (
                        SELECT id_barang, COALESCE(SUM(jumlah), 0) AS total_incoming
                        FROM incoming_transactions
                        WHERE tanggal > :incoming_cutoff
                        GROUP BY id_barang
                    ) i_after ON i_after.id_barang = p.id_barang
                    LEFT JOIN (
                        SELECT id_barang, COALESCE(SUM(jumlah), 0) AS total_outgoing
                        FROM outgoing_transactions
                        WHERE tanggal > :outgoing_cutoff
                        GROUP BY id_barang
                    ) o_after ON o_after.id_barang = p.id_barang
                    WHERE p.created_at <= :created_cutoff';

            $params['incoming_cutoff'] = $cutoffDate;
            $params['outgoing_cutoff'] = $cutoffDate;
            $params['created_cutoff'] = $cutoffDate . ' 23:59:59';
        } else {
            $sql = 'SELECT p.*, s.nama_supplier
                    FROM products p
                    LEFT JOIN suppliers s ON s.id_supplier = p.id_supplier
                    WHERE 1=1';
        }

        if ($keyword) {
            $sql .= ' AND (p.kode_barang LIKE :keyword OR p.nama_barang LIKE :keyword OR p.kategori LIKE :keyword OR s.nama_supplier LIKE :keyword)';
            $params['keyword'] = '%' . $keyword . '%';
        }

        if ($category) {
            $sql .= ' AND p.kategori = :category';
            $params['category'] = $category;
        }

        $sql .= ' ORDER BY p.nama_barang ASC';

        if ($params !== []) {
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll();
        }

        return $this->db->query($sql)->fetchAll();
    }

    private function resolveCutoffDate(?int $month, ?int $year): ?string
    {
        if (!$month && !$year) {
            return null;
        }

        $resolvedYear = $year ?: (int) date('Y');
        $resolvedMonth = $month ?: 12;
        $lastDay = cal_days_in_month(CAL_GREGORIAN, $resolvedMonth, $resolvedYear);

        return sprintf('%04d-%02d-%02d', $resolvedYear, $resolvedMonth, $lastDay);
    }

    public function nextCodeForCategory(string $category): string
    {
        $prefix = $this->codePrefixForCategory($category);
        if ($prefix === '') {
            return '';
        }

        $stmt = $this->db->prepare(
            "SELECT MAX(CAST(SUBSTRING(kode_barang, 4) AS UNSIGNED)) AS last_number
             FROM products
             WHERE kode_barang REGEXP :pattern"
        );
        $stmt->execute(['pattern' => '^' . $prefix . '-[0-9]+$']);
        $lastNumber = (int) ($stmt->fetch()['last_number'] ?? 0);

        return sprintf('%s-%03d', $prefix, $lastNumber + 1);
    }

    public function nextCodesByCategory(): array
    {
        return [
            'Sparepart' => $this->nextCodeForCategory('Sparepart'),
            'Oli' => $this->nextCodeForCategory('Oli'),
            'Ban' => $this->nextCodeForCategory('Ban'),
        ];
    }

    private function codePrefixForCategory(string $category): string
    {
        return match ($category) {
            'Sparepart' => 'SP',
            'Oli' => 'OL',
            'Ban' => 'BN',
            default => '',
        };
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM products WHERE id_barang = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch() ?: null;
    }

    public function create(array $data): bool
    {
        $stmt = $this->db->prepare(
            'INSERT INTO products (kode_barang, nama_barang, kategori, stok, harga, id_supplier)
             VALUES (:kode_barang, :nama_barang, :kategori, :stok, :harga, :id_supplier)'
        );

        return $stmt->execute($data);
    }

    public function update(int $id, array $data): bool
    {
        $data['id'] = $id;
        $stmt = $this->db->prepare(
            'UPDATE products
             SET kode_barang = :kode_barang, nama_barang = :nama_barang, kategori = :kategori,
                 stok = :stok, harga = :harga, id_supplier = :id_supplier
             WHERE id_barang = :id'
        );

        return $stmt->execute($data);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM products WHERE id_barang = :id');
        return $stmt->execute(['id' => $id]);
    }

    public function updateStock(int $id, int $stock): bool
    {
        $stmt = $this->db->prepare('UPDATE products SET stok = :stok WHERE id_barang = :id');
        return $stmt->execute(['stok' => $stock, 'id' => $id]);
    }

    public function totalItems(): int
    {
        $stmt = $this->db->query('SELECT COUNT(*) AS total FROM products');
        return (int) $stmt->fetch()['total'];
    }

    public function totalStock(): int
    {
        $stmt = $this->db->query('SELECT COALESCE(SUM(stok), 0) AS total FROM products');
        return (int) $stmt->fetch()['total'];
    }

    public function lowStock(): array
    {
        $stmt = $this->db->prepare(
            'SELECT p.*, s.nama_supplier
             FROM products p
             LEFT JOIN suppliers s ON s.id_supplier = p.id_supplier
             WHERE p.stok < :minimum
             ORDER BY p.stok ASC'
        );
        $stmt->execute(['minimum' => STOCK_MINIMUM_ALERT]);
        return $stmt->fetchAll();
    }

    public function stockStatusList(?string $keyword = null): array
    {
        return $this->all($keyword);
    }
}
