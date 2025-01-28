<?php
class User
{
    private $db;
    private $id;
    private $username;
    private $email;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function login($username, $password)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                // Set session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];

                // Set object properties
                $this->id = $user['id'];
                $this->username = $user['username'];
                $this->email = $user['email'];

                return true;
            }
        }
        return false;
    }

    public function register($username, $email, $password)
    {
        // Check if username exists
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) {
            throw new Exception("Username or email already exists");
        }

        // Create new user
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $hashed_password);

        if (!$stmt->execute()) {
            throw new Exception("Error creating user account");
        }
        return true;
    }

    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();
        $this->id = null;
        $this->username = null;
        $this->email = null;
    }

    public function updateProfile($data)
    {
        if (!isset($_SESSION['user_id'])) {
            throw new Exception("User not logged in");
        }

        $allowed_fields = ['email', 'first_name', 'last_name', 'phone'];
        $updates = [];
        $types = "";
        $values = [];

        foreach ($data as $field => $value) {
            if (in_array($field, $allowed_fields)) {
                $updates[] = "$field = ?";
                $types .= "s";
                $values[] = $value;
            }
        }

        if (empty($updates)) {
            return false;
        }

        // Add user_id to values and types
        $types .= "i";
        $values[] = $_SESSION['user_id'];

        $sql = "UPDATE users SET " . implode(", ", $updates) . " WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param($types, ...$values);

        return $stmt->execute();
    }

    public function getProfile()
    {
        if (!isset($_SESSION['user_id'])) {
            throw new Exception("User not logged in");
        }

        $stmt = $this->db->prepare("SELECT id, username, email, first_name, last_name, phone FROM users WHERE id = ?");
        $stmt->bind_param("i", $_SESSION['user_id']);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function changePassword($current_password, $new_password)
    {
        if (!isset($_SESSION['user_id'])) {
            throw new Exception("User not logged in");
        }

        // Verify current password
        $stmt = $this->db->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->bind_param("i", $_SESSION['user_id']);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        if (!password_verify($current_password, $result['password'])) {
            throw new Exception("Current password is incorrect");
        }

        // Update to new password
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->bind_param("si", $hashed_password, $_SESSION['user_id']);

        return $stmt->execute();
    }

    // Getters
    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getEmail()
    {
        return $this->email;
    }
}
