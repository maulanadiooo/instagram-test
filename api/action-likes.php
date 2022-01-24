<?php
header('Content-Type: application/json');
require '../lib/function.php';
require '../lib/session.php';
require '../lib/is_login.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // proses post request
    $data = json_decode(file_get_contents("php://input"), true);
    // id post
    $idPost = $db->real_escape_string(trim(htmlspecialchars($data['q'])));
    // checkPost with idpost
    $checkPost = mysqli_query($db, "SELECT * FROM feeds WHERE id = '$idPost' ");
    $dataPost = mysqli_fetch_assoc($checkPost);
    if(mysqli_num_rows($checkPost) == 1){
        // check apakah user follow yang punya post
        $checkFollows = mysqli_query($db, "SELECT * FROM follows WHERE (user_id = '".$login['id']."' OR user_follow = '".$login['id']."'  )");
        if(mysqli_num_rows($checkFollows) == 0 && $dataPost['user_id'] != $login['id']){
            $result = 'Follow them first';
        } else {
            $dataFollows = mysqli_fetch_assoc($checkFollows);
            // check foolow or not
            if($dataFollows['status'] == 4 && $dataFollows['user_follow'] == $login['id']){
                $statusFollow = 'Folowed';
            } elseif($dataFollows['status'] == 3 && $dataFollows['user_follow'] == $login['id']){
                $statusFollow = 'Folowed';
            } elseif($dataFollows['status'] == 1 && $dataFollows['user_id'] == $login['id']){
                $statusFollow = 'Folowed';
            } elseif($dataFollows['status'] == 4 && $dataFollows['user_id'] == $login['id']){
                $statusFollow = 'Folowed';
            } else {
                $statusFollow = 'Not Followed';
            }
            if($statusFollow == 'Not Followed' && $dataPost['user_id'] != $login['id']){
                $result = 'Follow them first';
            } else {
                $checkUserLike = mysqli_query($db, "SELECT user_id FROM likes WHERE user_id = '".$login['id']."' AND feed_id = '$idPost' ");
                if(mysqli_num_rows($checkUserLike) == 0){
                    // add like
                   
                    $insertLikeDetail = mysqli_query($db, "INSERT INTO likes (user_id, feed_id, created_at) VALUES ('".$login['id']."', '$idPost', '$now_date')");
                    if($insertLikeDetail){
                        $result = true;
                    } else {
                        $result = 'SQL Error(03)';
                    }
                } else {
                    // remove like
                    
                    $deleteLikeDetail = mysqli_query($db, "DELETE FROM likes WHERE user_id = '".$login['id']."' AND feed_id = '$idPost' ");
                    if($deleteLikeDetail){
                        $result = true;
                    } else {
                        $result = 'SQL Error(04)';
                    }
                    
                }
            }
               
        }
        
    } else {
        $result = 'Access Denied!';
    }
    echo $result;
}