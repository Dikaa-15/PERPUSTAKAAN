<?php
session_start();
include_once './Database.php';
include_once './user.php';

$database = new Database();
$db = $database->getConnection();
$user = new User($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user->nama_lengkap = htmlspecialchars($_POST['nama_lengkap']);
    $user->nis = htmlspecialchars($_POST['nis']);
    $user->no_kartu = htmlspecialchars($_POST['no_kartu']);
    $user->no_whatsapp = htmlspecialchars($_POST['no_whatsapp']);
    $user->password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password
    $user->roles = 'user'; // Set default role sebagai 'user'

    if ($user->register()) {
        // Arahkan pengguna ke dashboard sesuai peran
        if ($_SESSION['roles'] == 'user') {
            header("Location: user_dashboard.php");
        } elseif ($_SESSION['roles'] == 'petugas') {
            header("Location: petugas_dashboard.php");
        } else {
            header("Location: admin_dashboard.php");
        }
        exit(); // Hentikan script setelah redirect
    } else {
        echo "Registrasi gagal.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registrasi</title>
</head>
<body>
    <form method="POST">
        <label>Nama Lengkap</label><br>
        <input type="text" name="nama_lengkap" required><br>

        <label>NIS</label><br>
        <input type="number" name="nis" required><br>
        
        <label>no kartu</label><br>
        <input type="number" name="no_kartu" required><br>

        <label>No. Telp</label><br>
        <input type="number" name="no_whatsapp" required><br>

        <label>Password</label><br>
        <input type="password" name="password" required><br>

        <input type="submit" value="Registrasi">
    </form>
</body>
</html>
