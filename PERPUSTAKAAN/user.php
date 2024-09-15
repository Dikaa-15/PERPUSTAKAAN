<?php
class User {
    private $conn;
    private $table_name = "user";

    public $id_user;
    public $nama_lengkap;
    public $nis;
    public $nisn;
    public $kelas;
    public $no_whatsapp;
    public $password;
    public $no_kartu;
    public $roles;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET nama_lengkap=:nama_lengkap, nis=:nis, nisn=:nisn, kelas=:kelas, no_whatsapp=:no_whatsapp, password=:password, no_kartu=:no_kartu, roles=:roles";

        $stmt = $this->conn->prepare($query);
        
        // Clean data
        $this->nama_lengkap = htmlspecialchars(strip_tags($this->nama_lengkap));
        $this->nis = htmlspecialchars(strip_tags($this->nis));
        $this->nisn = htmlspecialchars(strip_tags($this->nisn));
        $this->kelas = htmlspecialchars(strip_tags($this->kelas));
        $this->no_whatsapp = htmlspecialchars(strip_tags($this->no_whatsapp));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->no_kartu = htmlspecialchars(strip_tags($this->no_kartu));
        $this->roles = htmlspecialchars(strip_tags($this->roles));

        // Bind data
        $stmt->bindParam(":nama_lengkap", $this->nama_lengkap);
        $stmt->bindParam(":nis", $this->nis);
        $stmt->bindParam(":nisn", $this->nisn);
        $stmt->bindParam(":kelas", $this->kelas);
        $stmt->bindParam(":no_whatsapp", $this->no_whatsapp);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":no_kartu", $this->no_kartu);
        $stmt->bindParam(":roles", $this->roles);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " SET nama_lengkap=:nama_lengkap, nis=:nis, nisn=:nisn, kelas=:kelas, no_whatsapp=:no_whatsapp, password=:password, no_kartu=:no_kartu, roles=:roles WHERE id_user=:id_user";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id_user", $this->id_user);
        $stmt->bindParam(":nama_lengkap", $this->nama_lengkap);
        $stmt->bindParam(":nis", $this->nis);
        $stmt->bindParam(":nisn", $this->nisn);
        $stmt->bindParam(":kelas", $this->kelas);
        $stmt->bindParam(":no_whatsapp", $this->no_whatsapp);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":no_kartu", $this->no_kartu);
        $stmt->bindParam(":roles", $this->roles);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_user = :id_user";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id_user", $this->id_user);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function register() {
        $query = "INSERT INTO " . $this->table_name . " 
        SET nama_lengkap=:nama_lengkap, nis=:nis, no_kartu=:no_kartu, no_whatsapp=:no_whatsapp, 
            password=:password, roles=:roles";

        $stmt = $this->conn->prepare($query);

        // Sanitasi input
        $this->nama_lengkap = htmlspecialchars(strip_tags($this->nama_lengkap));
        $this->nis = htmlspecialchars(strip_tags($this->nis));
        $this->no_kartu = htmlspecialchars(strip_tags($this->no_kartu));
        $this->no_whatsapp = htmlspecialchars(strip_tags($this->no_whatsapp));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->roles = htmlspecialchars(strip_tags($this->roles));

        // Bind data
        $stmt->bindParam(":nama_lengkap", $this->nama_lengkap);
        $stmt->bindParam(":nis", $this->nis);
        $stmt->bindParam(":no_kartu", $this->no_kartu);
        $stmt->bindParam(":no_whatsapp", $this->no_whatsapp);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":roles", $this->roles);

        if ($stmt->execute()) {
            // Set session and cookie after successful registration
            session_start();
            $_SESSION['id_user'] = $this->conn->lastInsertId();
            $_SESSION['nama_lengkap'] = $this->nama_lengkap;
            $_SESSION['roles'] = $this->roles;

            // Set a cookie for remembering the user (optional)
            setcookie("user_id", $_SESSION['id_user'], time() + (86400 * 30), "/"); // 30 days

            return true;
        }
        return false;
    }
    
    // Login User
    public function login() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE no_kartu = :no_kartu LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':no_kartu', $this->no_kartu);
        $stmt->execute();
    
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
            // Debugging data user yang ditemukan
            error_log('User found: ' . print_r($row, true));
            error_log('Password hash in DB: ' . $row['password']);
            error_log('Password entered by user: ' . $this->password);
    
            if (password_verify($this->password, $row['password'])) {
                $this->roles = $row['roles'];
                return true;
            } else {
                error_log('Password verification failed');
            }
        } else {
            error_log('No user found with no_kartu: ' . $this->no_kartu);
        }
        return false;
    }
    

    // Fungsi untuk cek role
    public function checkRole()
    {
        if ($this->roles === 'admin') {
            // Redirect ke halaman admin
            header("Location: admin_dashboard.php");
        } elseif ($this->roles === 'petugas') {
            // Redirect ke halaman petugas
            header("Location: petugas_dashboard.php");
        } elseif ($this->roles === 'user') {
            // Redirect ke halaman user
            header("Location: user_dashboard.php");
        } else {
            // Jika tidak ada role yang cocok
            header("Location: login.php?error=Role tidak ditemukan");
        }
    }
    
    
    
    
}


?>
