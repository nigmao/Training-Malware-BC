<?php
require_once('config.php');

function connect(){
    $conn = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    return $conn;
}

// INSERT, UPDATE, DELETE
function execute($query) {
    $conn = connect();
    if (mysqli_query($conn, $query)) {
        mysqli_close($conn);
        return true;
    } else {
        echo "Error executing query: " . mysqli_error($conn);
        mysqli_close($conn);
        return false;
    }
}

// SELECT
function select($query){
    $conn = connect();
    $result = mysqli_query($conn, $query);
    if (!$result) {
        echo "Error executing query: " . mysqli_error($conn);
        mysqli_close($conn);
        return false;
    }
    $data = [];
    while ($row = mysqli_fetch_array($result, 1)){
        $data[] = $row;
    }
    mysqli_close($conn);
    return $data;
}
?>