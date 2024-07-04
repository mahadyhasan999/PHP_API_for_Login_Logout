<?php

if (!empty($_POST["email"]) && !empty($_POST["apiKey"])){
    include_once "database_conn.php";

    if($conn){
        $email = $_POST['email'];
        $apiKey =  $_POST['apiKey'];
        $result = array();

        $sql = "SELECT * FROM `users` WHERE email = '".$email."' and apiKey = '".$apiKey."' ";
        $res = mysqli_query($conn, $sql);

        if(mysqli_num_rows($res) > 0){
            $row = mysqli_fetch_assoc($res);
            $result = array("status"=> "Success", "message"=>"Data fetched successfully.",
                    "name" => $row["name"],
                    "email"=> $row["email"],
                    "apiKey"=> $row["apiKey"]    
                );
        } else echo"Unauthorised to access !";
    } else echo "Database connection Failed !";
} else echo"All fields are required !";

echo json_encode($result);