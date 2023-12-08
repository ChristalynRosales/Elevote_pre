<?php
include 'includes/session.php';
include 'includes/header.php';
include 'includes/DatabaseCon.php';
include 'voters_manager.php';

$votersManager = new VotersManager($conn());

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $row = $votersManager->getVoterRow($id);
    echo json_encode($row);
} else {
    // Handle the case when the ID is not provided
    echo json_encode(['error' => 'ID not provided']);
}

?>
