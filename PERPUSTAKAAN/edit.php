
<?php
require_once 'UserController.php';

$userController = new UserController();

if (isset($_GET['id'])) {
    $id_user = $_GET['id'];
    $users = $userController->getAllUsers(); // Fetch users to display the current values
    $user_data = null;

    foreach ($users as $user) {
        if ($user['id_user'] == $id_user) {
            $user_data = $user;
            break;
        }
    }

    if (!$user_data) {
        echo "User not found.";
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $result = $userController->updateUser($_POST);
    
    if ($result) {
        header('Location: view.php?status=updated'); // Redirect ke view.php dengan status updated
        exit();
    } else {
        echo "Failed to update user.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white shadow-lg rounded-lg p-8 max-w-md w-full">
        <h1 class="text-2xl font-bold mb-6 text-center text-gray-800">Edit User</h1>
        <form action="edit.php?id=<?= $id_user ?>" method="POST" class="space-y-4">
            <input type="hidden" name="id_user" value="<?= $user_data['id_user'] ?>">
            <div>
                <label class="block text-gray-700">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" value="<?= $user_data['nama_lengkap'] ?>" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div>
                <label class="block text-gray-700">NIS</label>
                <input type="text" name="nis" value="<?= $user_data['nis'] ?>" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div>
                <label class="block text-gray-700">NISN</label>
                <input type="text" name="nisn" value="<?= $user_data['nisn'] ?>" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div>
                <label class="block text-gray-700">Kelas</label>
                <input type="text" name="kelas" value="<?= $user_data['kelas'] ?>" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div>
                <label class="block text-gray-700">No Whatsapp</label>
                <input type="text" name="no_whatsapp" value="<?= $user_data['no_whatsapp'] ?>" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div>
                <label class="block text-gray-700">Password</label>
                <input type="password" name="password"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div>
                <label class="block text-gray-700">No Kartu</label>
                <input type="text" name="no_kartu" value="<?= $user_data['no_kartu'] ?>" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div>
                <label class="block text-gray-700">Roles</label>
                <select name="roles"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <option value="admin" <?= $user_data['roles'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                    <option value="petugas" <?= $user_data['roles'] == 'petugas' ? 'selected' : '' ?>>Petugas</option>
                    <option value="user" <?= $user_data['roles'] == 'user' ? 'selected' : '' ?>>User</option>
                </select>
            </div>
            <div class="text-center">
                <input type="submit" value="Update User" name="edit"
                    class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition duration-300 cursor-pointer">
            </div>
        </form>
    </div>
</body>
</html>

