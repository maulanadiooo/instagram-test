<?php

require '../../lib/function.php';
require '../../lib/class.php';
$auth = new Auth;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if($_POST['signinadmin'] === 'signinadmin'){
        $email = $db->real_escape_string(trim(htmlspecialchars($_POST['email'])));
        $password = $db->real_escape_string(trim(htmlspecialchars($_POST['password'])));
        $signin = $auth->signinadmin($email, $password);
        if($signin !== true){
            $_SESSION['notif'] = array('alert' => 'error', 'msg' => $signin);
            exit(header("Location: ".$url_website."admin/auth/signin"));
        } else {
            exit(header("Location: ".$url_website."admin/home"));
        }
    }
    
    
}