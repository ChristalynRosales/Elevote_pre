<?php
include 'includes/session.php';
include 'includes/header.php';
include 'includes/DatabaseCon.php';
include 'voters_manager.php';

$votersManager = new VotersManager($conn());

if (isset($_POST['delete'])) {
    $id = $_POST['id'];

    $votersManager->deleteVoter($id);
}

// The rest of your HTML and form code
?>
