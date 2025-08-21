<?php
// Database configuration
$servername = "localhost"; // Or your server IP
$username = "root";        // Your database username (default for XAMPP/MAMP)
$password = "";            // Your database password (default is empty for XAMPP)
$dbname = "to-do-app";      // The name of the database you created

// Create a new database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    // If connection fails, stop the script and show an error
    die("Connection failed: " . $conn->connect_error);
}

// Set the character set to utf8mb4 for full Unicode support
$conn->set_charset("utf8mb4");
?>