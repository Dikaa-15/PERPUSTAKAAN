<?php

require_once './Buku.php';

$database = new Database();
$db = $database->getConnection();

$buku = new Buku($db);

$data = $buku->read();
$bukus = $data->fetchAll(PDO::FETCH_ASSOC);


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

$i = 1;



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
    <h1 class="text-center mt-3">Table Buku perpustakaan</h1>

    <div class="container mt-5">
        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addModal">
            Add Buku <i class="bi bi-plus"></i>
        </button>
        <table class="table table-hover table-striped table-bordered">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Judul Buku</th>
                    <th scope="col">Penulis</th>
                    <th scope="col">Penerbit</th>
                    <th scope="col">Jumlah Halaman</th>
                    <th scope="col">Stok</th>
                    <th scope="col">Sinopsis</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                <?php foreach ($bukus as $i => $row) : ?>
                    <tr>
                        <th scope="row"><?= $i + 1 ?></th>
                        <td><?= $row['judul'] ?></td>
                        <td><?= $row['penulis'] ?></td>
                        <td><?= $row['penerbit'] ?></td>
                        <td><?= $row['jumlah_halaman'] ?></td>
                        <td><?= $row['stok'] ?></td>
                        <td><?= $row['sinopsis'] ?></td>
                        <td>
                            <a href="./update_buku.php?id=<?= $row['id_buku'] ?> " class="bg-warning text-white px-3 py-2"><i class="bi bi-pencil-square"></i></a>
                            <a href="./delete_buku.php?id=<?= $row['id_buku'] ?>" class="bg-danger text-white px-3 py-2" onclick="return confirm('Ingin hapus data?')"><i class="bi bi-trash"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>


    <!-- Add Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST">
                        <div class="mb-3">
                            <label for="judul" class="form-lable">Judul Buku</label>
                            <input type="text" class="form-control" id="judul" name="judul" required>
                        </div>
                        <div class="mb-3">
                            <label for="penulis" class="form-lable">Penulis</label>
                            <input type="text" class="form-control" id="penulis" name="penulis" required>
                        </div>
                        <div class="mb-3">
                            <label for="penerbit" class="form-lable">Penerbit</label>
                            <input type="text" class="form-control" id="penerbit" name="penerbit" required>
                        </div>
                        <div class="mb-3">
                            <label for="jumlah_halaman" class="form-lable">Jumlah halaman</label>
                            <input type="number" class="form-control" id="jumlah_halaman" name="jumlah_halaman" required>
                        </div>
                        <div class="mb-3">
                            <label for="stok" class="form-lable">Stok</label>
                            <input type="number" class="form-control" id="stok" name="stok" required>
                        </div>
                        <div class="mb-3">
                            <label for="sinopsis" class="form-lable">Sinopsis Buku</label>
                            <input type="text" class="form-control" id="sinopsis" name="sinopsis" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add Buku</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- Update Modal -->
    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="updateModalLabel">Update buku</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="./update_buku.php" method="POST">
                        <div class="mb-3">
                            <label for="judul" class="form-lable">Judul Buku</label>
                            <input type="text" class="form-control" id="judul" name="judul" required value="<?= $dataBuku['judul'] ?>">
                        </div>
                        <div class="mb-3">
                            <label for="penulis" class="form-lable">Penulis</label>
                            <input type="text" class="form-control" id="penulis" name="penulis" required>
                        </div>
                        <div class="mb-3">
                            <label for="penerbit" class="form-lable">Penerbit</label>
                            <input type="text" class="form-control" id="penerbit" name="penerbit" required>
                        </div>
                        <div class="mb-3">
                            <label for="jumlah_halaman" class="form-lable">Jumlah halaman</label>
                            <input type="number" class="form-control" id="jumlah_halaman" name="jumlah_halaman" required>
                        </div>
                        <div class="mb-3">
                            <label for="stok" class="form-lable">Stok</label>
                            <input type="number" class="form-control" id="stok" name="stok" required>
                        </div>
                        <div class="mb-3">
                            <label for="sinopsis" class="form-lable">Sinopsis Buku</label>
                            <input type="text" class="form-control" id="sinopsis" name="sinopsis" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add Buku</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>