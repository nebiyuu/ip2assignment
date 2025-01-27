<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'ecommerce_db');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $name = $conn->real_escape_string($_POST['product_name']);
    $description = $conn->real_escape_string($_POST['product_description']);
    $price = $conn->real_escape_string($_POST['product_price']);
    $category = $conn->real_escape_string($_POST['product_category']);
    $attributes = $conn->real_escape_string($_POST['product_attributes']);

    // Handle file upload
    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === UPLOAD_ERR_OK) {
        $image_name = basename($_FILES['product_image']['name']);
        $image_tmp_path = $_FILES['product_image']['tmp_name'];
        $upload_dir = 'uploads/';

        // Create the uploads directory if it doesn't exist
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $image_path = $upload_dir . $image_name;

        if (move_uploaded_file($image_tmp_path, $image_path)) {
            // Insert data into database
            $sql = "INSERT INTO products (name, image, description, price, category, attributes) 
                    VALUES ('$name', '$image_name', '$description', '$price', '$category', '$attributes')";

            if ($conn->query($sql) === TRUE) {
                echo "<script>alert('Product added successfully!'); window.location.href = 'manage_products.php';</script>";
            } else {
                echo "Error: " . $conn->error;
            }
        } else {
            echo "Failed to upload image.";
        }
    } else {
        echo "Please upload a valid image.";
    }
}

$conn->close();
?>
