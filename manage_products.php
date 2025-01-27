<?php
// Database connection details
$servername = "localhost";
$username = "root";  // change this according to your setup
$password = "";  // change this according to your setup
$dbname = "ecommerce_db"; // replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle add, update, and delete operations
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add'])) {
        $name = $_POST['name'];
        $price = $_POST['price'];
        $description = $_POST['description'];
        $is_new_arrival = isset($_POST['is_new_arrival']) ? 1 : 0;
        $is_on_sale = isset($_POST['is_on_sale']) ? 1 : 0;

        $sql = "INSERT INTO products (name, price, description, is_new_arrival, is_on_sale) 
                VALUES ('$name', '$price', '$description', '$is_new_arrival', '$is_on_sale')";

        if ($conn->query($sql) === TRUE) {
            echo "<div class='message success'>New product added successfully.</div>";
        } else {
            echo "<div class='message error'>Error: " . $sql . "<br>" . $conn->error . "</div>";
        }
    }

    if (isset($_POST['update'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $price = $_POST['price'];
        $description = $_POST['description'];
        $is_new_arrival = isset($_POST['is_new_arrival']) ? 1 : 0;
        $is_on_sale = isset($_POST['is_on_sale']) ? 1 : 0;

        $sql = "UPDATE products 
                SET name='$name', price='$price', description='$description', 
                    is_new_arrival='$is_new_arrival', is_on_sale='$is_on_sale' 
                WHERE id=$id";

        if ($conn->query($sql) === TRUE) {
            echo "<div class='message success'>Product updated successfully.</div>";
        } else {
            echo "<div class='message error'>Error: " . $sql . "<br>" . $conn->error . "</div>";
        }
    }

    if (isset($_POST['delete'])) {
        $id = $_POST['id'];

        $sql = "DELETE FROM products WHERE id=$id";

        if ($conn->query($sql) === TRUE) {
            echo "<div class='message success'>Product deleted successfully.</div>";
        } else {
            echo "<div class='message error'>Error: " . $sql . "<br>" . $conn->error . "</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products</title>
    <style>
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

        h1 {
            margin: 0;
            font-size: 2em;
        }

        .container {
            width: 80%;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
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
        textarea,
        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
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

        input[type="checkbox"] {
            margin-right: 10px;
        }

        .message {
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            font-weight: bold;
        }

        .success {
            background-color: #dff0d8;
            color: #3c763d;
        }

        .error {
            background-color: #f2dede;
            color: #a94442;
        }

        .navigation-buttons {
            margin-top: 20px;
            text-align: center;
        }

        .navigation-buttons a {
            display: inline-block;
            margin: 5px;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
        }

        .navigation-buttons a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<header>
    <h1>Manage Products</h1>
</header>

<div class="container">

    <!-- Add Product Form -->
    <h2>Add New Product</h2>
    <form method="POST">
        <div class="form-group">
            <label for="name">Product Name:</label>
            <input type="text" id="name" name="name" required>
        </div>

        <div class="form-group">
            <label for="price">Price:</label>
            <input type="text" id="price" name="price" required>
        </div>

        <div class="form-group">
            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea>
        </div>

        <div class="form-group">
            <label>
                <input type="checkbox" name="is_new_arrival"> Mark as New Arrival
            </label>
        </div>

        <div class="form-group">
            <label>
                <input type="checkbox" name="is_on_sale"> Mark as On Sale
            </label>
        </div>

        <input type="submit" name="add" value="Add Product">
    </form>

    <!-- Update/Delete Product Form -->
    <h2>Update or Delete Product</h2>
    <form method="POST">
        <div class="form-group">
            <label for="id">Product ID:</label>
            <input type="text" id="id" name="id" required>
        </div>

        <div class="form-group">
            <label for="name">New Name:</label>
            <input type="text" id="name" name="name">
        </div>

        <div class="form-group">
            <label for="price">New Price:</label>
            <input type="text" id="price" name="price">
        </div>

        <div class="form-group">
            <label for="description">New Description:</label>
            <textarea id="description" name="description"></textarea>
        </div>

        <div class="form-group">
            <label>
                <input type="checkbox" name="is_new_arrival"> Mark as New Arrival
            </label>
        </div>

        <div class="form-group">
            <label>
                <input type="checkbox" name="is_on_sale"> Mark as On Sale
            </label>
        </div>

        <input type="submit" name="update" value="Update Product">
        <input type="submit" name="delete" value="Delete Product">
    </form>

    <!-- Navigation Buttons -->
    <div class="navigation-buttons">
        <a href="ecommerce.php">Back</a>
        <a href="ecommerce.php">View Existing Products</a>
    </div>
</div>

</body>
</html>

<?php
$conn->close();
?>
