<?php
// perpustakaan.php - Menu Utama

// Bagian ini biasanya akan berisi:
// 1. Logika otentikasi (memeriksa apakah pengguna sudah login)
// 2. Koneksi ke database
// 3. Pengambilan data dinamis (misalnya, nama pengguna yang login)

// Anggap saja ini adalah halaman setelah login yang berhasil
$nama_pengguna = "Admin Perpustakaan"; 
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Perpustakaan - Menu Utama</title>
    <style>
        /* Gaya CSS Sederhana untuk tampilan */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            text-align: center;
        }
        .container {
            width: 80%;
            margin: 50px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333;
            margin-bottom: 5px;
        }
        p {
            color: #666;
            margin-bottom: 30px;
            font-size: 1.1em;
        }
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }
        .menu-item {
            background-color: #007bff;
            color: white;
            padding: 20px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 1.2em;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        .menu-item:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Selamat Datang di Sistem Perpustakaan</h1>
    
    <?php
    // Menampilkan nama pengguna yang login (contoh penggunaan PHP)
    echo "<p>Halo, **" . htmlspecialchars($nama_pengguna) . "**! Silakan pilih menu di bawah ini:</p>";
    ?>

    ---

    <h2>📚 Menu Utama</h2>
    
    <div class="menu-grid">
        <a href="kelola.php" class="menu-item">
            Kelola Data Buku
        </a>

        <a href="anggota.php" class="menu-item">
            Kelola Data Anggota
        </a>

        <a href="peminjaman.php" class="menu-item">
            Transaksi Peminjaman
        </a>

        <a href="pengembalian.php" class="menu-item">
            Transaksi Pengembalian
        </a>
        
        <a href="statistik.php" class="menu-item">
            Laporan & Statistik
        </a>
        
        <a href="sistem.php" class="menu-item">
            Pengaturan Sistem
        </a>
    </div>
    
    ---

    <p style="margin-top: 30px;"><a href="logout.php" style="color: #dc3545; text-decoration: none;">**[ Keluar / Logout ]**</a></p>

</div>

</body>
</html>