<?php
session_start();
require_once('classes/Database.php');
require_once('classes/User.php');

$error_message = '';

// Check if the form was submitted via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Create new User object
        $user = new User();

        // Attempt to log in with submitted username and password
        if ($user->login($_POST['username'], $_POST['password'])) {
            // If login successful, redirect to home page
            header("Location: view\home.php");
            exit();
        } else {
            // If login failed, set error message
            $error_message = "Invalid username or password";
        }
    } catch (Exception $e) {
        // Catch and display any exceptions that occur
        $error_message = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <link rel="stylesheet" href="login.css"> <!-- Link to your CSS file -->
</head>

<body>

    <div class="login-container">
        <h2>User Login</h2>

        <!-- Display error message if any -->
        <?php if ($error_message): ?>
            <div class="error-message"><?php echo htmlspecialchars($error_message); ?></div>
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