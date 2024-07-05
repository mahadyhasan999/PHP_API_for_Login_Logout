<?php
header("Content-Type: application/json");
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login_register";
$conn = mysqli_connect($servername, $username, $password, $dbname);

if (mysqli_connect_errno()) {
    echo json_encode(array("status" => "error", "message" => "Database connection failed: " . mysqli_connect_error()));
    exit();
}


// header("Content-Type: application/json");

// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "login_register";

// $conn = mysqli_connect($servername, $username, $password, $dbname);

// if (mysqli_connect_errno()) {
//     die("Error". mysqli_connect_error());
// }

?>
