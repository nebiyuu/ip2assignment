<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Admin Panel</h1>
        <nav>
            <ul>
                <li><a href="settings.php">Settings</a></li>
                <li><a href="manage_users.php">Manage Users</a></li>
                <li><a href="report.php">Report</a></li>
                <li><a href="manage_products.php">Manage Products</a></li>
                <li><a href="index.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h2>Existing Products</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>Attributes</th>
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

                // Fetch products
                $sql = "SELECT * FROM products";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['name'] . "</td>";
                        echo "<td><img src='uploads/" . $row['image'] . "' alt='" . $row['name'] . "' width='50'></td>";
                        echo "<td>" . $row['description'] . "</td>";
                        echo "<td>" . $row['price'] . "</td>";
                        echo "<td>" . $row['category'] . "</td>";
                        echo "<td>" . $row['attributes'] . "</td>";
                        echo "<td>
                                <a href='edit_product.php?id=" . $row['id'] . "'>Edit</a> |
                                <a href='delete_product.php?id=" . $row['id'] . "' onclick='return confirm(\"Are you sure?\");'>Delete</a>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No products found.</td></tr>";
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
