<?php
session_start();
require 'db_connection.php';  // Make sure to adjust the path to your database connection script

$error_message = '';  // Variable to store error message if login fails

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Query to get the user from the database
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // Verify the password using password_verify()
        if (password_verify($password, $user['password'])) {
            // Store user info in session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            // Redirect to the user dashboard or a protected page
            header("Location: home.php");
            exit();
        } else {
            $error_message = 'Invalid password!';
        }
    } else {
        $error_message = 'User not found!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <link rel="stylesheet" href="login.css">  <!-- Link to your CSS file -->
</head>
<body>

<div class="login-container">
    <h2>User Login</h2>

    <!-- Display error message if any -->
    <?php if ($error_message): ?>
        <div class="error-message"><?php echo $error_message; ?></div>
    <?php endif; ?>

    <!-- Login Form -->
    <form method="POST" action="userlogin.php">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
        </div>

        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>

        <input type="submit" value="Login">
    </form>

    <p>Don't have an account? <a href="usersignup.php">Sign up here</a></p>
</div>

</body>
</html>
