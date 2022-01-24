<?php
header('Content-Type: application/json');
require '../lib/function.php';
require '../lib/session.php';
require '../lib/is_login.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    // id post
    $idPost = $db->real_escape_string(trim(htmlspecialchars($data['id'])));
    $comment = $db->real_escape_string(trim(htmlspecialchars($data['comment'])));
    // checkPost with idpost
    $checkPost = mysqli_query($db, "SELECT * FROM feeds WHERE id = '$idPost' ");
    $dataPost = mysqli_fetch_assoc($checkPost);
    if($comment == ''){
        $result = 'Comment cant empty';
    }
    if(mysqli_num_rows($checkPost) == 1){
        $checkFollows = mysqli_query($db, "SELECT * FROM follows WHERE (user_id = '".$login['id']."' OR user_follow = '".$login['id']."'  )");
        // check foolow or not
        if(mysqli_num_rows($checkFollows) == 0 && $dataPost['user_id'] != $login['id']){
            $result = 'Follow Them First';
        } else {
            $dataFollows = mysqli_fetch_assoc($checkFollows);
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
                $result = 'Follow Them First';
            } else {
                // add comments
                
                $insertCommentDetail = mysqli_query($db, "INSERT INTO comments (user_id, feed_id, comment ,created_at) VALUES ('".$login['id']."', '$idPost', '$comment', '$now_date')");
                if($insertCommentDetail){
                    $result = true;
                } else {
                    $result = 'SQL Error (03)';
                }
                
            }   
        }
    } else {
        $result = 'Access denied';
    }

    echo $result;
}