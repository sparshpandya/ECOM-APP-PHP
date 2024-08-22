<?php
require_once './class/Products.php';
include('db_conn.php');
session_start();
$_SESSION['userInfo'] ? "Welcome {$_SESSION['userInfo']}!" : header("Location: login.php");

// Fetch all categories for the dropdown
$products = new Products($conn);
$categories = $products->fetchAllCategories();
$products->closeConnection();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Watches - Awesome SmartShop</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include('navbar.php') ?>
    <hr class="hr">
        
    <div class="container">
        <h1>Our Collection</h1>
        <h2>Category Products</h2>
        <div class="form-group">
            <label for="categoryFilter">Filter by:</label>
            <select class="form-control" id="categoryFilter" onchange="filterCategory()">
                <option value="">All Categories</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['category_id'] ?>">
                        <?= $category['category_name'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="container best-sellers">
        <div class="row" id="productContainer">
        </div>
    </div>

    <?php include('footer.php'); ?>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function filterCategory() {
            var categoryId = document.getElementById('categoryFilter').value;
            $.ajax({
                url: 'filter_products.php',
                method: 'GET',
                data: { category: categoryId },
                dataType: 'json',
                success: function(response) {
                    var productContainer = $('#productContainer');
                    productContainer.empty();

                    if (response.length > 0) {
                        response.forEach(function(product) {
                            var productHtml = `
                                <div class="col-md-4">
                                    <div class="card">
                                        <img src="Images/${product.image_url}" class="card-img-top" alt="${product.product_name}">
                                        <div class="card-body">
                                            <h5 class="card-title">${product.product_name}</h5>
                                            <p class="card-text">$${parseFloat(product.price).toFixed(2)}</p>
                                            <a href="cart.php?id=${product.product_id}" class="btn btn-primary">Add to Cart</a>
                                        </div>
                                    </div>
                                </div>
                            `;
                            productContainer.append(productHtml);
                        });
                    } else {
                        productContainer.append('<p>No products found in this category.</p>');
                    }
                },
                error: function() {
                    alert('Failed to fetch products.');
                }
            });
        }

        $(document).ready(function() {
            filterCategory();
        });
    </script>
</body>
</html>
