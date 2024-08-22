<?php
class LoginClass {
    private $conn;
    private $email;
    private $password;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function setData($email, $password) {
        $this->email = filter_var(trim($email), FILTER_SANITIZE_EMAIL);
        $this->password = trim($password);
    }

    public function validate() {
        if (empty($this->email) || empty($this->password)) {
            return "All fields are required.";
        } elseif (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            return "Invalid email format.";
        } else {
            return true;
        }
    }

    public function login() {
        $stmt = $this->conn->prepare("SELECT password FROM UserInformation WHERE email_id = ?");
        $stmt->bind_param("s", $this->email);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($hashedPassword);
            $stmt->fetch();
            if (password_verify($this->password, $hashedPassword)) {
                    return "Login successful, welcome!";
            } else {
                return "Invalid password.";
            }
        } else {
            return "No account found with this email.";
        }
    }
}
?>
