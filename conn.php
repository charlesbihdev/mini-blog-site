<?php
$servername = "localhost"; 
$username = "group7"; 
$password = "CEGROUP7"; 
$dbname = "blog_site"; 

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


?>








