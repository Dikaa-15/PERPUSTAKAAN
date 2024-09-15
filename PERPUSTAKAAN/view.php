<?php


require_once './UserController.php';

$userController = new UserController();
$users = $userController->getAllUsers();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    
</head>
<body class="bg-gray-100">

    <div class="container mx-auto py-8">
        <h1 class="text-3xl font-bold text-center mb-8">Admin Dashboard</h1>

        <div>
            <button type="submit" name="cari" class="btn btn-success" id="tombolCari">Search </button>
            <input type="text" name="keyword" size="10" autofocus placeholder="Cari Pesanan " autocomplete="off" class="first-letter:" id="keyword">
        </div>
        
        <!-- Tombol untuk masuk ke halaman tambah data -->
        <div class="text-right mb-4">
            <a href="create.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Tambah Data</a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white shadow-md rounded-lg">
                <thead>
                    <tr>
                        <th class="py-3 px-6 bg-gray-200 font-bold text-gray-600 uppercase text-sm text-left">ID</th>
                        <th class="py-3 px-6 bg-gray-200 font-bold text-gray-600 uppercase text-sm text-left">Nama Lengkap</th>
                        <th class="py-3 px-6 bg-gray-200 font-bold text-gray-600 uppercase text-sm text-left">NIS</th>
                        <th class="py-3 px-6 bg-gray-200 font-bold text-gray-600 uppercase text-sm text-left">NISN</th>
                        <th class="py-3 px-6 bg-gray-200 font-bold text-gray-600 uppercase text-sm text-left">Kelas</th>
                        <th class="py-3 px-6 bg-gray-200 font-bold text-gray-600 uppercase text-sm text-left">No Whatsapp</th>
                        <th class="py-3 px-6 bg-gray-200 font-bold text-gray-600 uppercase text-sm text-left">No Kartu</th>
                        <th class="py-3 px-6 bg-gray-200 font-bold text-gray-600 uppercase text-sm text-left">Roles</th>
                        <th class="py-3 px-6 bg-gray-200 font-bold text-gray-600 uppercase text-sm text-left">Edit Data</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user) : ?>
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="py-3 px-6 text-left whitespace-nowrap"><?= $user['id_user'] ?></td>
                            <td class="py-3 px-6 text-left"><?= $user['nama_lengkap'] ?></td>
                            <td class="py-3 px-6 text-left"><?= $user['nis'] ?></td>
                            <td class="py-3 px-6 text-left"><?= $user['nisn'] ?></td>
                            <td class="py-3 px-6 text-left"><?= $user['kelas'] ?></td>
                            <td class="py-3 px-6 text-left"><?= $user['no_whatsapp'] ?></td>
                            <td class="py-3 px-6 text-left"><?= $user['no_kartu'] ?></td>
                            <td class="py-3 px-6 text-left"><?= $user['roles'] ?></td>
                            <td class="py-3 px-6 text-left">
                                <a href="edit.php?id=<?= $user['id_user'] ?>" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Edit</a>
                                <a href="delete.php?id=<?= $user['id_user'] ?>" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded ml-2">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="container flex gap-4 mt-10">
            <?php foreach ($users as $user): ?>
                <div class="border-2 border-gray-300">
                    <h1><?= $user['nama_lengkap']; ?></h1>
                    <p>NIS: <?= $user['nis'];?></p>
                </div>
                <?php endforeach; ?>
        </div>
    </div>

</body>
</html>
