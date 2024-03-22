<?php
// Database configuration
$db_host = 'localhost';
$db_name = 'nomina_pro';
$db_user = 'root';
$db_pass = '';

// Connect to the database
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Check the connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

?>