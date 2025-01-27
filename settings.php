<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <style>/* General Styles */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4;
    color: #333;
}

header {
    background-color: #333;
    color: #fff;
    padding: 15px 0;
    text-align: center;
}

header h1 {
    margin: 0;
    font-size: 2em;
}

nav ul {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    background-color: #444;
}

nav ul li {
    margin: 0 10px;
}

nav ul li a {
    color: #fff;
    text-decoration: none;
    padding: 10px 15px;
    display: block;
}

nav ul li a:hover,
nav ul li a.active {
    background-color: #5cb85c;
    border-radius: 5px;
}

main {
    width: 80%;
    margin: 20px auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

h2 {
    margin-top: 0;
    color: #444;
}

form {
    margin-top: 20px;
}

.form-group {
    margin-bottom: 15px;
}

label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
}

input[type="text"],
input[type="email"],
select {
    width: 100%;
    padding: 8px;
    margin-top: 5px;
    border: 1px solid #ddd;
    border-radius: 4px;
    box-sizing: border-box;
}

input[type="submit"] {
    background-color: #5cb85c;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 4px;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: #4cae4c;
}

/* Footer */
footer {
    text-align: center;
    padding: 15px 0;
    background-color: #333;
    color: #fff;
    margin-top: 20px;
}
</style>
</head>
<body>
    <header>
        <h1>Admin Panel - Settings</h1>
        <nav>
            <ul>
                <li><a href="settings.php" class="active">Settings</a></li>
                <li><a href="manage_users.php">Manage Users</a></li>
                <li><a href="report.php">Report</a></li>
                <li><a href="manage_products.php">Manage Products</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h2>Site Settings</h2>
        <form method="POST" action="save_settings.php">
            <div class="form-group">
                <label for="site_name">Site Name:</label>
                <input type="text" id="site_name" name="site_name" placeholder="Enter site name" required>
            </div>
            <div class="form-group">
                <label for="admin_email">Admin Email:</label>
                <input type="email" id="admin_email" name="admin_email" placeholder="Enter admin email" required>
            </div>
            <div class="form-group">
                <label for="timezone">Timezone:</label>
                <select id="timezone" name="timezone" required>
                    <option value="UTC">UTC</option>
                    <option value="America/New_York">America/New_York</option>
                    <option value="Europe/London">Europe/London</option>
                    <option value="Asia/Tokyo">Asia/Tokyo</option>
                    <option value="Australia/Sydney">Australia/Sydney</option>
                </select>
            </div>
            <div class="form-group">
                <input type="submit" value="Save Settings">
            </div>
        </form>
    </main>
    <footer>
        <p>&copy; 2025 E-Commerce Admin Panel</p>
    </footer>
</body>
</html>
