<?php
require_once './Database.php';
require_once './user.php';

class UserController {
    private $user;

    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        $this->user = new User($db);
    }

    public function getAllUsers() {
        $stmt = $this->user->read();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createUser($data) {
        $this->user->nama_lengkap = $data['nama_lengkap'];
        $this->user->nis = $data['nis'];
        $this->user->nisn = $data['nisn'];
        $this->user->kelas = $data['kelas'];
        $this->user->no_whatsapp = $data['no_whatsapp'];
        $this->user->password = password_hash($data['password'], PASSWORD_BCRYPT);
        $this->user->no_kartu = $data['no_kartu'];
        $this->user->roles = $data['roles'];

        if ($this->user->create()) {
            return "User created successfully.";
        } else {
            return "Failed to create user.";
        }
    }

    public function updateUser($data) {
        $this->user->id_user = $data['id_user'];
        $this->user->nama_lengkap = $data['nama_lengkap'];
        $this->user->nis = $data['nis'];
        $this->user->nisn = $data['nisn'];
        $this->user->kelas = $data['kelas'];
        $this->user->no_whatsapp = $data['no_whatsapp'];
        $this->user->password = password_hash($data['password'], PASSWORD_BCRYPT);
        $this->user->no_kartu = $data['no_kartu'];
        $this->user->roles = $data['roles'];

        if ($this->user->update()) {
            return "User updated successfully.";
        } else {
            return "Failed to update user.";
        }
    }

    public function deleteUser($id) {
        $this->user->id_user = $id;
        if ($this->user->delete()) {
            return "User deleted successfully.";
        } else {
            return "Failed to delete user.";
        }
    }

}
?>
