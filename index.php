<?php
// Mulai sesi
session_start();

// Inisialisasi variabel untuk pesan error
$error_message = "";

// --- 1. Konfigurasi Database ---
$servername = "localhost"; // Biasanya 'localhost'
$db_username = "root";     // Ganti dengan username DB Anda
$db_password = "";         // Ganti dengan password DB Anda
$dbname = "db_login";      // Nama database Anda: db_login

// --- 2. Proses Login jika Form Dikirim ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Membuat koneksi ke database
    $conn = new mysqli($servername, $db_username, $db_password, $dbname);

    // Cek koneksi
    if ($conn->connect_error) {
        // Pada aplikasi produksi, ini harus dicatat, bukan ditampilkan
        $error_message = "Koneksi database gagal."; 
    } else {
        
        // Ambil dan bersihkan input
        // real_escape_string digunakan karena kita tetap mengirim data yang sudah dibersihkan ke statement
        $username = $conn->real_escape_string($_POST['username']);
        $password_input = $_POST['password'];

        // Menggunakan Prepared Statement untuk mencegah SQL Injection (PENTING!)
        $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
        $stmt->bind_param("s", $username); // "s" menunjukkan tipe string
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            // User ditemukan, ambil hash password dari DB
            $row = $result->fetch_assoc();
            $hashed_password = $row['password'];

            // Verifikasi Password menggunakan hash
            if (password_verify($password_input, $hashed_password)) {
                // Login Berhasil
                $_SESSION['loggedin'] = TRUE;
                $_SESSION['username'] = $username;
                
                // Arahkan ke menu utama
                header("Location: menuutama.php");
                exit; 
            } else {
                // Password salah
                $error_message = "Username atau Password salah!";
            }
        } else {
            // User tidak ditemukan
            $error_message = "Username atau Password salah!";
        }
        
        $stmt->close();
        $conn->close();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Login</title>
    <style>
        /* Gaya dasar untuk form agar lebih rapi secara visual */
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            background-color: #f4f4f4;
        }
        .login-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box; 
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #0056b3;
        }
        .error {
            color: red;
            text-align: center;
            margin-bottom: 15px;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <h2>Login</h2>

        <?php if (!empty($error_message)): ?>
            <div class="error"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <form id="loginForm" method="POST" action="menuutama.php"> 
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            
            <button type="submit">Login</button>
        </form>
    </div>

</body>
</html>
