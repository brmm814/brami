<?php
// logout.php

// 1. Mulai sesi
session_start();

// 2. Hancurkan semua variabel sesi
$_SESSION = array(); // Kosongkan array $_SESSION

// 3. Jika menggunakan cookies sesi (seperti PHPSESSID), hapus juga cookie tersebut
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// 4. Hancurkan sesi
session_destroy();

// 5. Arahkan pengguna kembali ke halaman login
header("location: index.php");
exit;
?>