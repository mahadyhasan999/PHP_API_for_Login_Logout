<?php

if (!empty($_POST["name"]) && !empty($_POST["email"]) && !empty($_POST["password"])) {
    
    include_once("database_conn.php");

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    if ($conn) {

        $query = "INSERT INTO `users`(`name`, `email`, `password`) VALUES ('".$name."','".$email."','".$password."')";
        
        if(mysqli_query($conn, $query)) {
            echo "Registration Successful";
        } else{
            echo "Registration failed";
        }

    } else {
        echo json_encode(array("error" => "Connection Failed: " . mysqli_connect_error()));
    }
} else {
    echo json_encode(array("error"=> "All fields are required"));
    exit();
}