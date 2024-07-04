<?php

if (!empty($_POST["email"]) && !empty($_POST["apiKey"])){
    include_once "database_conn.php";

    if($conn){
        $email = $_POST['email'];
        $apiKey =  $_POST['apiKey'];

        $sql = "SELECT * FROM `users` WHERE email = '".$email."' and apiKey = '".$apiKey."' ";
        $res = mysqli_query($conn, $sql);
        if(mysqli_num_rows($res) > 0){ 
            $row = mysqli_fetch_assoc($res);
            //here we are updating the apiKey as empty
            $sqlUpdate = "update users set apiKey = '' where email = '".$email."'";
            if(mysqli_query($conn, $sqlUpdate)){
                echo "Logged out!";
            } else echo"Logout failed";
        } else echo "Unauthorised access";
    } else $result = array("status"=> "error","message"=> "Database connection failed.");
} else echo"All fields are required";