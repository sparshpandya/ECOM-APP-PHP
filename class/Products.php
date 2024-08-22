<?php
class Products
{
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function fetchAllProducts()
    {
        $sql = "SELECT * FROM products";
        $result = $this->conn->query($sql);

        if ($result === false) {
            die("Error executing query: " . $this->conn->error);
        }

        $productsArray = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $productsArray[] = $row;
            }
        }

        return $productsArray;
    }

    public function fetchProductsByCategory($category_id)
    {
        $sql = "SELECT * FROM products WHERE category_id = ?";
        $stmt = $this->conn->prepare($sql);
        
        if ($stmt === false) {
            die("Error preparing statement: " . $this->conn->error);
        }
        
        $stmt->bind_param("i", $category_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result === false) {
            die("Error executing query: " . $stmt->error);
        }

        $productsArray = [];

        while ($row = $result->fetch_assoc()) {
            $productsArray[] = $row;
        }

        return $productsArray;
    }

    public function fetchAllCategories()
    {
        $sql = "SELECT * FROM category";
        $result = $this->conn->query($sql);

        if ($result === false) {
            die("Error executing query: " . $this->conn->error);
        }

        $categoryArray = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $categoryArray[] = $row;
            }
        }

        return $categoryArray;
    }

    public function fetchProductById($id)
    {
        $sql = "SELECT * FROM products WHERE product_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }

        return null;
    }

    public function closeConnection()
    {
        $this->conn->close();
    }
}
?>
