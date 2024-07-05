<?php

if (!empty($_POST["email"]) && !empty($_POST["token"])) {
    include_once "database_conn.php";

    if ($conn) {
        $email = $_POST['email'];
        $token = $_POST['token'];
        $result = array();

        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND token = ?");
        $stmt->bind_param("ss", $email, $token);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res->num_rows > 0) {
            $row = $res->fetch_assoc();
            $result = array("status" => "Success", "message" => "Data fetched successfully", "name" => $row["name"], "email" => $row["email"], "token" => $row["token"]);
        } else {
            $result = array("status" => "error", "message" => "Unauthorized access");
        }
    } else {
        $result = array("status" => "error", "message" => "Database connection failed.");
    }
} else {
    $result = array("status" => "error", "message" => "All fields are required.");
}
echo json_encode($result);



// if (!empty($_POST["email"]) && !empty($_POST["token"])){
//     include_once "database_conn.php";

//     if($conn){
//         $email = $_POST['email'];
//         $token =  $_POST['token'];
//         $result = array();

//         $sql = "SELECT * FROM `users` WHERE email = '".$email."' and token = '".$token."' ";
//         $res = mysqli_query($conn, $sql);

//         if(mysqli_num_rows($res) > 0){
//             $row = mysqli_fetch_assoc($res);
//             $result = array("status"=> "Success", "message"=>"Data fetched successfully.",
//                     "name" => $row["name"],
//                     "email"=> $row["email"],
//                     "token"=> $row["token"]    
//                 );
//         } else echo"Unauthorised to access !";
//     } else echo "Database connection Failed !";
// } else echo"All fields are required !";

// echo json_encode($result);

?>
