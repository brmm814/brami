<?php
// laporan_statistik.php - Halaman Laporan dan Statistik

// Pengaturan Zona Waktu
date_default_timezone_set('Asia/Jakarta');

// Bagian ini akan berisi:
// 1. Logika koneksi ke database.
// 2. Query untuk mengambil data agregat (COUNT, SUM, AVG) dari tabel.

// --- SIMULASI PENGAMBILAN DATA STATISTIK DARI DATABASE ---

// 1. Data Ringkasan Inventaris
$total_buku = 1500; // SELECT COUNT(id_buku) FROM buku
$total_anggota = 750; // SELECT COUNT(id_anggota) FROM anggota
$total_stok_tersedia = 1250; // SELECT SUM(stok) FROM buku

// 2. Data Transaksi Aktif
$peminjaman_aktif = 205; // SELECT COUNT(id_pinjam) FROM peminjaman WHERE status = 'Belum Kembali'
$keterlambatan_hari_ini = 15; // SELECT COUNT(id_pinjam) FROM peminjaman WHERE tgl_kembali_target < CURDATE() AND status = 'Belum Kembali'
$total_denda_bulan_ini = 550000; // SELECT SUM(denda) FROM peminjaman WHERE MONTH(tgl_kembali_aktual) = MONTH(CURDATE())

// 3. Data Top Buku
$top_buku = [
    ['judul' => 'Struktur Data dan Algoritma', 'kali_dipinjam' => 85],
    ['judul' => 'Dasar Pemrograman PHP', 'kali_dipinjam' => 78],
    ['judul' => 'Kumpulan Dongeng Anak', 'kali_dipinjam' => 62],
];
// --- AKHIR SIMULASI DATA ---
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan & Statistik - Sistem Informasi Perpustakaan</title>
    <style>
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
        .btn-secondary { 
            padding: 10px 15px; 
            margin: 5px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            font-weight: bold;
            display: inline-block;
            background-color: #6c757d; 
            color: white; 
        }
        
        .card-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        .card {
            background-color: #f8f9fa;
            border-left: 5px solid #007bff;
            padding: 20px;
            border-radius: 6px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }
        .card h3 {
            margin-top: 0;
            color: #555;
            font-size: 1em;
        }
        .card .nilai {
            font-size: 2.5em;
            font-weight: bold;
            color: #007bff;
        }
        .card-red { border-left-color: #dc3545; }
        .card-red .nilai { color: #dc3545; }
        .card-green { border-left-color: #28a745; }
        .card-green .nilai { color: #28a745; }

        .section-laporan {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px dashed #ccc;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #e9ecef;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>📊 Laporan & Statistik Perpustakaan</h1>
    
    <a href="menuutama.php" class="btn-secondary">
        < Kembali ke Menu Utama
    </a>
    
    <hr>
    
    <h2>1. Ringkasan Kinerja Utama</h2>
    <div class="card-grid">
        
        <div class="card card-green">
            <h3>Total Judul Buku</h3>
            <div class="nilai"><?php echo number_format($total_buku, 0, ',', '.'); ?></div>
            <p>Total stok tersedia: <?php echo number_format($total_stok_tersedia, 0, ',', '.'); ?></p>
        </div>

        <div class="card card-green">
            <h3>Total Anggota Terdaftar</h3>
            <div class="nilai"><?php echo number_format($total_anggota, 0, ',', '.'); ?></div>
            <p>Anggota yang terdaftar dalam sistem.</p>
        </div>
        
        <div class="card card-red">
            <h3>Peminjaman Aktif</h3>
            <div class="nilai"><?php echo number_format($peminjaman_aktif, 0, ',', '.'); ?></div>
            <p>Buku yang saat ini dipinjam anggota.</p>
        </div>

        <div class="card card-red">
            <h3>Buku Melebihi Batas Waktu</h3>
            <div class="nilai"><?php echo number_format($keterlambatan_hari_ini, 0, ',', '.'); ?></div>
            <p>Jumlah buku yang seharusnya sudah kembali.</p>
        </div>
    </div>

    <div class="section-laporan">
        <h2>2. Keuangan & Denda</h2>
        <div class="card-grid">
            <div class="card" style="border-left-color: #ffc107; color: #856404;">
                <h3>Total Denda Bulan Ini</h3>
                <div class="nilai" style="color: #ffc107;">Rp <?php echo number_format($total_denda_bulan_ini, 0, ',', '.'); ?></div>
                <p>Total akumulasi denda yang tercatat.</p>
            </div>
        </div>
    </div>

    <div class="section-laporan">
        <h2>3. Top 3 Buku Paling Sering Dipinjam</h2>
        <table>
            <thead>
                <tr>
                    <th>Peringkat</th>
                    <th>Judul Buku</th>
                    <th>Total Kali Dipinjam</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $rank = 1;
                foreach ($top_buku as $buku) {
                    echo "<tr>";
                    echo "<td>" . $rank++ . "</td>";
                    echo "<td>" . htmlspecialchars($buku['judul']) . "</td>";
                    echo "<td>" . htmlspecialchars($buku['kali_dipinjam']) . " kali</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        <p style="margin-top: 15px; font-size: 0.9em; color: #666;">*Data ini biasanya diambil dari agregasi total peminjaman sepanjang masa.</p>
    </div>

</div>

</body>
</html>