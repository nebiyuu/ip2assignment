<?php
session_start();
require_once('classes/Database.php');
require_once('classes/Product.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Initialize Product class
$productObj = new Product();

// Fetch products
$new_arrivals_result = $productObj->getNewArrivals();
$on_sale_result = $productObj->getOnSaleProducts();
$categories_result = $productObj->getCategories();

// Fetch products for each category
$category_products = [];
while ($category = $categories_result->fetch_assoc()) {
    $category_name = $category['category'];
    $category_products[$category_name] = $productObj->getProductsByCategory($category_name);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Our Store</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 15px;
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        h1 {
            font-size: 24px;
        }

        nav a {
            color: #fff;
            margin-left: 15px;
            text-decoration: none;
        }

        nav a:hover {
            text-decoration: underline;
        }

        .main-content {
            max-width: 1200px;
            margin: 0 auto;
        }

        h2 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        .product-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }

        .product-card {
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .product-card img {
            width: 100%;
            height: auto;
            border-radius: 8px;
        }

        .product-card h3 {
            font-size: 18px;
            margin: 10px 0;
        }

        .product-card p {
            font-size: 16px;
            margin-bottom: 10px;
        }

        .product-card button {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin: 5px;
        }

        .product-card button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>

    <!-- Header Section (Can include navigation and user info) -->
    <header>
        <div class="header-container">
            <h1>Welcome to Our Store, <?php echo htmlspecialchars($_SESSION['username']); ?></h1>
            <nav>
                <a href="userlogin.php">Logout</a>
                <a href="cart.php">Cart</a>
                <a href="favorites.php">Favorites</a>
            </nav>
        </div>
    </header>

    <!-- Main Content: Products List -->
    <div class="main-content">
        <h2>New Arrivals</h2>
        <div class="product-list">
            <?php if ($new_arrivals_result->num_rows > 0): ?>
                <?php while ($product = $new_arrivals_result->fetch_assoc()): ?>
                    <div class="product-card">
                        <img src="images/<?php echo htmlspecialchars($product['id']); ?>.jpg"
                            alt="<?php echo htmlspecialchars($product['name']); ?>">
                        <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                        <p>$<?php echo $productObj->formatPrice($product['price']); ?></p>
                        <a href="product_detail.php?id=<?php echo htmlspecialchars($product['id']); ?>">View Details</a>
                        <form action="add_to_cart.php" method="POST">
                            <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['id']); ?>">
                            <button type="submit">Add to Cart</button>
                        </form>
                        <form action="add_to_favorites.php" method="POST">
                            <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['id']); ?>">
                            <button type="submit">Add to Favorites</button>
                        </form>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No new arrivals available.</p>
            <?php endif; ?>
        </div>

        <h2>On Sale Products</h2>
        <div class="product-list">
            <?php if ($on_sale_result->num_rows > 0): ?>
                <?php while ($product = $on_sale_result->fetch_assoc()): ?>
                    <div class="product-card">
                        <img src="images/<?php echo htmlspecialchars($product['id']); ?>.jpg"
                            alt="<?php echo htmlspecialchars($product['name']); ?>">
                        <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                        <p><strike>$<?php echo $productObj->formatPrice($product['price']); ?></strike>
                            $<?php echo $productObj->formatPrice($product['price'], true); ?></p>
                        <a href="product_detail.php?id=<?php echo htmlspecialchars($product['id']); ?>">View Details</a>
                        <form action="add_to_cart.php" method="POST">
                            <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['id']); ?>">
                            <button type="submit">Add to Cart</button>
                        </form>
                        <form action="add_to_favorites.php" method="POST">
                            <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['id']); ?>">
                            <button type="submit">Add to Favorites</button>
                        </form>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No products on sale.</p>
            <?php endif; ?>
        </div>

        <!-- Loop through product categories -->
        <?php foreach ($category_products as $category_name => $category_result): ?>
            <h2><?php echo htmlspecialchars($category_name); ?> Products</h2>
            <div class="product-list">
                <?php if ($category_result->num_rows > 0): ?>
                    <?php while ($product = $category_result->fetch_assoc()): ?>
                        <div class="product-card">
                            <img src="images/<?php echo htmlspecialchars($product['id']); ?>.jpg"
                                alt="<?php echo htmlspecialchars($product['name']); ?>">
                            <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                            <p>$<?php echo $productObj->formatPrice($product['price']); ?></p>
                            <a href="product_detail.php?id=<?php echo htmlspecialchars($product['id']); ?>">View Details</a>
                            <form action="add_to_cart.php" method="POST">
                                <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['id']); ?>">
                                <button type="submit">Add to Cart</button>
                            </form>
                            <form action="add_to_favorites.php" method="POST">
                                <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['id']); ?>">
                                <button type="submit">Add to Favorites</button>
                            </form>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>No products available in this category.</p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>

</body>

</html>