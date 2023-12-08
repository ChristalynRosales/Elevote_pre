<?php
include 'ballot_manager.php';

$ballotManager = new BallotManager($conn);

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $ballotManager->movePositionDown($id);
}
?>
