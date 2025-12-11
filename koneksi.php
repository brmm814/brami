<?php
$host = "localhost"; // Nama server database
$user = "root";      // Username default XAMPP
$pass = "";          // Password default XAMPP (biasanya kosong)
$db = "db_login";    // Nama database yang kita buat

$koneksi = mysqli_connect($host, $user, $pass, $db);

// Cek koneksi
if (mysqli_connect_errno()){
    echo "Koneksi database gagal: " . mysqli_connect_error();
    die(); // Hentikan skrip jika koneksi gagal
}
// echo "Koneksi berhasil!"; // Opsional: Untuk pengujian
?>
