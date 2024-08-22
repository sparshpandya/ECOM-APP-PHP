<?php
session_start();
require_once './class/Products.php';
include('db_conn.php');

$_SESSION['userInfo'] ? "Welcome {$_SESSION['userInfo']}!" : header("Location: login.php");

$products = new Products($conn);

// Save the order
require_once './class/Order.php';
$order = new Order($conn);

$userEmail = trim("{$_SESSION['userInfo']}@gmail.com") ?? null;
$userDetails = "";
if ($userEmail) {
    $userDetails = $order->showUserDetails($userEmail);
}

// If the user submits the form, process the order
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $billingAddress = "";
    if (empty($_POST['shippingAddress'])) {
        $billingAddress = $userDetails['billing_address'];
    } else {
        $billingAddress = $_POST['shippingAddress'];
    }
    $user_id = $userDetails['user_id'];
    $order_id = $order->saveOrder($user_id);

    if ($order_id) {
        // Save each product in the order
        $_SESSION['cartItems'] = [];
        foreach ($_SESSION['cart'] as $id => $item) {
            $order->saveOrderDetails($order_id, $id, $item['quantity'], $item['price'], $billingAddress);
            $_SESSION['cartItems'][] = $item; // Store cart items in session
        }

        // Store user details in session
        $_SESSION['fullName'] = $userDetails['name'];
        $_SESSION['email_id'] = $userDetails['email_id'];
        $_SESSION['billing_address'] = $billingAddress;

        // Clear the cart after successful order placement
        unset($_SESSION['cart']);

        // Redirect to a confirmation page
        header('Location: confirmation.php');
        exit();
    } else {
        // Handle the error case
        echo "There was an error processing your order.";
    }
}

$products->closeConnection();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Office Decor</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
     <?php include('navbar.php'); ?>
    <div class="container">
        <h1>Selected Products</h1>
        <hr>
        <?php if (!empty($_SESSION['cart'])): ?>
            <?php $totalAmount = 0; ?>
            <?php foreach ($_SESSION['cart'] as $id => $item): ?>
                <div class="border cart-item d-flex justify-content-between align-items-center">
                    <img src="Images/<?= $item['image'] ?>" alt="<?= $item['name'] ?>" width="100">
                    <div class="product-details pl-3">
                        <h5><?= $item['name'] ?></h5>
                        <p>$<?= number_format($item['price'], 2) ?></p>
                    </div>
                    <div class="actions">
                        <label for="quantity<?= $id ?>">Quantity:</label>
                        <input type="number" id="quantity<?= $id ?>" class="form-control" value="<?= $item['quantity'] ?>" min="1" style="width: 60px; display: inline-block;" disabled>
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
        <?php else: ?>
            <p>Your cart is empty. <a href="products.php">Continue Shopping</a></p>
        <?php endif; ?>
    </div>
    <hr>

    <!-- Confirm Your Details -->
    <div class="container confirm-details">
        <h2>Confirm Your Details</h2>
        <form method="post" action="checkout.php">
            <div class="form-group">
                <label for="fullName">Full Name</label>
                <input type="text" class="form-control" disabled value="<?php echo htmlspecialchars($userDetails['name'], ENT_QUOTES); ?>" id="firstName" placeholder="Enter First Name" required>
            </div>
            <div class="form-group">
                <label for="email">Email ID</label>
                <input type="email" class="form-control" disabled value="<?php echo htmlspecialchars($userDetails['email_id'], ENT_QUOTES); ?>" id="email" placeholder="Enter Email ID" required>
            </div>
            <div class="form-group">
                <label for="billingAddress">Billing Address</label>
                <input type="text" class="form-control" disabled value="<?php echo htmlspecialchars($userDetails['billing_address'], ENT_QUOTES); ?>" id="billingAddress" placeholder="Enter Billing Address" required>
            </div>
            <div class="form-check checkbox-container">
                <input type="checkbox" name="checkbox" class="form-check-input" id="sameAsBilling" onclick="toggleShippingAddress()">
                <label class="form-check-label" for="sameAsBilling">Billing address is shipping address</label>
            </div>
            <div class="form-group" id="shippingAddressGroup">
                <label for="shippingAddress">Shipping Address</label>
                <input type="text" class="form-control" <?php if(!isset($_POST['checkbox'])) { echo "required"; } ?> name="shippingAddress" id="shippingAddress" placeholder="Enter Shipping Address">
            </div>
            <div class="buttons row justify-content-center">
                <a href="cart.php" class="btn btn-danger m-2">Cancel</a>
                <button type="submit" class="btn btn-primary m-2">Checkout</button>
            </div>
        </form>
    </div>

    <?php include('footer.php'); ?>

    <script>
        function toggleShippingAddress() {
            const shippingGroup = document.getElementById('shippingAddressGroup');
            const shippingInput = document.getElementById('shippingAddress');
            if (document.getElementById('sameAsBilling').checked) {
                shippingGroup.style.display = 'none';
                shippingInput.value = document.getElementById('billingAddress').value;
            } else {
                shippingGroup.style.display = 'block';
                shippingInput.value = '';
            }
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
