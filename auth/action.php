<?php

require '../lib/function.php';
require '../lib/class.php';
$auth = new Auth;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if($_POST['signin'] === 'signin'){
        $username = $db->real_escape_string(trim(htmlspecialchars($_POST['username'])));
        $password = $db->real_escape_string(trim(htmlspecialchars($_POST['password'])));
        $signin = $auth->signin($username, $password);
        if($signin !== true){
            $_SESSION['notif'] = array('alert' => 'error', 'msg' => $signin);
            exit(header("Location: ".$url_website."auth/signin"));
        } else {
            exit(header("Location: ".$url_website));
        }
    }

    if($_POST['signup'] === 'signup'){
        $name = $db->real_escape_string(trim(htmlspecialchars($_POST['name'])));
        $username = $db->real_escape_string(trim(htmlspecialchars($_POST['username'])));
        $dob = $db->real_escape_string(trim(htmlspecialchars($_POST['birthday'])));
        $password = $db->real_escape_string(trim(htmlspecialchars($_POST['password'])));
        $gender = $db->real_escape_string(trim(htmlspecialchars($_POST['gender'])));
        $phone = hp($db->real_escape_string(trim(htmlspecialchars($_POST['phone']))));
        $email = $db->real_escape_string(trim(htmlspecialchars($_POST['email'])));
        $signup = $auth->signup($email, $password, $phone, $username, $dob, $name, $gender);
        if($signup === true){
            $_SESSION['notif'] = array('alert' => 'success', 'msg' => 'Please confirm your email address');
            exit(header("Location: ".$url_website."auth/signup"));
        } else {
            $_SESSION['notif'] = array('alert' => 'error', 'msg' => $signup);
            exit(header("Location: ".$url_website."auth/signup"));
        }
    }

    if($_POST['forgot'] === 'forgot'){
        $email = $db->real_escape_string(trim(htmlspecialchars($_POST['email'])));
        $forgot = $auth->forgot($email);
        if($forgot === true){
            $_SESSION['notif'] = array('alert' => 'success', 'msg' => 'Please check your email');
            exit(header("Location: ".$url_website."auth/forgot-password"));
        } else {
            $_SESSION['notif'] = array('alert' => 'error', 'msg' => $forgot);
            exit(header("Location: ".$url_website."auth/forgot-password"));
        }
    }

    if($_POST['reset'] === 'reset'){
        $password = $db->real_escape_string(trim(htmlspecialchars($_POST['password'])));
        $cpassword = $db->real_escape_string(trim(htmlspecialchars($_POST['cpassword'])));
        $token = $db->real_escape_string(trim(htmlspecialchars($_POST['token'])));
        $reset = $auth->reset($password, $cpassword, $token);
        if($reset === true){
            $_SESSION['notif'] = array('alert' => 'success', 'msg' => 'Your password has changed, please login');
            exit(header("Location: ".$url_website."auth/signin"));
        } else {
            $_SESSION['notif'] = array('alert' => 'error', 'msg' => $reset);
            exit(header("Location: ".$url_website."reset-password/".$token));
        }
    }
    
    
}