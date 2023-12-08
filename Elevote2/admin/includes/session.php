<?php
session_start(); 
include 'includes/DatabaseCon.php';


$database = new Database(); // Create an instance of the Database class
$conn = $database->getConnection(); // Get a database connection

if (!isset($_SESSION['admin']) || trim($_SESSION['admin']) == '') {
    header('location: index.php');
}

$sql = "SELECT * FROM admin WHERE id = :admin_id"; // Use a prepared statement
$stmt = $conn->prepare($sql);
$stmt->bindParam(':admin_id', $_SESSION['admin'], PDO::PARAM_INT);
$stmt->execute();

$user = $stmt->fetch(PDO::FETCH_ASSOC);

?>
