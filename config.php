<?php
// Database connection details
$servername = "localhost";
$username = "vwok";
$password = "awpotak07";
$dbname = "myboolio";

// Create database connection
$conn = new mysqli($servername, $username, $password, $dbname);

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if the connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
else
{
    // /n 
}
?>
