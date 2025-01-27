<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
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

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

table, th, td {
    border: 1px solid #ddd;
}

th, td {
    padding: 12px;
    text-align: left;
}

th {
    background-color: #f2f2f2;
}

tr:nth-child(even) {
    background-color: #f9f9f9;
}

a {
    color: #007bff;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
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
        <h1>Admin Panel - Manage Users</h1>
        <nav>
            <ul>
                <li><a href="settings.php">Settings</a></li>
                <li><a href="manage_users.php" class="active">Manage Users</a></li>
                <li><a href="report.php">Report</a></li>
                <li><a href="manage_products.php">Manage Products</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h2>User Management</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Database connection
                $conn = new mysqli('localhost', 'root', '', 'ecommerce_db');

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Fetch users
                $sql = "SELECT * FROM users";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['username'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "<td>
                                <a href='edit_user.php?id=" . $row['id'] . "'>Edit</a> |
                                <a href='delete_user.php?id=" . $row['id'] . "' onclick='return confirm(\"Are you sure?\");'>Delete</a>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No users found.</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </main>
    <footer>
        <p>&copy; 2025 E-Commerce Admin Panel</p>
    </footer>
</body>
</html>
