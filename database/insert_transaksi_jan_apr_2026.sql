-- Data transaksi barang masuk dan barang keluar AutoHub
-- Periode: Januari, Februari, Maret, April 2026
-- Jumlah: 30 transaksi per bulan (15 barang masuk + 15 barang keluar)
-- Jalankan setelah schema.sql dan insert_data_barang_autohub.sql.

USE tefa_autohub_inventory;

START TRANSACTION;

INSERT INTO incoming_transactions (id_barang, jumlah, tanggal) VALUES
    -- Januari 2026
    ((SELECT id_barang FROM products WHERE kode_barang = 'OL-003'), 12, '2026-01-03'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'OL-007'), 10, '2026-01-04'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'SP-026'), 8, '2026-01-05'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'SP-028'), 8, '2026-01-07'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'BN-002'), 6, '2026-01-09'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'SP-035'), 7, '2026-01-11'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'OL-011'), 10, '2026-01-13'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'OL-013'), 8, '2026-01-15'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'SP-100'), 5, '2026-01-17'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'SP-101'), 5, '2026-01-19'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'OL-018'), 6, '2026-01-21'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'OL-019'), 6, '2026-01-23'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'BN-006'), 5, '2026-01-25'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'SP-070'), 12, '2026-01-27'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'SP-072'), 12, '2026-01-29'),

    -- Februari 2026
    ((SELECT id_barang FROM products WHERE kode_barang = 'OL-002'), 10, '2026-02-02'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'OL-004'), 10, '2026-02-04'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'OL-012'), 12, '2026-02-06'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'SP-007'), 6, '2026-02-08'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'SP-008'), 6, '2026-02-10'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'SP-013'), 6, '2026-02-12'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'BN-003'), 5, '2026-02-14'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'BN-007'), 5, '2026-02-16'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'SP-044'), 5, '2026-02-18'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'SP-046'), 5, '2026-02-20'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'OL-017'), 8, '2026-02-21'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'OL-020'), 8, '2026-02-23'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'SP-057'), 4, '2026-02-24'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'SP-059'), 4, '2026-02-26'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'SP-085'), 4, '2026-02-28'),

    -- Maret 2026
    ((SELECT id_barang FROM products WHERE kode_barang = 'OL-021'), 9, '2026-03-02'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'OL-022'), 9, '2026-03-04'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'OL-023'), 9, '2026-03-06'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'SP-032'), 6, '2026-03-08'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'SP-040'), 7, '2026-03-10'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'SP-055'), 5, '2026-03-12'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'SP-063'), 5, '2026-03-14'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'SP-064'), 5, '2026-03-16'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'BN-004'), 5, '2026-03-18'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'BN-008'), 5, '2026-03-20'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'OL-024'), 7, '2026-03-22'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'OL-026'), 7, '2026-03-24'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'SP-091'), 6, '2026-03-26'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'SP-094'), 6, '2026-03-28'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'SP-106'), 5, '2026-03-30'),

    -- April 2026
    ((SELECT id_barang FROM products WHERE kode_barang = 'OL-027'), 9, '2026-04-02'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'OL-028'), 9, '2026-04-04'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'OL-031'), 8, '2026-04-06'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'SP-018'), 5, '2026-04-08'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'SP-019'), 5, '2026-04-10'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'SP-020'), 5, '2026-04-12'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'SP-021'), 5, '2026-04-14'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'BN-005'), 5, '2026-04-16'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'BN-019'), 5, '2026-04-18'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'BN-020'), 5, '2026-04-20'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'OL-033'), 8, '2026-04-22'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'OL-034'), 8, '2026-04-24'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'SP-073'), 4, '2026-04-26'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'SP-074'), 4, '2026-04-28'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'SP-118'), 4, '2026-04-30');

