<?php

class Supplier extends Model
{
    public function all(?string $keyword = null): array
    {
        if ($keyword) {
            $stmt = $this->db->prepare(
                'SELECT * FROM suppliers
                 WHERE nama_supplier LIKE :keyword OR telepon LIKE :keyword OR alamat LIKE :keyword
                 ORDER BY nama_supplier ASC'
            );
            $stmt->execute(['keyword' => '%' . $keyword . '%']);
            return $stmt->fetchAll();
        }

        return $this->db->query('SELECT * FROM suppliers ORDER BY nama_supplier ASC')->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM suppliers WHERE id_supplier = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch() ?: null;
    }

    public function create(array $data): bool
    {
        $stmt = $this->db->prepare(
            'INSERT INTO suppliers (nama_supplier, telepon, alamat) VALUES (:nama_supplier, :telepon, :alamat)'
        );

        return $stmt->execute($data);
    }

    public function update(int $id, array $data): bool
    {
        $data['id'] = $id;
        $stmt = $this->db->prepare(
            'UPDATE suppliers SET nama_supplier = :nama_supplier, telepon = :telepon, alamat = :alamat WHERE id_supplier = :id'
        );

        return $stmt->execute($data);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM suppliers WHERE id_supplier = :id');
        return $stmt->execute(['id' => $id]);
    }

    public function totalItems(): int
    {
        $stmt = $this->db->query('SELECT COUNT(*) AS total FROM suppliers');
        return (int) $stmt->fetch()['total'];
    }
}
