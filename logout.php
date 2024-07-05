<?php

if (!empty($_POST["email"]) && !empty($_POST["token"])) {
    include_once "database_conn.php";

    if ($conn) {
        $email = $_POST['email'];
        $token = $_POST['token'];

        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND token = ?");
        $stmt->bind_param("ss", $email, $token);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res->num_rows > 0) {
            $stmtUpdate = $conn->prepare("UPDATE users SET token = '' WHERE email = ?");
            $stmtUpdate->bind_param("s", $email);

            if ($stmtUpdate->execute()) {
                echo json_encode(array("status" => "Success", "message" => "Logged out successfully"));
            } else {
                echo json_encode(array("status" => "error", "message" => "Logout failed"));
            }
        } else {
            echo json_encode(array("status" => "error", "message" => "Unauthorized access"));
        }
    } else {
        echo json_encode(array("status" => "error", "message" => "Database connection failed."));
    }
} else {
    echo json_encode(array("status" => "error", "message" => "All fields are required."));
}




// if (!empty($_POST["email"]) && !empty($_POST["token"])){
//     include_once "database_conn.php";

//     if($conn){
//         $email = $_POST['email'];
//         $token =  $_POST['token'];

//         $sql = "SELECT * FROM `users` WHERE email = '".$email."' and token = '".$token."' ";
//         $res = mysqli_query($conn, $sql);
//         if(mysqli_num_rows($res) > 0){ 
//             $row = mysqli_fetch_assoc($res);
//             //here we are updating the token as empty
//             $sqlUpdate = "update users set token = '' where email = '".$email."'";
//             if(mysqli_query($conn, $sqlUpdate)){
//                 echo "Logged out!";
//             } else echo"Logout failed";
//         } else echo "Unauthorised access";
//     } else $result = array("status"=> "error","message"=> "Database connection failed.");
// } else echo"All fields are required";


?>
