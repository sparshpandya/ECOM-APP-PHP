<?php
require_once './class/Products.php';
include('db_conn.php');

// Create Furniture object
$furniture = new Products($conn);

// Get the category filter if set
$category_id = isset($_GET['category']) ? intval($_GET['category']) : null;

// Fetch the furniture based on category filter
if ($category_id) {
    // showing the products based on category
    $furnitureList = $furniture->fetchProductsByCategory($category_id);
} else {
    // showing all products
    $furnitureList = $furniture->fetchAllProducts();
}

// Close the database connection
$furniture->closeConnection();

// Return the data as JSON
header('Content-Type: application/json');
echo json_encode($furnitureList);
?>
