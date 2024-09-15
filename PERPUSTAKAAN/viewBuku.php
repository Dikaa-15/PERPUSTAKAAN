<?php
// Sertakan file koneksi dan class Buku
include_once 'Database.php';
include_once 'Buku.php';

// Membuat instance koneksi ke database
$database = new Database();
$db = $database->getConnection();

// Membuat instance dari kelas Buku dengan menyertakan koneksi database
$buku = new Buku($db);

// Mengambil semua data buku
$stmt = $buku->read();
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
    <h1>Data Buku</h1>

    <input type="text" id="search" placeholder="Cari judul buku..." class="focus:outline outline-gray-500">

    <div class="flex gap-5 mx-5 mt-5" id="book-table">
        <?php foreach($books as $data): ?>
        <div class="border-2 border-gray p-3">
            <a href="detailBuku.php?id_buku=<?= $data['id_buku']; ?>">
                <img src="<?= $data['cover']; ?>" alt="Cover Buku" width="100">
                <h1><?= $data['judul_buku']; ?></h1>
                <p><?= $data['penerbit']; ?></p>
            </a>
        </div>
        <?php endforeach; ?>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#search').on('keyup', function() {
            var query = $(this).val();
            $.ajax({
                url: 'live_searching.php',
                method: 'POST',
                data: {query: query},
                dataType: 'json',
                success: function(data) {
                    var rows = '';
                    data.forEach(function(book) {
                        rows += `<div class="border-2 border-black p-3">
                                    <a href="detailBuku.php?id_buku=${book.id_buku}">
                                        <img src="${book.cover}" width="100" alt="Cover Buku"></img>
                                        <h1>${book.judul_buku}</h1>
                                        <p>${book.penerbit}</p>
                                    </a>
                                 </div>`;
                    });
                    $('#book-table').html(rows);
                }
            });
        });
    });
    </script>

</body>
</html>
