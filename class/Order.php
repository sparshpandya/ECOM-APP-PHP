<?php
class Order
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function showUserDetails($userEmail) {
        $this->conn->begin_transaction();
        $stmt = $this->conn->prepare("SELECT * FROM userinformation WHERE email_id = ?");
        $stmt->bind_param("s", $userEmail);
        $stmt->execute();

        // Fetch the result as an associative array
        $result = $stmt->get_result();
        $userDetails = $result->fetch_assoc();

        $stmt->close();
        $this->conn->commit();

        return $userDetails;
    }

    public function saveOrder($user_id)
    {
        $sql = "INSERT INTO orders (user_id, order_date) VALUES (?, NOW())";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        
        if ($stmt->execute()) {
            return $stmt->insert_id; // Return the generated order ID
        } else {
            return false;
        }
    }

    public function saveOrderDetails($order_id, $product_id, $quantity, $price, $billing_address)
    {
        $sql = "INSERT INTO orderdetails (order_id, product_id, quantity, price, billing_address) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iiids", $order_id, $product_id, $quantity, $price, $billing_address);

        return $stmt->execute();
    }
}
?>
