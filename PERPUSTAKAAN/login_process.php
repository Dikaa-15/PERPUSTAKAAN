<?php
session_start();
include_once './Database.php';
include_once './user.php';

$database = new Database();
$db = $database->getConnection();
$user = new User($db);

// Tangkap input dari form
$user->no_kartu = $_POST['no_kartu'];
$user->password = $_POST['password'];

// Debugging input
error_log('Submitted no_kartu: ' . $user->no_kartu);
error_log('Submitted password: ' . $user->password);

// Periksa login
if ($user->login()) {
    $_SESSION['roles'] = $user->roles;
    $_SESSION['no_kartu'] = $user->no_kartu;

    // Redirect berdasarkan role
    if ($_SESSION['roles'] === 'admin') {
        header("Location: admin_dashboard.php");
    } elseif ($_SESSION['roles'] === 'petugas') {
        header("Location: petugas_dashboard.php");
    } else {
        header("Location: user_dashboard.php");
    }
    exit(); // Hentikan script setelah redirect
} else {
    error_log('Login failed for no_kartu: ' . $user->no_kartu);
    header("Location: login.php");
    exit(); // Hentikan script setelah redirect
}
?>
