<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = $_POST['type'];

    if ($type === 'getdata') {
        $sql = "SELECT * FROM ludoking";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $rows = array();
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
            $json_data = json_encode($rows);
            echo $json_data;
        } else {
            echo "No Matches Found";
        }
    }

    $conn->close();
} else {
    echo "Invalid Request Method";
}
?>