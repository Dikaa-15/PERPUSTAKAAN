<?php

require_once './Buku.php';

$database = new Database();
$db = $database->getConnection();

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $penerbit = $_POST['penerbit'];
    $jumlah_halaman = $_POST['jumlah_halaman'];
    $stok = $_POST['stok'];
    $sinopsis = $_POST['sinopsis'];

    $query = "INSERT INTO tbl_buku(judul,penulis,penerbit,jumlah_halaman, stok, sinopsis) VALUES(?,?,?,?,?,?)";
    $stmt = $db->prepare($query);

    if($stmt->execute([$judul, $penulis, $penerbit, $jumlah_halaman, $stok, $sinopsis]))
    {
        header("Location: ./index.php");
        exit();
    } else {
        echo "gagal menambahkan data baru";
    }
}