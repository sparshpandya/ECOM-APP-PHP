<?php
class Checkout {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function createOrder($userId, $orderDetails) {
        try {
            // Begin transaction
            $this->conn->begin_transaction();

            // Sanitize inputs
            $userId = filter_var($userId, FILTER_SANITIZE_NUMBER_INT);
            $orderDate = date('Y-m-d H:i:s');

            // Insert into orders table
            $stmt = $this->conn->prepare("INSERT INTO orders (user_id, order_date) VALUES (?, ?)");
            $stmt->bind_param("is", $userId, $orderDate);
            $stmt->execute();

            // Get the last inserted order ID
            $orderId = $this->conn->insert_id;

            // Prepare statement for inserting into orderdetails table
            $stmt = $this->conn->prepare("INSERT INTO orderdetails (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");

            foreach ($orderDetails as $detail) {
                // Sanitize inputs
                $productId = filter_var($detail['product_id'], FILTER_SANITIZE_NUMBER_INT);
                $quantity = filter_var($detail['quantity'], FILTER_SANITIZE_NUMBER_INT);
                $price = filter_var($detail['price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

                // Bind parameters and execute
                $stmt->bind_param("iiid", $orderId, $productId, $quantity, $price);
                $stmt->execute();
            }

            // Commit transaction
            $this->conn->commit();

            return true;
        } catch (Exception $e) {
            // Rollback transaction in case of error
            $this->conn->rollback();
            echo "Failed to create order: " . $e->getMessage();
            return false;
        }
    }
}
?>
