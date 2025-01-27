<?php
require 'dbconnection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = $conn->prepare("SELECT * FROM users WHERE username = :username");
    $query->bindParam(':username', $username);
    $query->execute();

    $user = $query->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        echo "Login successful! Welcome, " . htmlspecialchars($username) . ".";
    } else {
        echo "Invalid username or password.";
    }
}
?>
