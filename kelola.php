<?php
// kelola_data_buku.php - Halaman Kelola Data Buku

// Bagian ini biasanya akan berisi:
// 1. Logika koneksi ke database (MySQLi atau PDO)
// 2. Logika untuk menangani operasi CRUD (ADD, EDIT, DELETE)
// 3. Query untuk mengambil semua data buku dari database

// --- SIMULASI DATA BUKU DARI DATABASE ---
// Dalam implementasi nyata, data ini akan diambil dari tabel 'buku'
$daftar_buku = [
    [
        'id' => 1,
        'judul' => 'Dasar Pemrograman PHP dan MySQL',
        'penulis' => 'Andi Susanto',
        'tahun_terbit' => 2021,
        'stok' => 15
    ],
    [
        'id' => 2,
        'judul' => 'Struktur Data dan Algoritma',
        'penulis' => 'Budi Raharjo',
        'tahun_terbit' => 2019,
        'stok' => 8
    ],
    [
        'id' => 3,
        'judul' => 'Filosofi Teras',
        'penulis' => 'Henry Manampiring',
        'tahun_terbit' => 2018,
        'stok' => 22
    ],
];
// --- AKHIR SIMULASI DATA ---

// --- SIMULASI LOGIKA HAPUS (Dalam implementasi nyata, ini akan berinteraksi dengan DB) ---
// if (isset($_GET['aksi']) && $_GET['aksi'] == 'hapus' && isset($_GET['id'])) {
//     $id_hapus = (int)$_GET['id'];
//     // Lakukan query DELETE di sini: DELETE FROM buku WHERE id = $id_hapus
//     // Kemudian redirect kembali ke halaman ini
//     // header("Location: kelola_data_buku.php?status=sukses_hapus");
//     // exit();
// }
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Data Buku - Sistem Informasi Perpustakaan</title>
    <style>
        /* Gaya CSS Sederhana */
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
        .btn-primary { background-color: #007bff; color: white; }
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
            background-color: #f2f2f2;
            color: #333;
        }
        .aksi-col { width: 150px; text-align: center; }
    </style>
</head>
<body>

<div class="container">
    <h1>📚 Kelola Data Buku</h1>
    
    <a href="form_buku.php?aksi=tambah" class="btn btn-primary">
        + Tambah Data Buku Baru
    </a>
    
    <a href="menuutama.php" class="btn btn-secondary">
        < Kembali ke Menu Utama
    </a>
    
    <hr>
    
    <h2>Daftar Buku Tersedia</h2>
    
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Judul Buku</th>
                <th>Penulis</th>
                <th>Tahun Terbit</th>
                <th>Stok</th>
                <th class="aksi-col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            // Looping untuk menampilkan setiap baris data buku
            foreach ($daftar_buku as $buku) {
                echo "<tr>";
                echo "<td>" . $no++ . "</td>";
                echo "<td>" . htmlspecialchars($buku['judul']) . "</td>";
                echo "<td>" . htmlspecialchars($buku['penulis']) . "</td>";
                echo "<td>" . htmlspecialchars($buku['tahun_terbit']) . "</td>";
                echo "<td>" . htmlspecialchars($buku['stok']) . "</td>";
                echo "<td class='aksi-col'>";
                
                // Tombol Edit - mengarahkan ke form_buku dengan ID buku untuk di-edit
                echo "<a href='form_buku.php?aksi=edit&id=" . $buku['id'] . "' class='btn btn-warning btn-sm'>Edit</a> ";
                
                // Tombol Hapus - menggunakan JavaScript untuk konfirmasi
                echo "<a href='kelola_data_buku.php?aksi=hapus&id=" . $buku['id'] . "' 
                       onclick='return confirm(\"Apakah Anda yakin ingin menghapus buku: " . htmlspecialchars($buku['judul']) . "?\")' 
                       class='btn btn-danger btn-sm'>Hapus</a>";
                
                echo "</td>";
                echo "</tr>";
            }
            
            // Jika data buku kosong
            if (empty($daftar_buku)) {
                echo "<tr><td colspan='6' style='text-align: center;'>Tidak ada data buku yang tersedia.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>