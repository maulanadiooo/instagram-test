<?php
header('Content-Type: application/json');
require '../lib/function.php';
require '../lib/session.php';
require '../lib/is_login.php';

$checkFolows = mysqli_query($db, "SELECT * FROM follows WHERE (user_id = '".$login['id']."' ) OR (user_follow = '".$login['id']."' )");
if(mysqli_num_rows($checkFolows) == 1){
    $dataFolows = mysqli_fetch_assoc($checkFolows);
    $status = $dataFolows['status'];
    $user_id = $dataFolows['user_id'];
    $user_follows = $dataFolows['user_follow'];
    // membuat follow, unfollow, dan follback berdasarkan status
    if($status == 0){
        $result = 'Follow';
    } elseif($status == 1 && $user_id == $login['id']){
        $result = 'Unfollow';
    } elseif($status == 3 && $user_id == $login['id']){
        $result = 'Followback';
    } elseif($status == 4 && $user_id == $login['id']){
        $result = 'Unfollow';
    } elseif($status == 1 && $user_follows == $login['id']){
        $result = 'Followback';
    } elseif($status == 3 && $user_follows == $login['id']){
        $result = 'Unfollow';
    } elseif($status == 4 && $user_follows == $login['id']){
        $result = 'Unfollow';
    }
} else {
    $result = 'Follow';
}

$ret = array('results' => $result);
echo json_encode($ret); 


?>