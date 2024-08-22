<?php
session_start();
include('db_conn.php');
include('./class/AdminManager.php');

// Ensure the user is an admin
if (!isset($_SESSION['userInfo']) || $_SESSION['userInfo'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// Create an instance of AdminManager
$adminManager = new AdminManager($conn);

// Fetch all data to display in the admin panel
$productItems = $adminManager->getAllProducts();
$categories = $adminManager->getAllCategories();
$countries = $adminManager->getAllCountries();
$states = $adminManager->getAllStates();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container {
            margin-top: 50px;
        }

        .table {
            margin-top: 20px;
        }

        .modal-header {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>

<body>
<?php include('navbar.php'); ?>
<hr class="hr">
    <div class="container">
        <h2 class="text-center">Admin Page</h2>
        <h3 class="text-center text-primary"><?php echo "Welcome {$_SESSION['userInfo']}!"; ?></h3>
        <?php $error = $_SESSION['error'] ?? null; if($error !== "") {
            echo "<h4 class='text-center alert alert-danger'>{$error}</h4>";
        } ?>
        <!-- Product Management -->
        <h3>Product Management</h3>
        <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addProductModal">Add Product</button>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Inventory</th>
                    <th>Category ID</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productItems as $item): ?>
                <tr>
                    <td><?= $item['product_id'] ?></td>
                    <td><?= $item['product_name'] ?></td>
                    <td>$<?= number_format($item['price'], 2) ?></td>
                    <td><?= $item['inventory'] ?></td>
                    <td><?= $item['category_id'] ?></td>
                    <td>
                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#updateProductModal<?= $item['product_id'] ?>">Update</button>
                        <form action="admin_actions.php" method="post" style="display:inline;">
                            <input type="hidden" name="action" value="deleteProduct">
                            <input type="hidden" name="productId" value="<?= $item['product_id'] ?>">
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this item?')">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Category Management -->
        <h3>Category Management</h3>
        <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addCategoryModal">Add Category</button>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Category Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $category): ?>
                <tr>
                    <td><?= $category['category_id'] ?></td>
                    <td><?= $category['category_name'] ?></td>
                    <td>
                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#updateCategoryModal<?= $category['category_id'] ?>">Update</button>
                        <form action="admin_actions.php" method="post" style="display:inline;">
                            <input type="hidden" name="action" value="deleteCategory">
                            <input type="hidden" name="categoryId" value="<?= $category['category_id'] ?>">
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this category?')">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Country Management -->
        <h3>Country Management</h3>
        <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addCountryModal">Add Country</button>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Country Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($countries as $country): ?>
                <tr>
                    <td><?= $country['country_id'] ?></td>
                    <td><?= $country['country_name'] ?></td>
                    <td>
                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#updateCountryModal<?= $country['country_id'] ?>">Update</button>
                        <form action="admin_actions.php" method="post" style="display:inline;">
                            <input type="hidden" name="action" value="deleteCountry">
                            <input type="hidden" name="countryId" value="<?= $country['country_id'] ?>">
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this country?')">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- State Management -->
        <h3>State Management</h3>
        <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addStateModal">Add State</button>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>State Name</th>
                    <th>Country ID</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($states as $state): ?>
                <tr>
                    <td><?= $state['state_id'] ?></td>
                    <td><?= $state['state_name'] ?></td>
                    <td><?= $state['country_id'] ?></td>
                    <td>
                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#updateStateModal<?= $state['state_id'] ?>">Update</button>
                        <form action="admin_actions.php" method="post" style="display:inline;">
                            <input type="hidden" name="action" value="deleteState">
                            <input type="hidden" name="stateId" value="<?= $state['state_id'] ?>">
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this state?')">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Product Modals -->
    <?php foreach ($productItems as $item): ?>
    <div class="modal fade" id="updateProductModal<?= $item['product_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="updateProductModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateProductModalLabel">Update Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="admin_actions.php" method="post">
                        <input type="hidden" name="action" value="updateProduct">
                        <input type="hidden" name="productId" value="<?= $item['product_id'] ?>">
                        <div class="form-group">
                            <label for="productName">Product Name</label>
                            <input type="text" class="form-control" name="productName" value="<?= $item['product_name'] ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="number" class="form-control" name="price" step="0.01" value="<?= $item['price'] ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="inventory">Inventory</label>
                            <input type="number" class="form-control" name="inventory" value="<?= $item['inventory'] ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="imagefile">Image</label>
                            <input type="text" class="form-control" name="imagefile" value="<?= $item['image_url'] ?>" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Product</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>

    <!-- Add Product Modal -->
    <div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="addProductModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProductModalLabel">Add Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="admin_actions.php" method="post">
                        <input type="hidden" name="action" value="addProduct">
                        <div class="form-group">
                            <label for="productName">Product Name</label>
                            <input type="text" class="form-control" name="productName" placeholder="Enter product name" required>
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="number" class="form-control" name="price" step="0.01" placeholder="Enter price" required>
                        </div>
                        <div class="form-group">
                            <label for="inventory">Inventory</label>
                            <input type="number" class="form-control" name="inventory" placeholder="Enter inventory quantity" required>
                        </div>
                        <div class="form-group">
                            <label for="categoryId">Category ID</label>
                            <input type="number" class="form-control" max="4" min="1" name="categoryId" placeholder="Enter category ID" required>
                        </div>
                        <div class="form-group">
                            <label for="imagefile">imagefile</label>
                            <input type="text" class="form-control" name="imagefile" placeholder="Enter imagefile filename" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Product</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Category Modals -->
    <?php foreach ($categories as $category): ?>
    <div class="modal fade" id="updateCategoryModal<?= $category['category_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="updateCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateCategoryModalLabel">Update Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="admin_actions.php" method="post">
                        <input type="hidden" name="action" value="updateCategory">
                        <input type="hidden" name="categoryId" value="<?= $category['category_id'] ?>">
                        <div class="form-group">
                            <label for="categoryName">Category Name</label>
                            <input type="text" class="form-control" name="categoryName" value="<?= $category['category_name'] ?>" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Category</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>

    <!-- Add Category Modal -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryModalLabel">Add Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="admin_actions.php" method="post">
                        <input type="hidden" name="action" value="addCategory">
                        <div class="form-group">
                            <label for="categoryName">Category Name</label>
                            <input type="text" class="form-control" name="categoryName" placeholder="Enter category name" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Category</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Country Modals -->
    <?php foreach ($countries as $country): ?>
    <div class="modal fade" id="updateCountryModal<?= $country['country_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="updateCountryModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateCountryModalLabel">Update Country</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="admin_actions.php" method="post">
                        <input type="hidden" name="action" value="updateCountry">
                        <input type="hidden" name="countryId" value="<?= $country['country_id'] ?>">
                        <div class="form-group">
                            <label for="countryName">Country Name</label>
                            <input type="text" class="form-control" name="countryName" value="<?= $country['country_name'] ?>" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Country</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>

    <!-- Add Country Modal -->
    <div class="modal fade" id="addCountryModal" tabindex="-1" role="dialog" aria-labelledby="addCountryModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCountryModalLabel">Add Country</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="admin_actions.php" method="post">
                        <input type="hidden" name="action" value="addCountry">
                        <div class="form-group">
                            <label for="countryName">Country Name</label>
                            <input type="text" class="form-control" name="countryName" placeholder="Enter country name" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Country</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- State Modals -->
    <?php foreach ($states as $state): ?>
    <div class="modal fade" id="updateStateModal<?= $state['state_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="updateStateModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateStateModalLabel">Update State</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="admin_actions.php" method="post">
                        <input type="hidden" name="action" value="updateState">
                        <input type="hidden" name="stateId" value="<?= $state['state_id'] ?>">
                        <div class="form-group">
                            <label for="stateName">State Name</label>
                            <input type="text" class="form-control" name="stateName" value="<?= $state['state_name'] ?>" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Update State</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>

    <!-- Add State Modal -->
    <div class="modal fade" id="addStateModal" tabindex="-1" role="dialog" aria-labelledby="addStateModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addStateModalLabel">Add State</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="admin_actions.php" method="post">
                        <input type="hidden" name="action" value="addState">
                        <div class="form-group">
                            <label for="stateName">State Name</label>
                            <input type="text" class="form-control" name="stateName" placeholder="Enter state name" required>
                        </div>
                        <div class="form-group">
                            <label for="countryId">Country ID</label>
                            <input type="number" class="form-control" max="3" min="1" name="countryId" placeholder="Enter country ID" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add State</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include('footer.php'); ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
