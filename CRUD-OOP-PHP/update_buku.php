<?php

require_once './Buku.php';
require_once './Database.php';

$database = new Database();
$db = $database->getConnection();

$buku = new Buku($db);

$id_buku = $_GET['id'];
$dataBuku = $buku->getById($id_buku);

if (isset($_POST['update'])) {
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $penerbit = $_POST['penerbit'];
    $jumlah_halaman = $_POST['jumlah_halaman'];
    $stok = $_POST['stok'];
    $sinopsis = $_POST['sinopsis'];

    $buku->update($id_buku, $judul, $penulis, $penerbit, $jumlah_halaman, $stok, $sinopsis);
    header("Location: ./index.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
    <h1 class="text-center ">Edit buku</h1>
    <div class="container">
    <div class="modal-body">
        <form action="" method="POST">
            <div class="mb-3">
                <label for="" class="form-lable">Judul buku</label>
                <input type="text" class="form-control" name="judul" value="<?= $dataBuku['judul'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="" class="form-lable">Penulis</label>
                <input type="text" class="form-control" name="penulis" value="<?= $dataBuku['penulis'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="" class="form-lable">penerbit</label>
                <input type="text" class="form-control" name="penerbit" value="<?= $dataBuku['penerbit'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="" class="form-lable">jumlah_halaman</label>
                <input type="text" class="form-control" name="jumlah_halaman" value="<?= $dataBuku['jumlah_halaman'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="" class="form-lable">stok</label>
                <input type="text" class="form-control" name="stok" value="<?= $dataBuku['stok'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="" class="form-lable">sinopsis</label>
                <textarea class="form-control"  name="sinopsis" id="sinopsis"><?= $dataBuku['sinopsis'] ?></textarea>
                <!-- <input type="text" class="form-control" name="sinopsis" value="<?= $dataBuku['sinopsis'] ?>" required> -->
            </div>
            <button type="submit" name="update" class="btn btn-primary px-5 py-2 p-2 mx-auto" width="200px">Save</button>

        </form>
    </div>
    </div>
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>