<?php
header('Content-Type: application/json');
require '../lib/function.php';
require '../lib/session.php';
require '../lib/is_login.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // proses post request
    $data = json_decode(file_get_contents("php://input"), true);
    // id user
    $idUser = $db->real_escape_string(trim(htmlspecialchars($data['q'])));
    // checkPost with idpost
    $checkUser = mysqli_query($db, "SELECT * FROM users WHERE id = '$idUser' ");
    $dataUser = mysqli_fetch_assoc($checkUser);
    if(mysqli_num_rows($checkUser) == 1){
        
        // untuk follow
        $checkFolows = mysqli_query($db, "SELECT * FROM follows WHERE (user_id = '".$login['id']."' AND user_follow = '$idUser' ) OR (user_id = '$idUser' AND user_follow = '".$login['id']."' )");
        if(mysqli_num_rows($checkFolows) == 1){
            $dataFollows = mysqli_fetch_assoc($checkFolows);
            if($dataFollows['user_follow'] == $login['id'] && $dataFollows['status'] == 1){
                $status = 4;
            } elseif($dataFollows['user_follow'] == $login['id'] && $dataFollows['status'] == 0){
                $status = 3;
            } elseif($dataFollows['user_follow'] == $login['id'] && $dataFollows['status'] == 4){
                $status = 1;
            } elseif($dataFollows['user_follow'] == $login['id'] && $dataFollows['status'] == 3){
                $status = 0;
            } elseif($dataFollows['user_id'] == $login['id'] && $dataFollows['status'] == 0){
                $status = 1;
            } elseif($dataFollows['user_id'] == $login['id'] && $dataFollows['status'] == 1){
                $status = 0;
            } elseif($dataFollows['user_id'] == $login['id'] && $dataFollows['status'] == 3){
                $status = 4;
            } elseif($dataFollows['user_id'] == $login['id'] && $dataFollows['status'] == 4){
                $status = 3;
            }
            $updateFollows = mysqli_query($db, "UPDATE follows SET status = '$status' WHERE id = '".$dataFollows['id']."' ");
            if($updateFollows){
                $result = true;
            } else {
                $result = 'SQL Error (01)';
            }
        } 
        // untuk unfollow
        else {
            $insertNewFollows = mysqli_query($db, "INSERT into follows (user_id, user_follow, status, created_at) VALUES ('".$login['id']."', '$idUser', '1', '$now_date') ");
            if($insertNewFollows){
                $result = true;
            } else {
                $result = 'SQL Error (02)';
            }
        }
    } else {
        $result = 'Access Denied!';
    }
    echo $result;
}