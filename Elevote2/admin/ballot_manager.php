<?php

include 'includes/session.php';

class BallotManager
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function movePositionUp($id)
    {
        $output = array('error' => false);

        $sql = "SELECT * FROM positions WHERE id='$id'";
        $query = $this->conn->query($sql);
        $row = $query->fetch_assoc();

        $priority = $row['priority'] - 1;

        if ($priority == 0) {
            $output['error'] = true;
            $output['message'] = 'This position is already at the top';
        } else {
            $sql = "UPDATE positions SET priority = priority + 1 WHERE priority = '$priority'";
            $this->conn->query($sql);

            $sql = "UPDATE positions SET priority = '$priority' WHERE id = '$id'";
            $this->conn->query($sql);
        }

        echo json_encode($output);
    }

    public function movePositionDown($id)
    {
        $output = array('error' => false);

        $sql = "SELECT * FROM positions";
        $pquery = $this->conn->query($sql);

        $sql = "SELECT * FROM positions WHERE id='$id'";
        $query = $this->conn->query($sql);
        $row = $query->fetch_assoc();

        $priority = $row['priority'] + 1;

        if ($priority > $pquery->num_rows) {
            $output['error'] = true;
            $output['message'] = 'This position is already at the bottom';
        } else {
            $sql = "UPDATE positions SET priority = priority - 1 WHERE priority = '$priority'";
            $this->conn->query($sql);

            $sql = "UPDATE positions SET priority = '$priority' WHERE id = '$id'";
            $this->conn->query($sql);
        }

        echo json_encode($output);
    }

    public function fetchPositions()
    {
        $output = '';
        $candidate = '';

        $sql = "SELECT * FROM positions ORDER BY priority ASC";
        $query = $this->conn->query($sql);
        $num = 1;

        while ($row = $query->fetch_assoc()) {
            // ... (existing code for building $input, $candidate, $instruct, $updisable, $downdisable, $output)

            $num++;
            $candidate = '';
        }

        echo json_encode($output);
    }
}

// Usage for ballot_up.php
$ballotManager = new BallotManager($conn);
if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $ballotManager->movePositionUp($id);
}

// Usage for ballot_down.php
$ballotManager = new BallotManager($conn);
if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $ballotManager->movePositionDown($id);
}

// Usage for ballot_fetch.php
$ballotManager = new BallotManager($conn);
$ballotManager->fetchPositions();
?>
