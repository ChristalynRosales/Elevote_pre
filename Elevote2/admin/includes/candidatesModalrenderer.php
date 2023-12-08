<?php

class CandidatesModal
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function renderPositionOptions()
    {
        $htmlOptions = '';

        $sql = "SELECT * FROM positions";
        $stmt = $this->conn->prepare($sql);

        try {
            $stmt->execute();
            $positions = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($positions as $row) {
                $htmlOptions .= "<option value='" . $row['id'] . "'>" . $row['description'] . "</option>";
            }
        } catch (PDOException $e) {
            // Handle the exception if needed
        }

        echo $htmlOptions;
    }

    // Other methods...
}
?>
