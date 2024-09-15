<?php

require_once './App/core/Controller.php';
require_once '../PERPUSTAKAAN/config/Database.php';
require_once 'App/Models/buku.php';
class BukuController extends controller{
    private $table = "buku";
    private $buku;
    private $db;


    public function index()
    {
        $stmt = $this->buku->read();    
        $this->model('buku')->getDetailBuku();
        $this->view('Buku/Buku');
    }


    public function view($view, $data = []) {
        extract($data); // Ekstrak data menjadi variabel
        require_once 'App/Views/' . $view . '.php'; // Load view file
    }   

    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        $this->buku = new Buku($db);
    }

    public function getAllBuku() {
        $stmt = $this->buku->read();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // public function getBukuById()
    // {
    //     $this->db->query('SELECT * FROM ' . $this->$table. 'WHERE id=:id');
    //     $this->db->bind('id', $id);
    //     return $this->db->single();
    // }


    public function createBuku($data) {
        $this->buku->kode_buku = $data['kode_buku'];
        $this->buku->judul_buku = $data['judul_buku'];
        $this->buku->kategori = $data['kategori'];
        $this->buku->cover = $data['cover'];
        $this->buku->penerbit = $data['penerbit'];
        $this->buku->sinopsis = $data['sinopsis'];
        $this->buku->stok_buku = $data['stok_buku'];

        if ($this->buku->create()) {
            return "Book created successfully.";
        } else {
            return "Failed to create book.";
        }
    }

    public function updatebuku($data) {
        $this->buku->id_buku = $data['id_buku'];
        $this->buku->kode_buku = $data['kode_buku'];
        $this->buku->judul_buku = $data['judul_buku'];
        $this->buku->kategori = $data['kategori'];
        $this->buku->cover = $data['cover'];
        $this->buku->penerbit = $data['penerbit'];
        $this->buku->sinopsis = $data['sinopsis'];
        $this->buku->stok_buku = $data['stok_buku'];

        if ($this->buku->update()) {
            return "Book updated successfully.";
        } else {
            return "Failed to update book.";
        }
    }

    public function deletebuku($id) {
        $this->buku->id_buku = $id;
        if ($this->buku->delete()) {
            return "Book deleted successfully.";
        } else {
            return "Failed to delete book.";
        }
    }

    public function searchBuku($keyword) {
        return $this->buku->searchByTitle($keyword);
    }

    public function showDetail($id_buku) {
        $this->buku->getDetailBuku($id_buku);
    
        if ($this->buku->id_buku) {
            // Meneruskan data buku ke view
            $buku = $this->buku;
            include '../app/views/detailBuku.php';
        } else {
            echo "Buku tidak ditemukan!";
        }
    }
    
}
?>