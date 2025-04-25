<?php
$servername = "localhost";
$username = "root";         // Default username for XAMPP/WAMP
$password = "";             // Default password is blank
$database = "coconutshell"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
