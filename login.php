<?php

if (!empty($_POST["email"]) && !empty($_POST["password"])){
    include_once "database_conn.php";
    
    $password = $_POST['password'];
    $email = $_POST['email'];
    $result = array();

    if ($conn){
        $sql = "SELECT * FROM users WHERE email = '".$email."'";
        $res = mysqli_query($conn, $sql);
        if(mysqli_num_rows($res) > 0){
            $row = mysqli_fetch_assoc($res);
            if($email == $row['email'] && password_verify( $password, $row['password']) ){
                try {
                    $apiKey = bin2hex(random_bytes(23));
                } catch (Exception $e) {
                    $apiKey = bin2hex(uniqid($email, true));
                    echo ''. $e->getMessage() .'';
                }
                $sqlUpdate ="update users set apiKey = '".$apiKey."' where email = '".$email."'" ;
                if(mysqli_query($conn, $sqlUpdate)){
                    $result = array("status"=>"Success","message"=> "Login successfull",
                        "name" => $row["name"],
                        "email"=> $row["email"],
                        "apiKey"=> $row["apiKey"]
                    );
                } else $result = array("status"=> "error","message"=> " Login failed try again");
            }else $result = array("status"=> "error","message"=> "Retry with correct Email & Password");
        }else $result = array("status"=> "error","message"=> "Retry with correct Email & Password ");
    }else $result = array("status"=> "error","message"=> "Database connection failed.");
}else $result = array("status"=> "error","message"=> "All fields are required.");

echo json_encode($result);
// echo json_encode($apiKey);