<?php
// Mulai sesi
session_start();

// Sertakan file koneksi ke database
include_once 'Database.php';

$database = new Database();
$db = $database->getConnection();

// Pastikan pengguna sudah login
if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit();
}

$id_user = $_SESSION['id_user'];

// Ambil data peminjaman milik pengguna yang sedang login
$query = "SELECT p.*, b.judul_buku, u.nama_lengkap 
          FROM peminjaman p 
          JOIN buku b ON p.id_buku = b.id_buku 
          JOIN user u ON p.id_user = u.id_user
          WHERE p.id_user = :id_user";

$stmt = $db->prepare($query);
$stmt->bindParam(':id_user', $id_user);
$stmt->execute();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- ...head elements... -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Peminjaman</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mx-auto mt-5">
        <h1 class="text-3xl font-bold mb-5">Data Peminjaman Buku</h1>

        <table class="table-auto w-full">
            <thead>
                <tr>
                    <th class="border px-4 py-2">Nama Peminjam</th>
                    <th class="border px-4 py-2">Judul Buku</th>
                    <th class="border px-4 py-2">Jumlah Buku</th>
                    <th class="border px-4 py-2">Tanggal Peminjaman</th>
                    <th class="border px-4 py-2">Tanggal Pengembalian</th>
                    <th class="border px-4 py-2">Status</th>
                    <th class="border px-4 py-2">Petugas</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                    <tr>
                        <td class="border px-4 py-2"><?= htmlspecialchars($row['nama_lengkap']); ?></td>
                        <td class="border px-4 py-2"><?= htmlspecialchars($row['judul_buku']); ?></td>
                        <td class="border px-4 py-2"><?= $row['kuantitas_buku']; ?></td>
                        <td class="border px-4 py-2"><?= $row['tanggal_peminjaman']; ?></td>
                        <td class="border px-4 py-2"><?= $row['tanggal_kembalian']; ?></td>
                        <td class="border px-4 py-2"><?= $row['status_peminjaman'];?></td>
                        <td class="border px-4 py-2"><?= $row['nama_petugas'] ?? '-';?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
