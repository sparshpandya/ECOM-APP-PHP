<?php
    $servername = "localhost";   
    $username = "root";
    $password = "";
    $dbname = "awesome_smartshop";
    
     $conn = new mysqli($servername,$username,$password);

    

if ($conn ->connect_error ){
    die("Connection Failed:" . $conn->connect_error);
}

//initializing database
        $sql = "CREATE DATABASE IF NOT EXISTS $dbname";
        
        if($conn->query($sql) === TRUE){
            $conn->select_db($dbname);
        }else{
                echo "ERROR creating database: ". $conn->error. "<br>";
        }
?>