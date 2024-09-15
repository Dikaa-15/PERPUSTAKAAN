<?php
session_start();

// Sertakan file koneksi ke database
include_once 'Database.php';

// Membuat instance koneksi ke database
$database = new Database();
$db = $database->getConnection();

// Inisialisasi variabel
$error = '';

// Jika form disubmit
if ($_POST) {
    $no_kartu = $_POST['no_kartu'];
    $password = $_POST['password'];

    // Ambil data pengguna berdasarkan no_kartu
    $query = "SELECT * FROM user WHERE no_kartu = :no_kartu LIMIT 1";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':no_kartu', $no_kartu);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verifikasi password
    if ($user && password_verify($password, $user['password'])) {
        // Set variabel sesi
        $_SESSION['id_user'] = $user['id_user'];
        $_SESSION['no_kartu'] = $user['no_kartu'];

        // Regenerasi ID sesi untuk keamanan
        session_regenerate_id(true);

        // Periksa parameter redirect
        if (isset($_GET['redirect'])) {
            $redirect_url = $_GET['redirect'];
            // Validasi bahwa redirect_url adalah path internal
            if (strpos($redirect_url, '/') === 0) {
                // Arahkan ke halaman yang diminta
                header("Location: " . $redirect_url);
            } else {
                // Redirect URL tidak valid, arahkan ke halaman default
                header("Location: index.php");
            }
        } else {
            header("Location: index.php"); // halaman default setelah login
        }
        exit();
    } else {
        $error = "No Kartu atau password salah.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- ...elemen head lainnya... -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Tambahkan stylesheet atau script jika diperlukan -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
    <!-- Form Login -->
    <div class="container mx-auto mt-5">
        <h1 class="text-3xl font-bold mb-5">Login</h1>
        <?php if($error): ?>
            <div class="bg-red-100 text-red-700 px-4 py-2 mb-4"><?= $error; ?></div>
        <?php endif; ?>
        <form action="" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <!-- Input No Kartu -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">No Kartu</label>
                <input type="text" name="no_kartu" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <!-- Input Password -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                <input type="password" name="password" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <!-- Tombol Submit -->
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Login</button>
            </div>
        </form>
    </div>
</body>
</html>
