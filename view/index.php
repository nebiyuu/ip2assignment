<?php
// Start the session
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="stylesheet" href="index_redirect.css"> <!-- Link to your CSS file -->
</head>
<body>

<!-- Centered Landing Page -->
<div class="container"> <!-- Change class name here to 'container' -->
    <h1>Welcome to Our Store</h1>
    <p>Please choose your role:</p>

    <!-- Form for choosing between Admin or User -->
    <form action="redirect.php" method="POST">
        <button type="submit" name="role" value="admin">Admin Login</button>
        <button type="submit" name="role" value="user">User Login</button>
    </form>
</div>

</body>
</html>
