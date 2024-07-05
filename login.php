<?php

if (!empty($_POST["email"]) && !empty($_POST["password"])) {
    include_once "database_conn.php";
    $password = $_POST['password'];
    $email = $_POST['email'];
    $result = array();

    if ($conn) {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res->num_rows > 0) {
            $row = $res->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                try {
                    $token = bin2hex(random_bytes(23));
                } catch (Exception $e) {
                    $token = bin2hex(uniqid($email, true));
                    echo json_encode(array("status" => "error", "message" => $e->getMessage()));
                    exit();
                }
                $stmtUpdate = $conn->prepare("UPDATE users SET token = ? WHERE email = ?");
                $stmtUpdate->bind_param("ss", $token, $email);
                if ($stmtUpdate->execute()) {
                    $result = array("status" => "Success", "message" => "Login successful", "name" => $row["name"], "email" => $row["email"], "token" => $token);
                } else {
                    $result = array("status" => "error", "message" => "Login failed, try again");
                }
            } else {
                $result = array("status" => "error", "message" => "Retry with correct Email & Password");
            }
        } else {
            $result = array("status" => "error", "message" => "Retry with correct Email & Password");
        }
    } else {
        $result = array("status" => "error", "message" => "Database connection failed.");
    }
} else {
    $result = array("status" => "error", "message" => "All fields are required.");
}
echo json_encode($result);



// if (!empty($_POST["email"]) && !empty($_POST["password"])){
//     include_once "database_conn.php";
    
//     $password = $_POST['password'];
//     $email = $_POST['email'];
//     $result = array();

//     if ($conn){
//         $sql = "SELECT * FROM users WHERE email = '".$email."'";
//         $res = mysqli_query($conn, $sql);
//         if(mysqli_num_rows($res) > 0){
//             $row = mysqli_fetch_assoc($res);
//             if($email == $row['email'] && password_verify( $password, $row['password']) ){
//                 try {
//                     $token = bin2hex(random_bytes(23));
//                 } catch (Exception $e) {
//                     $token = bin2hex(uniqid($email, true));
//                     echo ''. $e->getMessage() .'';
//                 }
//                 $sqlUpdate ="update users set token = '".$token."' where email = '".$email."'" ;
//                 if(mysqli_query($conn, $sqlUpdate)){
//                     $result = array("status"=>"Success","message"=> "Login successfull",
//                         "name" => $row["name"],
//                         "email"=> $row["email"],
//                         "token"=> $row["token"]
//                     );
//                 } else $result = array("status"=> "error","message"=> " Login failed try again");
//             }else $result = array("status"=> "error","message"=> "Retry with correct Email & Password");
//         }else $result = array("status"=> "error","message"=> "Retry with correct Email & Password ");
//     }else $result = array("status"=> "error","message"=> "Database connection failed.");
// }else $result = array("status"=> "error","message"=> "All fields are required.");

// echo json_encode($result);
// // echo json_encode($token);

?>
