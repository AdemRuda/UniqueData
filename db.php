<?php
$host = 'localhost';
$user = 'root'; // Change this if you have a different user
$pass = ''; // Add your MySQL password if required
$dbname = 'UniqueEmployeesData';

// Connect to MySQL database
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
