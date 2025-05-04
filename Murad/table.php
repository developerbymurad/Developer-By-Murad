<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $table1 = $_POST["table1"];
    $table2 = $_POST["table2"];

    $blocked_tables = ["transaction", "users"];

    if (in_array(strtolower($table1), $blocked_tables) || in_array(strtolower($table2), $blocked_tables)) {
        echo "Invalid Table Request";
        exit;
    }

    $sql1 = "SELECT * FROM $table1";
    $result1 = $conn->query($sql1);

    $sql2 = "SELECT * FROM $table2";
    $result2 = $conn->query($sql2);

    $data = array(
        "Table 1" => array(),
        "Table 2" => array()
    );

    if ($result1->num_rows > 0) {
        while ($row = $result1->fetch_assoc()) {
            $data["Table 1"][] = $row;
        }
    }

    if ($result2->num_rows > 0) {
        while ($row = $result2->fetch_assoc()) {
            $data["Table 2"][] = $row;
        }
    }

    $json_data = json_encode($data, JSON_UNESCAPED_UNICODE);

    echo $json_data;

    $conn->close();
} else {
    echo "Invalid Request Method";
}
?>