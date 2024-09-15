<?php
class Buku {
    private $conn;
    private $table_name = "buku"; // Nama tabel di database

    public $id_buku;
    public $kode_buku;
    public $judul_buku;
    public $kategori;
    public $cover;
    public $penerbit;
    public $sinopsis;
    public $stok_buku;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Fungsi untuk menampilkan semua data buku
    public function read() {
        // Query untuk mengambil semua data buku
        $query = "SELECT id_buku, kode_buku, judul_buku, cover, penerbit FROM " . $this->table_name;

        // Menyiapkan statement
        $stmt = $this->conn->prepare($query);

        // Eksekusi query
        $stmt->execute();

        return $stmt;
    }

     // Fungsi untuk mencari buku berdasarkan judul
     public function search($query) {
        // Query untuk mencari buku berdasarkan judul dengan LIKE
        $search_query = "SELECT id_buku, judul_buku, cover, penerbit FROM " . $this->table_name . " WHERE judul_buku LIKE ?";
        
        // Menyiapkan statement
        $stmt = $this->conn->prepare($search_query);
        
        // Menambahkan wildcards untuk pencarian parsial
        $search_term = "%{$query}%";
        
        // Bind parameter pencarian
        $stmt->bindParam(1, $search_term);
        
        // Eksekusi query
        $stmt->execute();

        return $stmt;
    }

    public function getDetailBuku($id_buku) {
        // Query untuk mendapatkan detail buku
        $query = "SELECT * FROM " . $this->table_name . " WHERE id_buku = ? LIMIT 0,1";
        
        // Menyiapkan statement
        $stmt = $this->conn->prepare($query);
        
        // Bind ID
        $stmt->bindParam(1, $id_buku);
        
        // Eksekusi query
        $stmt->execute();
        
        // Mengambil data buku
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Set properti buku
        $this->id_buku = $row['id_buku'];
        $this->kode_buku = $row['kode_buku'];
        $this->judul_buku = $row['judul_buku'];
        $this->kategori = $row['kategori'];
        $this->cover = $row['cover'];
        $this->penerbit = $row['penerbit'];
        $this->sinopsis = $row['sinopsis'];
        $this->stok_buku = $row['stok_buku'];
    }

    // Fungsi lain sesuai kebutuhan
}
?>
