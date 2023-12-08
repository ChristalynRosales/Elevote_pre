<?php
include 'ballot_manager.php';

$ballotManager = new BallotManager($conn);
$ballotManager->fetchPositions();
?>
