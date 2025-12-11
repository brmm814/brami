<?php
// transaksi_pengembalian.php - Halaman Transaksi Pengembalian

// Pengaturan Zona Waktu
date_default_timezone_set('Asia/Jakarta');

// Bagian ini biasanya akan berisi:
// 1. Logika koneksi ke database.
// 2. Logika untuk memproses ID Peminjaman dari $_GET atau formulir.
// 3. Logika untuk menghitung denda.
// 4. Logika untuk memproses pengembalian (UPDATE tabel 'peminjaman' dan 'buku').

// --- SIMULASI DATA PEMINJAMAN YANG AKAN DIKEMBALIKAN ---
$data_peminjaman = null;
$pesan_status = '';

// Anggap ID Peminjaman (id_pinjam) diambil dari parameter URL atau formulir
$id_pinjam = isset($_REQUEST['id_pinjam']) ? htmlspecialchars($_REQUEST['id_pinjam']) : '';

if (!empty($id_pinjam)) {
    // --- SIMULASI QUERY DATABASE: Ambil data peminjaman berdasarkan ID ---
    if ($id_pinjam == '501') {
        $data_peminjaman = [
            'id_pinjam' => 501,
            'id_buku' => 2,
            'judul_buku' => 'Dasar Pemrograman PHP dan MySQL',
            'nama_anggota' => 'Slamet Santoso',
            'tgl_pinjam' => '2025-11-20',
            'tgl_kembali_target' => '2025-11-27', // Target 7 hari
            'status' => 'Belum Kembali'
        ];
    } elseif ($id_pinjam == '503') {
        // Contoh ID yang sudah dikembalikan
        $pesan_status = "<div style='color: blue;'>Transaksi Peminjaman ID: 503 sudah tercatat sebagai sudah dikembalikan.</div>";
    } else {
        $pesan_status = "<div style='color: red;'>Error: ID Peminjaman **$id_pinjam** tidak ditemukan atau sudah selesai.</div>";
    }
}

// --- LOGIKA PERHITUNGAN DENDA (Contoh Sederhana) ---
$denda_per_hari = 1000; // Rp 1000 per hari
$denda = 0;
$keterlambatan_hari = 0;
$tgl_kembali_aktual = date('Y-m-d'); // Tanggal hari ini

if ($data_peminjaman) {
    $tgl_target = new DateTime($data_peminjaman['tgl_kembali_target']);
    $tgl_aktual = new DateTime($tgl_kembali_aktual);

    if ($tgl_aktual > $tgl_target) {
        $interval = $tgl_target->diff($tgl_aktual);
        $keterlambatan_hari = $interval->days;
        $denda = $keterlambatan_hari * $denda_per_hari;
    }
}

// --- LOGIKA PEMROSESAN FORMULIR PENGEMBALIAN ---
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_kembali']) && $data_peminjaman) {
    // 1. Lakukan proses UPDATE database
    // QUERY: UPDATE peminjaman SET tgl_kembali_aktual = '$tgl_kembali_aktual', denda = $denda, status = 'Sudah Kembali' WHERE id_pinjam = $id_pinjam
    
    // 2. Lakukan proses UPDATE stok buku
    // QUERY: UPDATE buku SET stok = stok + 1 WHERE id_buku = $data_peminjaman['id_buku']
    
    $pesan_status = "<div style='color: green;'>Sukses! Buku **" . $data_peminjaman['judul_buku'] . "** telah dikembalikan. Denda: **Rp " . number_format($denda, 0, ',', '.') . "**</div>";
    // Hapus data_peminjaman agar formulir tidak muncul lagi setelah sukses
    $data_peminjaman = null; 
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi Pengembalian - Sistem Informasi Perpustakaan</title>
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
        .data-info {
            border: 1px solid #007bff;
            padding: 15px;
            border-radius: 6px;
            background-color: #e9f5ff;
            margin-bottom: 20px;
        }
        .data-info p { margin: 5px 0; }
        .denda {
            padding: 10px;
            background-color: #fff3cd;
            border: 1px solid #ffeeba;
            color: #856404;
            margin-top: 15px;
            border-radius: 4px;
            font-weight: bold;
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
        .btn-success { background-color: #17a2b8; color: white; } /* Warna berbeda untuk pengembalian */
        .btn-secondary { background-color: #6c757d; color: white; }
        .form-group input[type="text"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 300px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>↩️ Transaksi Pengembalian Buku</h1>
    
    <a href="menuutama.php" class="btn btn-secondary">
        < Kembali ke Menu Utama
    </a>
    <a href="transaksi_peminjaman.php" class="btn btn-secondary">
        Lihat Peminjaman Aktif
    </a>
    
    <hr>
    
    <?php echo $pesan_status; // Menampilkan pesan status/error ?>

    <?php if (empty($id_pinjam) && !$data_peminjaman): ?>
    <h2>Cari Transaksi Peminjaman</h2>
    <form method="GET" action="transaksi_pengembalian.php">
        <div class="form-group">
            <label for="id_pinjam">ID Peminjaman:</label>
            <input type="text" id="id_pinjam" name="id_pinjam" required placeholder="Cari ID Peminjaman (Contoh: 501)">
        </div>
        <button type="submit" class="btn btn-secondary">Cari Data</button>
    </form>
    <hr>
    <?php endif; ?>

    <?php if ($data_peminjaman): ?>
    <h2>Detail Pengembalian ID: <?php echo htmlspecialchars($id_pinjam); ?></h2>

    <div class="data-info">
        <p><strong>Anggota:</strong> <?php echo htmlspecialchars($data_peminjaman['nama_anggota']); ?></p>
        <p><strong>Judul Buku:</strong> <?php echo htmlspecialchars($data_peminjaman['judul_buku']); ?></p>
        <p><strong>Tanggal Pinjam:</strong> <?php echo htmlspecialchars($data_peminjaman['tgl_pinjam']); ?></p>
        <p><strong>Target Kembali:</strong> <?php echo htmlspecialchars($data_peminjaman['tgl_kembali_target']); ?></p>
        <p><strong>Tanggal Kembali Aktual:</strong> <?php echo $tgl_kembali_aktual; ?></p>
        
        <?php if ($keterlambatan_hari > 0): ?>
        <div class="denda">
            Keterlambatan: **<?php echo $keterlambatan_hari; ?> hari**
            <br>
            Total Denda (<?php echo number_format($denda_per_hari, 0, ',', '.'); ?>/hari): **Rp <?php echo number_format($denda, 0, ',', '.'); ?>**
        </div>
        <?php else: ?>
        <div class="denda" style="background-color: #d4edda; border-color: #c3e6cb; color: #155724;">
            Pengembalian Tepat Waktu! Tidak ada denda.
        </div>
        <?php endif; ?>
    </div>

    <form method="POST" action="transaksi_pengembalian.php">
        <input type="hidden" name="id_pinjam" value="<?php echo htmlspecialchars($id_pinjam); ?>">
        <input type="hidden" name="denda" value="<?php echo $denda; ?>">
        <input type="hidden" name="tgl_kembali" value="<?php echo $tgl_kembali_aktual; ?>">
        
        <button type="submit" name="submit_kembali" class="btn btn-success">
            Konfirmasi Pengembalian & Catat Denda
        </button>
    </form>

    <?php endif; ?>

</div>

</body>
</html>