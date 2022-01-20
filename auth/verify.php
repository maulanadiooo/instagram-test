<?php
require '../lib/function.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if(!$_GET['token']){
        header("location: ".$url_website."auth/signin");
    } else {
        $token = $db->real_escape_string(trim(htmlspecialchars($_GET["token"])));
        $sql = mysqli_query($db, "SELECT * FROM users WHERE user_token = '$token' AND verified = '0' ");
        $data_user = mysqli_fetch_assoc($sql);
        if(mysqli_num_rows($sql) == 1){
            $update_user = mysqli_query($db, "UPDATE users SET verified = 1, user_token = null WHERE id = '".$data_user['id']."' ");
            if($update_user){
                $_SESSION['notif'] = array('alert' => 'success', 'msg' => 'Your account has been verified, please login');
                exit(header("Location: ".$url_website."auth/signin"));
            } else {
                $_SESSION['notif'] = array('alert' => 'error', 'msg' => 'SQL Error');
                exit(header("Location: ".$url_website."auth/signin"));
            }
            
        } else {
            die('you have wrong address');
        }
    }
}
?>