<?php

require '../lib/function.php';
require '../lib/session.php';
require '../lib/is_login.php';
require '../lib/class.php';

$profile = new Profile;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if($_POST['changepass'] === 'changepass'){
        $password = $db->real_escape_string(trim(htmlspecialchars($_POST['password'])));
        $npassword = $db->real_escape_string(trim(htmlspecialchars($_POST['npassword'])));
        $cnpassword = $db->real_escape_string(trim(htmlspecialchars($_POST['cnpassword'])));

        $cpassword = $profile->cpassword($password, $npassword, $cnpassword);
        if($cpassword !== true){
            $_SESSION['notif'] = array('alert' => 'error', 'msg' => $cpassword);
            exit(header("Location: ".$url_website."accounts/edit"));
        } else {
            $_SESSION['notif'] = array('alert' => 'success', 'msg' => 'Your password Changed!');
            exit(header("Location: ".$url_website."accounts/edit"));
        }
    }
    if($_POST['changephoto'] === 'changephoto'){
        $photo = $_FILES['photoprof'];

        $cphoto = $profile->cphoto($photo);
        if($cphoto !== true){
            $_SESSION['notif'] = array('alert' => 'error', 'msg' => $cphoto);
            exit(header("Location: ".$url_website."accounts/edit"));
        } else {
            $_SESSION['notif'] = array('alert' => 'success', 'msg' => 'Your Photo Changed!');
            exit(header("Location: ".$url_website."accounts/edit"));
        }
    }
    if($_POST['cdetail'] === 'cdetail'){
        $name = $db->real_escape_string(trim(htmlspecialchars($_POST['name'])));
        $birthday = $db->real_escape_string(trim(htmlspecialchars($_POST['birthday'])));
        $gender = $db->real_escape_string(trim(htmlspecialchars($_POST['gender'])));
        $phone = hp($db->real_escape_string(trim(htmlspecialchars($_POST['phone']))));

        $cdetail = $profile->cdetail($name, $birthday, $gender, $phone);
        if($cdetail !== true){
            $_SESSION['notif'] = array('alert' => 'error', 'msg' => $cdetail);
            exit(header("Location: ".$url_website."accounts/edit"));
        } else {
            $_SESSION['notif'] = array('alert' => 'success', 'msg' => 'Your Detail Changed!');
            exit(header("Location: ".$url_website."accounts/edit"));
        }
    }
    

}