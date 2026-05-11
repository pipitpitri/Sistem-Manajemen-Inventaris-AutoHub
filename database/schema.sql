CREATE DATABASE IF NOT EXISTS tefa_autohub_inventory;
USE tefa_autohub_inventory;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'manager') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS suppliers (
    id_supplier INT AUTO_INCREMENT PRIMARY KEY,
    nama_supplier VARCHAR(120) NOT NULL,
    telepon VARCHAR(30) NOT NULL,
    alamat TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS products (
    id_barang INT AUTO_INCREMENT PRIMARY KEY,
    kode_barang VARCHAR(50) NOT NULL UNIQUE,
    nama_barang VARCHAR(120) NOT NULL,
    kategori VARCHAR(100) NOT NULL,
    stok INT NOT NULL DEFAULT 0,
    harga DECIMAL(15,2) NOT NULL DEFAULT 0,
    id_supplier INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_products_supplier FOREIGN KEY (id_supplier) REFERENCES suppliers(id_supplier)
        ON UPDATE CASCADE ON DELETE RESTRICT
);

CREATE TABLE IF NOT EXISTS incoming_transactions (
    id_masuk INT AUTO_INCREMENT PRIMARY KEY,
    id_barang INT NOT NULL,
    jumlah INT NOT NULL,
    tanggal DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_incoming_product FOREIGN KEY (id_barang) REFERENCES products(id_barang)
        ON UPDATE CASCADE ON DELETE RESTRICT
);

CREATE TABLE IF NOT EXISTS outgoing_transactions (
    id_keluar INT AUTO_INCREMENT PRIMARY KEY,
    id_barang INT NOT NULL,
    jumlah INT NOT NULL,
    jenis ENUM('terjual', 'terpakai') NOT NULL,
    tanggal DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_outgoing_product FOREIGN KEY (id_barang) REFERENCES products(id_barang)
        ON UPDATE CASCADE ON DELETE RESTRICT
);

INSERT INTO suppliers (nama_supplier, telepon, alamat)
SELECT 'PT Sumber Parts Indonesia', '081234567890', 'Jl. Industri Otomotif No. 12, Jakarta'
WHERE NOT EXISTS (SELECT 1 FROM suppliers WHERE nama_supplier = 'PT Sumber Parts Indonesia');

INSERT INTO suppliers (nama_supplier, telepon, alamat)
SELECT 'CV Mekanik Nusantara', '082233445566', 'Jl. Raya Teknologi No. 45, Bandung'
WHERE NOT EXISTS (SELECT 1 FROM suppliers WHERE nama_supplier = 'CV Mekanik Nusantara');

INSERT INTO products (kode_barang, nama_barang, kategori, stok, harga, id_supplier)
SELECT 'BRG-001', 'Oli Mesin Premium', 'Pelumas', 20, 85000, 1
WHERE NOT EXISTS (SELECT 1 FROM products WHERE kode_barang = 'BRG-001');

INSERT INTO products (kode_barang, nama_barang, kategori, stok, harga, id_supplier)
SELECT 'BRG-002', 'Kampas Rem Depan', 'Sparepart', 8, 120000, 2
WHERE NOT EXISTS (SELECT 1 FROM products WHERE kode_barang = 'BRG-002');
