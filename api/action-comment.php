<?php
header('Content-Type: application/json');
require '../lib/function.php';
require '../lib/session.php';
require '../lib/is_login.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // id post
    $idPost = $db->real_escape_string(trim(htmlspecialchars($_POST['feedid'])));
    $comment = $db->real_escape_string(trim(htmlspecialchars($_POST['comment'])));
    // checkPost with idpost
    $checkPost = mysqli_query($db, "SELECT * FROM feeds WHERE id = '$idPost' ");
    $dataPost = mysqli_fetch_assoc($checkPost);
    $totalComment = $dataPost['total_comment'];
    if(empty($comment)){
        $_SESSION['notif'] = array('alert' => 'error', 'msg' => 'Input your comments');
        exit(header("Location: ".$url_website));
    }
    if(mysqli_num_rows($checkPost) == 1){
        $checkFollows = mysqli_query($db, "SELECT * FROM follows WHERE (user_id = '".$login['id']."' OR user_follow = '".$login['id']."'  )");
        // check foolow or not
        if(mysqli_num_rows($checkFollows) == 0 && $dataPost['user_id'] != $login['id']){
            $_SESSION['notif'] = array('alert' => 'error', 'msg' => 'Follow them first');
            exit(header("Location: ".$url_website));
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
                $_SESSION['notif'] = array('alert' => 'error', 'msg' => 'Follow them first');
                exit(header("Location: ".$url_website));
            } else {
                // add comments
                $addCommentToFeed = mysqli_query($db, "UPDATE feeds SET total_comment = $totalComment + 1 WHERE id = '$idPost' ");
                if($addCommentToFeed){
                    $insertCommentDetail = mysqli_query($db, "INSERT INTO comments (user_id, feed_id, comment ,created_at) VALUES ('".$login['id']."', '$idPost', '$comment', '$now_date')");
                    if($insertCommentDetail){
                        $_SESSION['notif'] = array('alert' => 'success', 'msg' => 'comment posted');
                        exit(header("Location: ".$url_website));
                    } else {
                        $_SESSION['notif'] = array('alert' => 'error', 'msg' => 'SQL error (03)');
                        exit(header("Location: ".$url_website));
                    }
                } else {
                    $_SESSION['notif'] = array('alert' => 'error', 'msg' => 'SQL error (01)');
                    exit(header("Location: ".$url_website));
                }
            }   
        }
    } else {
        $_SESSION['notif'] = array('alert' => 'error', 'msg' => 'Access Denied');
        exit(header("Location: ".$url_website));
    }
}