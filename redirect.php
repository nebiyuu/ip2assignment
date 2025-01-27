<?php
// Start session
session_start();

// Check if the form is submitted and the role is set
if (isset($_POST['role'])) {
    $role = $_POST['role'];
    
    // Redirect based on the selected role
    if ($role == 'admin') {
        header("Location: login.php");  // Redirect to admin login page
        exit();
    } elseif ($role == 'user') {
        header("Location: userlogin.php");  // Redirect to user login page
        exit();
    } else {
        // If no valid role is selected, redirect to the landing page
        header("Location: index.php");
        exit();
    }
} else {
    // If form is not submitted, redirect to the landing page
    header("Location: index.php");
    exit();
}
?>
