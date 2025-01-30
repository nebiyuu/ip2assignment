<?php
session_start();
require_once('../classes/Database.php');
require_once('../classes/Admin.php');

$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    try {
        $admin = new Admin();

        if ($admin->login($username, $password)) {
            header("Location: ../ecommerce.php");
            exit;
        } else {
            $error_message = "Invalid username or password.";
        }
    } catch (Exception $e) {
        $error_message = $e->getMessage();
    }
}
