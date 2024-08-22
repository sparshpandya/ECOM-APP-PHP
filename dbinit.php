<!DOCTYPE html>
<html>
    <head>
        <title>Db Initialization</title>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    </head>
<body>
    <form method="POST">
        <button class="btn btn-success" name="submit" type="submit">Create DB</button>
    </form>
    <!-- showing the register button on successfull table creation -->
    <?php 
        if(isset($_POST['submit'])) {
            echo "
    <div>
        <a href='register.php' class='btn btn-info mt-2'>Register User</a>
    </div>";
        };
    ?>
    <?php 
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        include 'db_conn.php';
        
        // Select database
        if(!$conn->select_db($dbname)){
            die("Failed to select DB: " . $conn->error);
        }

        // SQL to create tables
        $sql = "
            CREATE TABLE IF NOT EXISTS Country (
                country_id INT AUTO_INCREMENT PRIMARY KEY,
                country_name VARCHAR(255) NOT NULL
            );

            CREATE TABLE IF NOT EXISTS State (
                state_id INT AUTO_INCREMENT PRIMARY KEY,
                state_name VARCHAR(255) NOT NULL,
                country_id INT,
                FOREIGN KEY (country_id) REFERENCES Country(country_id)
            );

            CREATE TABLE IF NOT EXISTS Category (
                category_id INT AUTO_INCREMENT PRIMARY KEY,
                category_name VARCHAR(255) NOT NULL
            );

            CREATE TABLE IF NOT EXISTS Products (
                product_id INT AUTO_INCREMENT PRIMARY KEY,
                product_name VARCHAR(255) NOT NULL,
                price DECIMAL(10, 2) NOT NULL,
                inventory INT NOT NULL,
                category_id INT,
                image_url VARCHAR(255),
                FOREIGN KEY (category_id) REFERENCES Category(category_id)
            );

            CREATE TABLE IF NOT EXISTS UserInformation (
                user_id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                email_id VARCHAR(255) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL,
                number VARCHAR(20),
                billing_address TEXT,
                country_id INT,
                state_id INT,
                FOREIGN KEY (country_id) REFERENCES Country(country_id),
                FOREIGN KEY (state_id) REFERENCES State(state_id)
            );

            CREATE TABLE IF NOT EXISTS Orders (
                order_id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT,
                order_date DATETIME DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES UserInformation(user_id)
            );

            CREATE TABLE IF NOT EXISTS OrderDetails (
                order_detail_id INT AUTO_INCREMENT PRIMARY KEY,
                order_id INT,
                product_id INT,
                quantity INT NOT NULL,
                price DECIMAL(10, 2) NOT NULL,
                billing_address VARCHAR(255) NOT NULL,
                FOREIGN KEY (order_id) REFERENCES Orders(order_id),
                FOREIGN KEY (product_id) REFERENCES Products(product_id)
            );

            INSERT IGNORE INTO Country (country_name) VALUES 
            ('United States'),
            ('Canada'),
            ('India');

            INSERT IGNORE INTO State (state_name, country_id) VALUES 
            ('California', 1),
            ('New York', 1),
            ('Texas', 1),
            ('Florida', 1),
            ('Ontario', 2),
            ('Quebec', 2),
            ('British Columbia', 2),
            ('Alberta', 2),
            ('Maharashtra', 3),
            ('Gujarat', 3),
            ('Rajasthan', 3),
            ('Delhi', 3);

            INSERT IGNORE INTO Category (category_name) VALUES 
            ('Luxury'),
            ('Smart'),
            ('Sports'),
            ('Vintage');

            INSERT IGNORE INTO Products (product_name, price, inventory, category_id, image_url) VALUES 
            ('Rolex Submariner', 8999.99, 10, 1, 'luxury1.jpg'),
            ('Omega Speedmaster', 6599.99, 8, 1, 'luxury2.jpg'),
            ('Patek Philippe Nautilus', 34999.99, 15, 1, 'luxury3.jpg'),
            ('Audemars Piguet Royal Oak', 27999.99, 5, 1, 'luxury4.jpg'),
            ('Apple Watch Series 7', 399.99, 20, 2, 'smart1.jpg'),
            ('Samsung Galaxy Watch 4', 249.99, 25, 2, 'smart2.jpg'),
            ('Fitbit Sense', 299.99, 18, 2, 'smart3.jpg'),
            ('Garmin Fenix 6', 549.99, 22, 2, 'smart4.jpg'),
            ('Tag Heuer Formula 1', 1699.99, 30, 3, 'sports1.jpg'),
            ('Breitling Superocean', 4499.99, 28, 3, 'sports2.jpg'),
            ('Omega Seamaster Diver 300M', 5199.99, 25, 3, 'sports3.jpg'),
            ('Tissot T-Race', 899.99, 20, 3, 'sports4.jpg'),
            ('Cartier Tank', 6499.99, 10, 4, 'vintage1.jpg'),
            ('Jaeger-LeCoultre Reverso', 7299.99, 12, 4, 'vintage2.jpg'),
            ('Longines Heritage', 2199.99, 8, 4, 'vintage3.jpg'),
            ('Rolex Oyster Perpetual', 7499.99, 6, 4, 'vintage4.jpg');
        ";

        // Execute the queries
        if ($conn->multi_query($sql) === TRUE) {
            echo "Successfully created tables and inserted data";
        } else {
            echo "Error creating tables or inserting data: " . $conn->error;
        }

        // Close connection
        $conn->close();
    }
    ?>

    
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
