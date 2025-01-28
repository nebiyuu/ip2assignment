<?php
class Admin
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function login($username, $password)
    {
        $sql = "SELECT * FROM admins WHERE username = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['username'] = $user['username'];
                return true;
            }
        }
        return false;
    }

    public function createAdmin($username, $password)
    {
        if (empty($username) || empty($password)) {
            throw new Exception("Username and password cannot be empty.");
        }

        // Check if username exists
        $sql = "SELECT * FROM admins WHERE username = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) {
            throw new Exception("Username already exists.");
        }

        // Create new admin
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO admins (username, password) VALUES (?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ss", $username, $hashed_password);

        if (!$stmt->execute()) {
            throw new Exception("Error creating admin account.");
        }
        return true;
    }
}
