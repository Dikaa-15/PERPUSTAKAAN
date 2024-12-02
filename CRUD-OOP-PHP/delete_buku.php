<?php

require_once './Buku.php';

$database = new Database();
$db = $database->getConnection();

$buku = new Buku($db);

if(isset($_GET['id']))
{
    $id_buku = $_GET['id'];
    $result = $buku->delete($id_buku);
    if($result)
    {
        Header("Location: ./index.php");
        exit();
    } else{
        echo "Gagal Menghapus data buku";
    }
} else {
    echo "Tidak ada ID yang dikirim";
}