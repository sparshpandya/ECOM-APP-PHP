<?php
include('db_conn.php');
include('./class/AdminManager.php');
session_start();

// Ensure the user is an admin
if (!isset($_SESSION['userInfo']) || $_SESSION['userInfo'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// Create an instance of AdminManager
$adminManager = new AdminManager($conn);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];
    $result = "";
    $error = "";

    // Handle Product operations
    if ($action == 'addProduct') {
        $name = $_POST['productName'];
        $price = $_POST['price'];
        $inventory = $_POST['inventory'];
        $categoryId = $_POST['categoryId'];
        $imagefile = $_POST['imagefile'];

        $adminManager->addProduct($name, $price, $inventory, $categoryId, $imagefile);
        $result = "Product added successfully.";

    } elseif ($action == 'updateProduct') {
        $id = $_POST['productId'];
        $name = $_POST['productName'];
        $price = $_POST['price'];
        $inventory = $_POST['inventory'];
        $imagefile = $_POST['imagefile'];

        $adminManager->updateProduct($id, $name, $price, $inventory, $imagefile);
        $result = "Product updated successfully.";

    } elseif ($action == 'deleteProduct') {
        $id = $_POST['productId'];
        $result = $adminManager->deleteProduct($id);
        if($result === "Error: Unable to delete this product as it is associated with another record.") {
        $error = "Unable to delete this product as it is associated with another record.";
        }
    }

    // Handle Category operations
    elseif ($action == 'addCategory') {
        $name = $_POST['categoryName'];
        $adminManager->addCategory($name);
        $result = "Category added successfully.";

    } elseif ($action == 'updateCategory') {
        $id = $_POST['categoryId'];
        $name = $_POST['categoryName'];
        $adminManager->updateCategory($id, $name);
        $result = "Category updated successfully.";

    } elseif ($action == 'deleteCategory') {
        $id = $_POST['categoryId'];
        $result = $adminManager->deleteCategory($id);
        if($result === "Error: Unable to delete this category as it is associated with another record.") {
            $error = "Unable to delete this category as it is associated with another record.";
        }
        
    }

    // Handle Country operations
    elseif ($action == 'addCountry') {
        $name = $_POST['countryName'];
        $adminManager->addCountry($name);
        $result = "Country added successfully.";

    } elseif ($action == 'updateCountry') {
        $id = $_POST['countryId'];
        $name = $_POST['countryName'];
        $adminManager->updateCountry($id, $name);
        $result = "Country updated successfully.";

    } elseif ($action == 'deleteCountry') {
        $id = $_POST['countryId'];
        $result = $adminManager->deleteCountry($id);
        if($result === "Error: Unable to delete this country as it is associated with another record.") {
            $error = "Unable to delete this country as it is associated with another record.";
        }
    }

    // Handle State operations
    elseif ($action == 'addState') {
        $name = $_POST['stateName'];
        $countryId = $_POST['countryId'];
        $adminManager->addState($name, $countryId);
        $result = "State added successfully.";

    } elseif ($action == 'updateState') {
        $id = $_POST['stateId'];
        $name = $_POST['stateName'];
        $adminManager->updateState($id, $name);
        $result = "State updated successfully.";

    } elseif ($action == 'deleteState') {
        $id = $_POST['stateId'];
        $result = $adminManager->deleteState($id);
        if($result === "Error: Unable to delete this state as it is associated with another record.") {
            $error = "Unable to delete this state as it is associated with another record.";
        }
    }

    // Store the result message in the session and redirect back to the admin page
    $_SESSION['result'] = $result;
    $_SESSION['error'] = $error;
    header("Location: admin.php");
    exit();
} else {
    // Redirect back to the admin page if the request method is not POST
    header("Location: admin.php");
    exit();
}
