<?php

require_once './Database.php';

class Buku
{
    private $conn;
    private $tbl_name = "tbl_buku";

    public $id_buku;
    public $judul;
    public $penulis;
    public $penerbit;
    public $jumlah_halaman;
    public $stok;
    public $sinopsis;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function read()
    {
        $query = "SELECT id_buku, judul, penulis, penerbit, jumlah_halaman, stok, sinopsis FROM " . $this->tbl_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function getById($id_buku)
    {
        $query = "SELECT * FROM " . $this->tbl_name . " WHERE id_buku = :id_buku";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id_buku", $id_buku);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function delete($id_buku)
    {
        $query = "DELETE FROM " . $this->tbl_name . " WHERE id_buku = :id_buku";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id_buku", $id_buku, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function update($id_buku, $judul, $penulis, $penerbit, $jumlah_halaman, $stok, $sinopsis)
    {
        // Query dengan klausa WHERE untuk memastikan pembaruan hanya terjadi pada buku tertentu
        $query = "UPDATE " . $this->tbl_name . " 
              SET judul = :judul, 
                  penulis = :penulis, 
                  penerbit = :penerbit, 
                  jumlah_halaman = :jumlah_halaman, 
                  stok = :stok, 
                  sinopsis = :sinopsis 
              WHERE id_buku = :id_buku";

        $stmt = $this->conn->prepare($query);

        // Bind semua parameter dengan nama yang sesuai
        $stmt->bindParam(':id_buku', $id_buku);
        $stmt->bindParam(':judul', $judul);
        $stmt->bindParam(':penulis', $penulis);
        $stmt->bindParam(':penerbit', $penerbit);
        $stmt->bindParam(':jumlah_halaman', $jumlah_halaman);
        $stmt->bindParam(':stok', $stok);
        $stmt->bindParam(':sinopsis', $sinopsis);

        // Eksekusi pernyataan dan kembalikan hasil
        return $stmt->execute();
    }
}
