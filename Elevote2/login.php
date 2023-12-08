<?php
	session_start();
	include 'admin/includes/DatabaseCon.php';

    $databaseConnection = new Database();
    $conn = $databaseConnection->getConnection();


	if(isset($_POST['login'])){
		$voter = $_POST['voter'];
		$password = $_POST['password'];

		$sql = "SELECT * FROM voters WHERE voters_id = :voter";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':voter', $voter);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$row) {
            $_SESSION['error'] = 'Cannot find voter with the ID';
        } else {
            if (password_verify($password, $row['password'])) {
                $_SESSION['voter'] = $row['id'];
            } else {
                $_SESSION['error'] = 'Incorrect password';
            }
        }
    } else {
        $_SESSION['error'] = 'Input voter credentials first';
    }
    
    header('location: index.php');
    ?>