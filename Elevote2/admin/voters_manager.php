<?php

class VotersManager
{
    private $conn;

    public function __construct($database)
    {
        $this->conn = $database->getConnection();
    }

    public function addVoter($firstname, $lastname, $password, $photo)
    {
        // Generate voters ID
        $set = '123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $voter = substr(str_shuffle($set), 0, 15);

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO voters (voters_id, password, firstname, lastname, photo) VALUES (:voter, :password, :firstname, :lastname, :photo)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':voter', $voter, PDO::PARAM_STR);
        $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
        $stmt->bindParam(':firstname', $firstname, PDO::PARAM_STR);
        $stmt->bindParam(':lastname', $lastname, PDO::PARAM_STR);
        $stmt->bindParam(':photo', $photo, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $_SESSION['success'] = 'Voter added successfully';
        } else {
            $_SESSION['error'] = $stmt->errorInfo()[2]; // Fetch the specific error message
        }

        header('location: voters.php');
    }

    public function deleteVoter($id)
    {
        $sql = "DELETE FROM voters WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $_SESSION['success'] = 'Voter deleted successfully';
        } else {
            $_SESSION['error'] = $stmt->errorInfo()[2]; // Fetch the specific error message
        }

        header('location: voters.php');
    }

    public function editVoter($id, $firstname, $lastname, $password)
    {
        $sql = "SELECT * FROM voters WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($password == $row['password']) {
            $password = $row['password'];
        } else {
            $password = password_hash($password, PASSWORD_DEFAULT);
        }

        $updateSql = "UPDATE voters SET firstname = :firstname, lastname = :lastname, password = :password WHERE id = :id";
        $updateStmt = $this->conn->prepare($updateSql);
        $updateStmt->bindParam(':firstname', $firstname, PDO::PARAM_STR);
        $updateStmt->bindParam(':lastname', $lastname, PDO::PARAM_STR);
        $updateStmt->bindParam(':password', $password, PDO::PARAM_STR);
        $updateStmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($updateStmt->execute()) {
            $_SESSION['success'] = 'Voter updated successfully';
        } else {
            $_SESSION['error'] = $updateStmt->errorInfo()[2]; // Fetch the specific error message
        }

        header('location: voters.php');
    }

    public function updateVoterPhoto($id, $filename)
    {
        $sql = "UPDATE voters SET photo = :filename WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':filename', $filename, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $_SESSION['success'] = 'Photo updated successfully';
        } else {
            $_SESSION['error'] = $stmt->errorInfo()[2];
        }

        header('location: voters.php');
    }

    public function getVoterRow($id)
    {
        $sql = "SELECT * FROM voters WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row;
    }
}
?>
