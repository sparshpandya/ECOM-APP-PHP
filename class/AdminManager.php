<?php

class AdminManager {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Products operations
    public function getAllProducts() {
        $stmt = $this->conn->prepare("SELECT * FROM products");
        $stmt->execute();
        $result = $stmt->get_result();
        $products = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $products;
    }

    public function addProduct($name, $price, $inventory, $categoryId, $image) {
        $stmt = $this->conn->prepare("INSERT INTO products (product_name, price, inventory, category_id, image_url) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param('sdiss', $name, $price, $inventory, $categoryId, $image);
        $stmt->execute();
        $stmt->close();
    }

    public function updateProduct($id, $name, $price, $inventory, $image) {
        $stmt = $this->conn->prepare("UPDATE products SET product_name=?, price=?, inventory=?, image_url=? WHERE product_id=?");
        $stmt->bind_param('sdisi', $name, $price, $inventory, $image, $id);
        $stmt->execute();
        $stmt->close();
    }

    public function deleteProduct($id) {
        $stmt = $this->conn->prepare("DELETE FROM products WHERE product_id=?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        if ($stmt->errno) {
            $error = "Error: Unable to delete this product as it is associated with another record.";
            $stmt->close();
            return $error;
        }
        $stmt->close();
        return "Product deleted successfully.";
    }

    // Category operations
    public function getAllCategories() {
        $stmt = $this->conn->prepare("SELECT * FROM category");
        $stmt->execute();
        $result = $stmt->get_result();
        $categories = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $categories;
    }

    public function addCategory($name) {
        $stmt = $this->conn->prepare("INSERT INTO category (category_name) VALUES (?)");
        $stmt->bind_param('s', $name);
        $stmt->execute();
        $stmt->close();
    }

    public function updateCategory($id, $name) {
        $stmt = $this->conn->prepare("UPDATE category SET category_name=? WHERE category_id=?");
        $stmt->bind_param('si', $name, $id);
        $stmt->execute();
        $stmt->close();
    }

    public function deleteCategory($id) {
        $stmt = $this->conn->prepare("DELETE FROM category WHERE category_id=?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        if ($stmt->errno) {
            $error = "Error: Unable to delete this category as it is associated with another record.";
            $stmt->close();
            return $error;
        }
        $stmt->close();
        return "Category deleted successfully.";
    }

    // Country operations
    public function getAllCountries() {
        $stmt = $this->conn->prepare("SELECT * FROM country");
        $stmt->execute();
        $result = $stmt->get_result();
        $countries = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $countries;
    }

    public function addCountry($name) {
        $stmt = $this->conn->prepare("INSERT INTO country (country_name) VALUES (?)");
        $stmt->bind_param('s', $name);
        $stmt->execute();
        $stmt->close();
    }

    public function updateCountry($id, $name) {
        $stmt = $this->conn->prepare("UPDATE country SET country_name=? WHERE country_id=?");
        $stmt->bind_param('si', $name, $id);
        $stmt->execute();
        $stmt->close();
    }

    public function deleteCountry($id) {
        $stmt = $this->conn->prepare("DELETE FROM country WHERE country_id=?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        if ($stmt->errno) {
            $error = "Error: Unable to delete this country as it is associated with another record.";
            $stmt->close();
            return $error;
        }
        $stmt->close();
        return "Country deleted successfully.";
    }

    // State operations
    public function getAllStates() {
        $stmt = $this->conn->prepare("SELECT * FROM state");
        $stmt->execute();
        $result = $stmt->get_result();
        $states = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $states;
    }

    public function addState($name, $countryId) {
        $stmt = $this->conn->prepare("INSERT INTO state (state_name, country_id) VALUES (?, ?)");
        $stmt->bind_param('si', $name, $countryId);
        $stmt->execute();
        $stmt->close();
    }

    public function updateState($id, $name) {
        $stmt = $this->conn->prepare("UPDATE state SET state_name=? WHERE state_id=?");
        $stmt->bind_param('sii', $name, $id);
        $stmt->execute();
        $stmt->close();
    }

    public function deleteState($id) {
        $stmt = $this->conn->prepare("DELETE FROM state WHERE state_id=?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        if ($stmt->errno) {
            $error = "Error: Unable to delete this state as it is associated with another record.";
            $stmt->close();
            return $error;
        }
        $stmt->close();
        return "State deleted successfully.";
    }
}
?>
