<?php
// Sertakan file koneksi dan class Buku
include_once 'Database.php';
include_once 'Buku.php';

// Membuat instance koneksi ke database
$database = new Database();
$db = $database->getConnection();

// Membuat instance dari kelas Buku
$buku = new Buku($db);

// Mengambil data pencarian dari permintaan POST
$query = isset($_POST['query']) ? $_POST['query'] : '';

// Memanggil method search untuk mengambil hasil pencarian
$stmt = $buku->search($query);
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Mengembalikan hasil pencarian dalam bentuk JSON
echo json_encode($books);
?>
