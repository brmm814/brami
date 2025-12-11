<?php
// kelola_data_anggota.php - Halaman Kelola Data Anggota

// Bagian ini biasanya akan berisi:
// 1. Logika koneksi ke database (MySQLi atau PDO)
// 2. Logika untuk menangani operasi CRUD (ADD, EDIT, DELETE) anggota
// 3. Query untuk mengambil semua data anggota dari database

// --- SIMULASI DATA ANGGOTA DARI DATABASE ---
// Dalam implementasi nyata, data ini akan diambil dari tabel 'anggota'
$daftar_anggota = [
    [
        'id' => 1001,
        'nama' => 'Rina Wijaya',
        'alamat' => 'Jl. Mawar No. 10, Jakarta',
        'no_telp' => '081234567890',
        'status' => 'Aktif'
    ],
    [
        'id' => 1002,
        'nama' => 'Slamet Santoso',
        'alamat' => 'Perumahan Indah Blok C2, Bandung',
        'no_telp' => '085098765432',
        'status' => 'Aktif'
    ],
    [
        'id' => 1003,
        'nama' => 'Dewi Puspita',
        'alamat' => 'Griya Makmur No. 5, Surabaya',
        'no_telp' => '087711223344',
        'status' => 'Aktif'
    ],
];
// --- AKHIR SIMULASI DATA ---

// --- Catatan: Logika CRUD (Hapus, Edit) akan ditempatkan di sini ---
// Contoh: Menggunakan $_GET untuk menangkap aksi hapus
// if (isset($_GET['aksi']) && $_GET['aksi'] == 'hapus' && isset($_GET['id'])) { ... }
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Data Anggota - Sistem Informasi Perpustakaan</title>
    <style>
        /* Gaya CSS Sederhana (Hampir sama dengan data_buku.php) */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 90%;
            margin: 30px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333;
            border-bottom: 2px solid #ccc;
            padding-bottom: 10px;
        }
        .btn {
            padding: 10px 15px;
            margin: 5px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            font-weight: bold;
            display: inline-block;
        }
        .btn-primary { background-color: #28a745; color: white; } /* Ganti warna untuk pembeda */
        .btn-warning { background-color: #ffc107; color: #212529; }
        .btn-danger { background-color: #dc3545; color: white; }
        .btn-secondary { background-color: #6c757d; color: white; }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #e9ecef; /* Warna header tabel */
            color: #333;
        }
        .aksi-col { width: 150px; text-align: center; }
        .status-aktif { color: green; font-weight: bold; }
        .status-tidak-aktif { color: red; font-weight: bold; }
    </style>
</head>
<body>

<div class="container">
    <h1>👤 Kelola Data Anggota</h1>
    
    <a href="form_anggota.php?aksi=tambah" class="btn btn-primary">
        + Tambah Anggota Baru
    </a>
    
    <a href="menuutama.php" class="btn btn-secondary">
        < Kembali ke Menu Utama
    </a>
    
    <hr>
    
    <h2>Daftar Anggota Perpustakaan</h2>
    
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>ID Anggota</th>
                <th>Nama Anggota</th>
                <th>Alamat</th>
                <th>No. Telepon</th>
                <th>Status</th>
                <th class="aksi-col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            // Looping untuk menampilkan setiap baris data anggota
            foreach ($daftar_anggota as $anggota) {
                echo "<tr>";
                echo "<td>" . $no++ . "</td>";
                echo "<td>" . htmlspecialchars($anggota['id']) . "</td>";
                echo "<td>" . htmlspecialchars($anggota['nama']) . "</td>";
                echo "<td>" . htmlspecialchars($anggota['alamat']) . "</td>";
                echo "<td>" . htmlspecialchars($anggota['no_telp']) . "</td>";
                
                // Menentukan kelas CSS berdasarkan status
                $status_class = ($anggota['status'] == 'Aktif') ? 'status-aktif' : 'status-tidak-aktif';
                echo "<td><span class='$status_class'>" . htmlspecialchars($anggota['status']) . "</span></td>";
                
                echo "<td class='aksi-col'>";
                
                // Tombol Edit - mengarahkan ke form_anggota dengan ID anggota
                echo "<a href='form_anggota.php?aksi=edit&id=" . $anggota['id'] . "' class='btn btn-warning btn-sm'>Edit</a> ";
                
                // Tombol Hapus - menggunakan JavaScript untuk konfirmasi
                echo "<a href='kelola_data_anggota.php?aksi=hapus&id=" . $anggota['id'] . "' 
                       onclick='return confirm(\"Apakah Anda yakin ingin menghapus anggota: " . htmlspecialchars($anggota['nama']) . "?\")' 
                       class='btn btn-danger btn-sm'>Hapus</a>";
                
                echo "</td>";
                echo "</tr>";
            }
            
            // Jika data anggota kosong
            if (empty($daftar_anggota)) {
                echo "<tr><td colspan='7' style='text-align: center;'>Tidak ada data anggota yang terdaftar.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>