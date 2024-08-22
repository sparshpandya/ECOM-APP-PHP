<?php
session_start();
require_once './class/Products.php';
include('db_conn.php');

// Create Products object
$products = new Products($conn);

// Handle adding a product to the cart
if (isset($_GET['action']) && $_GET['action'] == 'add') {
    $productId = intval($_GET['id']);
    
    // Fetch the product details based on the product ID
    $product = $products->fetchProductById($productId);

    if ($product) {
        // Check if the cart session exists
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // If the product is already in the cart, increase the quantity
        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId]['quantity']++;
        } else {
            // Otherwise, add the new product to the cart
            $_SESSION['cart'][$productId] = [
                'name' => $product['product_name'],
                'price' => $product['price'],
                'quantity' => 1,
                'image' => $product['image_url']
            ];
        }

        // Redirect to checkout page
        header('Location: checkout.php');
        exit();
    }
}

// Fetch all products
$allProducts = $products->fetchAllProducts();

// Close the database connection
$products->closeConnection();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Awesome SmartShop</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include('navbar.php') ?>
    <hr class="hr">

    <div class="container welcome-message">
        <h1>Welcome to Awesome SmartShop <?php echo $_SESSION['userInfo'] ? "Welcome {$_SESSION['userInfo']}!" : header("Location: login.php") ?></h1>
        <p>Your one-stop shop for the best watches.</p>
    </div>

    <div class="container best-sellers">
        <h2 class="text-center">Best Sellers</h2>
        <div class="row">
            <?php
            for ($i = 0; $i < 3 && $i < count($allProducts); $i++) {
                echo '<div class="col-md-4">';
                echo '<div class="card">';
                echo '<img src="Images/' . $allProducts[$i]['image_url'] . '" class="card-img-top" alt="' . $allProducts[$i]['product_name'] . '">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">' . $allProducts[$i]['product_name'] . '</h5>';
                echo '<p class="card-text">$' . number_format($allProducts[$i]['price'], 2) . '</p>';
                echo '<a href="index.php?action=add&id=' . $allProducts[$i]['product_id'] . '" class="btn btn-primary">Buy Now</a>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
            ?>
        </div>
    </div>

    <!-- Footer -->
    <?php include('footer.php'); ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
