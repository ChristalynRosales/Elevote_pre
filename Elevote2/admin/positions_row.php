<?php
include 'includes/session.php';
include 'positionclass.php';

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $positionObj = new Position($conn);
    $row = $positionObj->getPositionById($id);
    echo json_encode($row);
}
?>
