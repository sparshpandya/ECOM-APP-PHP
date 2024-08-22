<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Values - Awesome Smartshop</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php 
    session_start();
    $_SESSION['userInfo'] ? "Welcome {$_SESSION['userInfo']}!" : header("Location: login.php");
    include('navbar.php');
?>
    <hr>

    
    <div class="container values-section">
        <h1 class="text-center">Our Values</h1>
        <hr>
        <main>
            <p>At Awesome Smartshop, we believe that a great timepiece does more than tell time; it tells a story. Our values are at the core of everything we do, guiding us to deliver the best products and services to our customers.</p>

            <h3>Craftsmanship</h3>
            <p>We are committed to offering high-quality watches that combine precision with artistry. Each piece is crafted with care, ensuring that it meets the highest standards of durability and elegance.</p>

            <h3>Innovation</h3>
            <p>Innovation drives us forward. We continuously explore new designs and technologies to bring you the latest trends and the most innovative timepieces available.</p>

            <h3>Customer Satisfaction</h3>
            <p>Your satisfaction is our priority. We strive to offer exceptional customer service, from the moment you explore our collection to the moment you receive your watch.</p>

            <h3>Sustainability</h3>
            <p>We are dedicated to sustainability. Our eco-friendly practices ensure that our watches are produced with the environment in mind, using sustainable materials wherever possible.</p>

            <h3>Integrity</h3>
            <p>Integrity is the foundation of our business. We conduct ourselves with honesty and transparency, building trust with our customers, partners, and employees.</p>

            <h3>Community</h3>
            <p>We believe in giving back to the community. We support local initiatives and charities, working together to make a positive impact in the places we live and work.</p>

            <p>Thank you for choosing Awesome Smartshop. We look forward to helping you find a watch that complements your style and meets your needs.</p>
        </main>
    </div>
    <hr>

    
    <?php include('footer.php'); ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
