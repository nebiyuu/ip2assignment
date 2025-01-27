<?php
session_start();
require 'db_connection.php';  // Include your database connection

// Check if product ID is passed
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Query to get the product details from the database
    $product_query = "SELECT * FROM products WHERE id = $product_id";
    $product_result = mysqli_query($conn, $product_query);

    if (mysqli_num_rows($product_result) == 1) {
        $product = mysqli_fetch_assoc($product_result);
    } else {
        echo "Product not found.";
        exit();
    }
} else {
    echo "Invalid product ID.";
    exit();
}

// Handle adding product to favorites (if logged in)
if (isset($_POST['add_to_favorites'])) {
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $add_favorite_query = "INSERT INTO favorites (user_id, product_id) VALUES ($user_id, $product_id)";
        mysqli_query($conn, $add_favorite_query);
        echo "<script>alert('Product added to your favorites.');</script>";
    } else {
        echo "<script>alert('You need to log in to add favorites.');</script>";
    }
}

// Handle adding product to the cart (if logged in)
if (isset($_POST['add_to_cart'])) {
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $quantity = $_POST['quantity'];
        $add_to_cart_query = "INSERT INTO cart (user_id, product_id, quantity) VALUES ($user_id, $product_id, $quantity)";
        mysqli_query($conn, $add_to_cart_query);
        echo "<script>alert('Product added to your cart.');</script>";
    } else {
        echo "<script>alert('You need to log in to add items to your cart.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $product['name']; ?> - Product Details</title>
    <link rel="stylesheet" href="style.css">  <!-- Link to your CSS file -->
</head>
<body>

<div class="product-detail-container">
    <h1><?php echo $product['name']; ?></h1>

    <div class="product-detail">
        <!-- Product Image -->
        <div class="product-image">
            <img src="images/<?php echo $product['id']; ?>.jpg" alt="<?php echo $product['name']; ?>">
        </div>

        <!-- Product Info -->
        <div class="product-info">
            <p class="product-price">$<?php echo number_format($product['price'], 2); ?></p>
            <p class="product-description"><?php echo nl2br($product['description']); ?></p>

            <form action="product_detail.php?id=<?php echo $product_id; ?>" method="POST">
                <div class="product-actions">
                    <!-- Add to Cart -->
                    <div class="quantity">
                        <label for="quantity">Quantity:</label>
                        <input type="number" id="quantity" name="quantity" min="1" value="1" required>
                    </div>

                    <button type="submit" name="add_to_cart" class="btn">Add to Cart</button>
                    <button type="submit" name="add_to_favorites" class="btn">Add to Favorites</button>
                </div>
            </form>
        </div>
    </div>

    <div class="product-category">
        <p>Category: <?php echo $product['category']; ?></p>
    </div>
</div>

</body>
</html>
