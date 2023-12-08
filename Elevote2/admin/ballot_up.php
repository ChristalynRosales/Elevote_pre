<?php
include 'BallotManager.php';

$ballotManager = new BallotManager($conn);

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $ballotManager->movePositionUp($id);
}
?>
