<?php
session_start();
require 'db_connection.php';  // Include your database connection

// Ensure the user is logged in, otherwise redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Query to get new arrivals
$new_arrivals_query = "SELECT * FROM products WHERE is_new_arrival = 1 LIMIT 10";
$new_arrivals_result = mysqli_query($conn, $new_arrivals_query);

// Query to get products on sale
$on_sale_query = "SELECT * FROM products WHERE is_on_sale = 1 LIMIT 10";
$on_sale_result = mysqli_query($conn, $on_sale_query);

// Query to get user's favorite products
$favorites_query = "SELECT products.* FROM products 
                    JOIN favorites ON products.id = favorites.product_id 
                    WHERE favorites.user_id = $user_id";
$favorites_result = mysqli_query($conn, $favorites_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="user_dashboard_style.css">  <!-- Link to your CSS file -->
</head>
<body>

<div class="dashboard-container">
    <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>

    <!-- New Arrivals Section -->
    <div class="section">
        <h2>New Arrivals</h2>
        <div class="product-list">
            <?php if (mysqli_num_rows($new_arrivals_result) > 0): ?>
                <?php while ($product = mysqli_fetch_assoc($new_arrivals_result)): ?>
                    <div class="product-card">
                        <img src="images/<?php echo $product['id']; ?>.jpg" alt="<?php echo $product['name']; ?>">
                        <h3><?php echo $product['name']; ?></h3>
                        <p>$<?php echo number_format($product['price'], 2); ?></p>
                        <a href="product_detail.php?id=<?php echo $product['id']; ?>">View Details</a>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No new arrivals yet.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Favorites Section -->
    <div class="section">
        <h2>Your Favorites</h2>
        <div class="product-list">
            <?php if (mysqli_num_rows($favorites_result) > 0): ?>
                <?php while ($product = mysqli_fetch_assoc($favorites_result)): ?>
                    <div class="product-card">
                        <img src="images/<?php echo $product['id']; ?>.jpg" alt="<?php echo $product['name']; ?>">
                        <h3><?php echo $product['name']; ?></h3>
                        <p>$<?php echo number_format($product['price'], 2); ?></p>
                        <a href="product_detail.php?id=<?php echo $product['id']; ?>">View Details</a>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>You haven't added any favorites yet.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- On Sale Section -->
    <div class="section">
        <h2>On Sale</h2>
        <div class="product-list">
            <?php if (mysqli_num_rows($on_sale_result) > 0): ?>
                <?php while ($product = mysqli_fetch_assoc($on_sale_result)): ?>
                    <div class="product-card">
                        <img src="images/<?php echo $product['id']; ?>.jpg" alt="<?php echo $product['name']; ?>">
                        <h3><?php echo $product['name']; ?></h3>
                        <p><strike>$<?php echo number_format($product['price'], 2); ?></strike> $<?php echo number_format($product['price'] * 0.8, 2); ?></p> <!-- 20% off -->
                        <a href="product_detail.php?id=<?php echo $product['id']; ?>">View Details</a>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No products on sale at the moment.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

</body>
</html>
