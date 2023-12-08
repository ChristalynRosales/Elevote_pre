<?php
session_start();
include 'includes/DatabaseCon.php';

$database = new Database();
$conn = $database->getConnection();

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT id, password FROM admin WHERE username = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        $stmt->bindValue(1, $username, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            $_SESSION['error'] = 'Cannot find an account with the username';
        } else {
            if (password_verify($password, $result['password'])) {
                $_SESSION['admin'] = $result['id'];
            } else {
                $_SESSION['error'] = 'Incorrect password';
            }
        }

        // Close the statement after use
        $stmt = null;
    } else {
        $_SESSION['error'] = 'Error preparing SQL statement';
    }
} else {
    $_SESSION['error'] = 'Input admin credentials first';
}

// Close the connection after use
$conn = null;

header('location: index.php');
?>
