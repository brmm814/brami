<?php
// pengaturan_sistem.php - Halaman Pengaturan Sistem

// Bagian ini biasanya akan berisi:
// 1. Logika koneksi ke database.
// 2. Query untuk mengambil nilai pengaturan sistem saat ini (dari tabel 'settings' atau sejenisnya).
// 3. Logika untuk memproses formulir (UPDATE nilai pengaturan di database).

// --- SIMULASI PENGAMBILAN NILAI PENGATURAN SAAT INI ---
$settings = [
    'max_durasi_pinjam' => 7, // Hari
    'denda_per_hari' => 1000, // Rupiah
    'max_buku_pinjam' => 3,
    'nama_perpustakaan' => 'Perpustakaan Digital ABC',
    'email_notifikasi' => 'admin@perpustakaanabc.id'
];
// --- AKHIR SIMULASI DATA ---

$pesan_status = '';

// --- LOGIKA PEMROSESAN FORMULIR PENGATURAN ---
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_settings'])) {
    
    // Ambil data dari formulir
    $max_durasi = (int)$_POST['max_durasi_pinjam'];
    $denda = (int)$_POST['denda_per_hari'];
    $max_buku = (int)$_POST['max_buku_pinjam'];
    $nama_perpus = htmlspecialchars($_POST['nama_perpustakaan']);
    $email_notif = htmlspecialchars($_POST['email_notifikasi']);

    // Validasi sederhana
    if ($max_durasi <= 0 || $denda < 0 || $max_buku <= 0) {
        $pesan_status = "<div style='color: red;'>Error: Nilai durasi peminjaman, denda, atau batas buku tidak valid!</div>";
    } else {
        // --- SIMULASI UPDATE KE DATABASE ---
        // Dalam implementasi nyata, jalankan query UPDATE untuk setiap setting
        
        // Contoh: UPDATE settings SET nilai = $max_durasi WHERE kunci = 'max_durasi_pinjam'
        
        // Perbarui array settings simulasi untuk mencerminkan perubahan
        $settings['max_durasi_pinjam'] = $max_durasi;
        $settings['denda_per_hari'] = $denda;
        $settings['max_buku_pinjam'] = $max_buku;
        $settings['nama_perpustakaan'] = $nama_perpus;
        $settings['email_notifikasi'] = $email_notif;

        $pesan_status = "<div style='color: green;'>Sukses! Pengaturan sistem berhasil diperbarui.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Sistem - Sistem Informasi Perpustakaan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 80%;
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
            margin: 5px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            font-weight: bold;
            display: inline-block;
        }
        .btn-primary { background-color: #ffc107; color: #333; }
        .btn-secondary { background-color: #6c757d; color: white; }

        .form-group {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #eee;
            border-left: 5px solid #007bff;
            border-radius: 4px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }
        .form-group input[type="text"], .form-group input[type="number"], .form-group input[type="email"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box; /* Agar padding tidak melebarkan input */
        }
    </style>
</head>
<body>

<div class="container">
    <h1>⚙️ Pengaturan Sistem Perpustakaan</h1>
    
    <a href="menuutama.php" class="btn btn-secondary">
        < Kembali ke Menu Utama
    </a>
    
    <hr>
    
    <?php echo $pesan_status; // Menampilkan pesan status/error ?>

    <form method="POST" action="pengaturan_sistem.php">
        
        <h2>Pengaturan Umum</h2>
        <div class="form-group">
            <label for="nama_perpustakaan">Nama Perpustakaan:</label>
            <input type="text" id="nama_perpustakaan" name="nama_perpustakaan" 
                   value="<?php echo htmlspecialchars($settings['nama_perpustakaan']); ?>" required>
        </div>
        <div class="form-group">
            <label for="email_notifikasi">Email Notifikasi Sistem:</label>
            <input type="email" id="email_notifikasi" name="email_notifikasi" 
                   value="<?php echo htmlspecialchars($settings['email_notifikasi']); ?>" required>
        </div>
        
        <h2>Pengaturan Transaksi Peminjaman</h2>
        <div class="form-group">
            <label for="max_durasi_pinjam">Durasi Maksimum Peminjaman (Hari):</label>
            <input type="number" id="max_durasi_pinjam" name="max_durasi_pinjam" min="1" 
                   value="<?php echo htmlspecialchars($settings['max_durasi_pinjam']); ?>" required>
            <small>Durasi maksimal buku boleh dipinjam sebelum dianggap terlambat.</small>
        </div>
        
        <div class="form-group">
            <label for="max_buku_pinjam">Batas Maksimum Buku per Anggota:</label>
            <input type="number" id="max_buku_pinjam" name="max_buku_pinjam" min="1" 
                   value="<?php echo htmlspecialchars($settings['max_buku_pinjam']); ?>" required>
            <small>Jumlah maksimal buku yang bisa dipinjam oleh satu anggota.</small>
        </div>

        <div class="form-group">
            <label for="denda_per_hari">Besar Denda per Hari Keterlambatan (Rp):</label>
            <input type="number" id="denda_per_hari" name="denda_per_hari" min="0" 
                   value="<?php echo htmlspecialchars($settings['denda_per_hari']); ?>" required>
            <small>Contoh: 1000 berarti Rp 1.000,- per hari.</small>
        </div>

        <button type="submit" name="submit_settings" class="btn btn-primary">
            Simpan Pengaturan
        </button>
    </form>
</div>

</body>
</html>