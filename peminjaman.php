<?php
// transaksi_peminjaman.php - Halaman Transaksi Peminjaman

// Bagian ini biasanya akan berisi:
// 1. Logika koneksi ke database.
// 2. Logika untuk memproses formulir peminjaman (INSERT data ke tabel 'peminjaman').
// 3. Logika untuk mengurangi stok buku (UPDATE tabel 'buku').
// 4. Query untuk mengambil daftar peminjaman yang sedang aktif.

// --- SIMULASI FUNGSI CEK DATA (Dalam implementasi nyata, ini adalah fungsi DB) ---
function cekData($id, $tipe) {
    // Fungsi ini mensimulasikan pengecekan ketersediaan data Anggota atau Buku
    if ($tipe == 'anggota' && $id == '1001') {
        return ['nama' => 'Rina Wijaya', 'status' => 'Aktif'];
    } elseif ($tipe == 'buku' && $id == '2') {
        return ['judul' => 'Struktur Data dan Algoritma', 'stok' => 8];
    }
    return false;
}

// --- SIMULASI DATA PEMINJAMAN AKTIF DARI DATABASE ---
$peminjaman_aktif = [
    [
        'id_pinjam' => 501,
        'tgl_pinjam' => '2025-11-20',
        'id_anggota' => 1002,
        'nama_anggota' => 'Slamet Santoso',
        'judul_buku' => 'Dasar Pemrograman PHP dan MySQL',
        'tgl_kembali_target' => '2025-11-27',
        'status' => 'Belum Kembali'
    ],
    [
        'id_pinjam' => 502,
        'tgl_pinjam' => '2025-11-25',
        'id_anggota' => 1001,
        'nama_anggota' => 'Rina Wijaya',
        'judul_buku' => 'Filosofi Teras',
        'tgl_kembali_target' => '2025-12-02',
        'status' => 'Belum Kembali'
    ],
];
// --- AKHIR SIMULASI DATA ---

// --- LOGIKA PEMROSESAN FORMULIR PINJAM (Contoh Sederhana) ---
$pesan_status = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_pinjam'])) {
    $id_anggota = htmlspecialchars($_POST['id_anggota']);
    $id_buku = htmlspecialchars($_POST['id_buku']);
    
    // 1. Cek validitas anggota dan buku
    $data_anggota = cekData($id_anggota, 'anggota');
    $data_buku = cekData($id_buku, 'buku');
    
    if (!$data_anggota || $data_anggota['status'] != 'Aktif') {
        $pesan_status = "<div style='color: red;'>Error: ID Anggota tidak valid atau status tidak aktif!</div>";
    } elseif (!$data_buku || $data_buku['stok'] <= 0) {
        $pesan_status = "<div style='color: red;'>Error: ID Buku tidak valid atau stok buku habis!</div>";
    } else {
        // 2. Lakukan proses INSERT ke database (Contoh simulasi sukses)
        // QUERY: INSERT INTO peminjaman (id_anggota, id_buku, tgl_pinjam, tgl_kembali_target) VALUES (...)
        // QUERY: UPDATE buku SET stok = stok - 1 WHERE id_buku = $id_buku
        
        $pesan_status = "<div style='color: green;'>Sukses! Buku **" . $data_buku['judul'] . "** berhasil dipinjam oleh **" . $data_anggota['nama'] . "**!</div>";
        // Dalam implementasi nyata, lakukan header redirect
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi Peminjaman - Sistem Informasi Perpustakaan</title>
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
        .form-pinjam, table {
            margin-top: 20px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input[type="text"], .form-group input[type="date"] {
            width: calc(100% - 22px);
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
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
        .btn-success { background-color: #28a745; color: white; }
        .btn-secondary { background-color: #6c757d; color: white; }

        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>📝 Transaksi Peminjaman Buku</h1>
    
    <a href="menuutama.php" class="btn btn-secondary">
        < Kembali ke Menu Utama
    </a>
    
    <hr>
    
    <?php echo $pesan_status; // Menampilkan pesan status/error ?>

    <h2>Input Peminjaman Baru</h2>
    <div class="form-pinjam">
        <form method="POST" action="transaksi_peminjaman.php">
            <div class="form-group">
                <label for="id_anggota">ID Anggota / NISN / NIM:</label>
                <input type="text" id="id_anggota" name="id_anggota" required placeholder="Masukkan ID Anggota">
            </div>
            <div class="form-group">
                <label for="id_buku">ID Buku / ISBN:</label>
                <input type="text" id="id_buku" name="id_buku" required placeholder="Masukkan ID Buku atau ISBN">
                </div>
            <button type="submit" name="submit_pinjam" class="btn btn-success">
                Proses Peminjaman
            </button>
        </form>
    </div>
    
    <hr>
    
    <h2>Daftar Peminjaman Aktif (Belum Kembali)</h2>
    
    <table>
        <thead>
            <tr>
                <th>No. Pinjam</th>
                <th>Tgl Pinjam</th>
                <th>Anggota (ID)</th>
                <th>Judul Buku</th>
                <th>Target Kembali</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if (!empty($peminjaman_aktif)) {
                foreach ($peminjaman_aktif as $pinjam) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($pinjam['id_pinjam']) . "</td>";
                    echo "<td>" . htmlspecialchars($pinjam['tgl_pinjam']) . "</td>";
                    echo "<td>" . htmlspecialchars($pinjam['nama_anggota']) . " (" . htmlspecialchars($pinjam['id_anggota']) . ")</td>";
                    echo "<td>" . htmlspecialchars($pinjam['judul_buku']) . "</td>";
                    echo "<td>" . htmlspecialchars($pinjam['tgl_kembali_target']) . "</td>";
                    echo "<td>";
                    // Tautan ini akan mengarah ke halaman Transaksi Pengembalian (transaksi_pengembalian.php)
                    echo "<a href='transaksi_pengembalian.php?id_pinjam=" . $pinjam['id_pinjam'] . "' class='btn btn-warning btn-sm'>Kembalikan</a>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6' style='text-align: center;'>Tidak ada transaksi peminjaman aktif saat ini.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>