<?php
class UserInformation {
    private $conn;
    private $firstName;
    private $lastName;
    private $email;
    private $phone;
    private $address;
    private $password;
    private $confirmPassword;
    private $country;
    private $state;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function setData($firstName, $lastName, $email, $phone, $address, $password, $confirmPassword, $country, $state) {
        $this->firstName = trim($firstName);
        $this->lastName = trim($lastName);
        $this->email = filter_var(trim($email), FILTER_SANITIZE_EMAIL);
        $this->phone = filter_var(trim($phone), FILTER_SANITIZE_NUMBER_INT);
        $this->address = trim($address);
        $this->password = trim($password);
        $this->confirmPassword = trim($confirmPassword);
        $this->country = intval($country);
        $this->state = intval($state);
    }

    public function validate() {
        if (empty($this->firstName) || empty($this->lastName) || empty($this->email) || empty($this->phone) || empty($this->address) || empty($this->password) || empty($this->confirmPassword) || empty($this->country) || empty($this->state)) {
            return "All fields are required.";
        } elseif (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            return "Invalid email format.";
        } elseif (!preg_match('/^\d{10}$/', $this->phone)) {
            return "Invalid phone number format. It should be 10 digits.";
        } elseif ($this->password !== $this->confirmPassword) {
            return "Passwords do not match.";
        } elseif (($this->country == 1 && !in_array($this->state, [1, 2, 3, 4])) || ($this->country == 2 && !in_array($this->state, [5, 6, 7, 8])) || ($this->country == 3 && !in_array($this->state, [9, 10, 11, 12]))) {
            return "Invalid state selection for the selected country.";
        } else {
            return true;
        }
    }

    public function register() {
        $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);
        $fullName = $this->firstName . " " . $this->lastName;

        $stmt = $this->conn->prepare("INSERT INTO UserInformation (name, email_id, number, billing_address, password, country_id, state_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssissii", $fullName, $this->email, $this->phone, $this->address, $hashedPassword, $this->country, $this->state);

        if ($stmt->execute()) {
            return "User registration successful, please log in.";
        } else {
            return "Error: " . $stmt->error;
        }
    }
}
?>
