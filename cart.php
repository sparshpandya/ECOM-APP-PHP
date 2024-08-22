<?php
require_once './class/Products.php';
include('db_conn.php');

session_start();

$_SESSION['userInfo'] ? "Welcome {$_SESSION['userInfo']}!" : header("Location: login.php");

$products = new Products($conn);

// Initialize the cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle add to cart
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $quantity = 1; // Default quantity is 1

    // Check if product is already in cart
    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['quantity'] += 1; // Increase quantity
    } else {
        // Fetch product details from database
        $product = $products->fetchProductById($id);
        if ($product) {
            $_SESSION['cart'][$id] = [
                'name' => $product['product_name'],
                'price' => $product['price'],
                'image' => $product['image_url'],
                'quantity' => $quantity
            ];
        }
    }

    header('Location: cart.php'); // Redirect to cart page
    exit();
}

// Handle removing a product from the cart
if (isset($_GET['remove'])) {
    $id = $_GET['remove'];
    unset($_SESSION['cart'][$id]);
    header('Location: cart.php');
    exit();
}

// Handle updating quantity
if (isset($_POST['update_cart'])) {
    foreach ($_POST['quantity'] as $id => $quantity) {
        if ($quantity > 0) {
            $_SESSION['cart'][$id]['quantity'] = $quantity;
        } else {
            unset($_SESSION['cart'][$id]);
        }
    }
    header('Location: cart.php');
    exit();
}

$products->closeConnection();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart - Office Decor</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- Cart Heading -->
    <?php include('navbar.php') ?>
    <hr class="hr">
    <div class="container">
        <h1 class="text-center">Your Cart</h1>
        <hr>

        <!-- Cart Form -->
        <form method="post" action="cart.php">
            <?php $totalAmount = 0; ?>
            <?php if (!empty($_SESSION['cart'])): ?>
                <?php foreach ($_SESSION['cart'] as $id => $item): ?>
                    <div class="border cart-item d-flex justify-content-between align-items-center">
                        <img src="Images/<?= $item['image'] ?>" alt="<?= $item['name'] ?>" width="100">
                        <div class="product-details m-2">
                            <h5><?= $item['name'] ?></h5>
                            <p>$<?= number_format($item['price'], 2) ?></p>
                            <a href="cart.php?remove=<?= $id ?>" class="btn btn-danger btn-sm">Remove</a>
                        </div>
                        <div class="actions">
                            <label for="quantity<?= $id ?>">Quantity:</label>
                            <input type="number" name="quantity[<?= $id ?>]" id="quantity<?= $id ?>" class="form-control" value="<?= $item['quantity'] ?>" min="1" style="width: 60px; display: inline-block;">
                        </div>
                    </div>
                    <div>
                        <?php 
                            $itemTotal = $item['quantity'] * $item['price'];
                            $totalAmount += $itemTotal;
                        ?>
                    </div>
                    <hr>
                <?php endforeach; ?>

                <div class="cart-total d-flex justify-content-end">
                    <h4>Total: $<?= number_format($totalAmount, 2) ?></h4>
                </div>

                <div class="cart-buttons d-flex justify-content-between">
                    <button type="submit" name="update_cart" class="btn btn-primary">Update Cart</button>
                    <a href="checkout.php" class="btn btn-success">Checkout</a>
                </div>
            <?php else: ?>
                <p>Your cart is empty. <a href="products.php">Continue Shopping</a></p>
            <?php endif; ?>
        </form>
    </div>

    <!-- Footer -->
    <?php include('footer.php'); ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