INSERT INTO outgoing_transactions (id_barang, jumlah, jenis, tanggal) VALUES
    -- Januari 2026
    ((SELECT id_barang FROM products WHERE kode_barang = 'OL-003'), 3, 'terjual', '2026-01-04'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'OL-007'), 2, 'terpakai', '2026-01-06'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'SP-026'), 2, 'terjual', '2026-01-08'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'SP-028'), 3, 'terjual', '2026-01-10'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'BN-002'), 1, 'terjual', '2026-01-12'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'SP-035'), 2, 'terpakai', '2026-01-14'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'OL-011'), 3, 'terjual', '2026-01-16'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'OL-013'), 2, 'terpakai', '2026-01-18'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'SP-100'), 1, 'terjual', '2026-01-20'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'SP-101'), 1, 'terpakai', '2026-01-22'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'OL-018'), 2, 'terjual', '2026-01-24'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'OL-019'), 3, 'terjual', '2026-01-26'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'BN-006'), 1, 'terjual', '2026-01-27'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'SP-070'), 4, 'terpakai', '2026-01-28'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'SP-072'), 4, 'terjual', '2026-01-30'),

    -- Februari 2026
    ((SELECT id_barang FROM products WHERE kode_barang = 'OL-002'), 3, 'terjual', '2026-02-03'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'OL-004'), 3, 'terpakai', '2026-02-05'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'OL-012'), 4, 'terjual', '2026-02-07'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'SP-007'), 2, 'terjual', '2026-02-09'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'SP-008'), 2, 'terjual', '2026-02-11'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'SP-013'), 2, 'terpakai', '2026-02-13'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'BN-003'), 1, 'terjual', '2026-02-15'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'BN-007'), 1, 'terjual', '2026-02-17'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'SP-044'), 1, 'terpakai', '2026-02-19'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'SP-046'), 2, 'terjual', '2026-02-21'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'OL-017'), 3, 'terjual', '2026-02-22'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'OL-020'), 2, 'terpakai', '2026-02-24'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'SP-057'), 1, 'terjual', '2026-02-25'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'SP-059'), 1, 'terjual', '2026-02-27'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'SP-085'), 1, 'terpakai', '2026-02-28'),

    -- Maret 2026
    ((SELECT id_barang FROM products WHERE kode_barang = 'OL-021'), 2, 'terjual', '2026-03-03'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'OL-022'), 3, 'terjual', '2026-03-05'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'OL-023'), 2, 'terpakai', '2026-03-07'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'SP-032'), 1, 'terjual', '2026-03-09'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'SP-040'), 2, 'terpakai', '2026-03-11'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'SP-055'), 1, 'terjual', '2026-03-13'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'SP-063'), 1, 'terjual', '2026-03-15'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'SP-064'), 1, 'terpakai', '2026-03-17'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'BN-004'), 1, 'terjual', '2026-03-19'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'BN-008'), 1, 'terjual', '2026-03-21'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'OL-024'), 2, 'terjual', '2026-03-23'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'OL-026'), 2, 'terpakai', '2026-03-25'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'SP-091'), 1, 'terjual', '2026-03-27'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'SP-094'), 1, 'terpakai', '2026-03-29'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'SP-106'), 1, 'terjual', '2026-03-31'),

    -- April 2026
    ((SELECT id_barang FROM products WHERE kode_barang = 'OL-027'), 2, 'terjual', '2026-04-03'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'OL-028'), 2, 'terjual', '2026-04-05'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'OL-031'), 2, 'terpakai', '2026-04-07'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'SP-018'), 1, 'terjual', '2026-04-09'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'SP-019'), 1, 'terpakai', '2026-04-11'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'SP-020'), 1, 'terjual', '2026-04-13'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'SP-021'), 1, 'terjual', '2026-04-15'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'BN-005'), 1, 'terjual', '2026-04-17'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'BN-019'), 1, 'terjual', '2026-04-19'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'BN-020'), 1, 'terpakai', '2026-04-21'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'OL-033'), 2, 'terjual', '2026-04-23'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'OL-034'), 2, 'terjual', '2026-04-25'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'SP-073'), 1, 'terpakai', '2026-04-27'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'SP-074'), 1, 'terjual', '2026-04-29'),
    ((SELECT id_barang FROM products WHERE kode_barang = 'SP-118'), 1, 'terjual', '2026-04-30');

COMMIT;
