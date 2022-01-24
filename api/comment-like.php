<?php
header('Content-Type: application/json');
require '../lib/function.php';
require '../lib/session.php';
require '../lib/is_login.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // proses post request
    $data = json_decode(file_get_contents("php://input"), true);
    // id comment
    $idComment = $db->real_escape_string(trim(htmlspecialchars($data['q'])));
    $action = $db->real_escape_string(trim(htmlspecialchars($data['action'])));
    // checkPost with idpost
    $checkComment = mysqli_query($db, "SELECT * FROM comments WHERE id = '$idComment' ");
    $dataComment = mysqli_fetch_assoc($checkComment);
    if(mysqli_num_rows($checkComment) == 1){
        // check apakah user follow yang punya comment
        $checkFollows = mysqli_query($db, "SELECT * FROM follows WHERE (user_id = '".$login['id']."' OR user_follow = '".$login['id']."'  )");
        if(mysqli_num_rows($checkFollows) == 0 && $dataComment['user_id'] != $login['id']){
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
            if($statusFollow == 'Not Followed' && $dataComment['user_id'] != $login['id']){
                $result = 'Follow them first';
            } else {
                // ini untuk memproses like unlike comment
                if($action === 'likeComment'){
                    $checkUserCommentLike = mysqli_query($db, "SELECT user_id FROM comment_likes WHERE user_id = '".$login['id']."' AND comment_id = '$idComment' ");
                    if(mysqli_num_rows($checkUserCommentLike) == 0){
                        // add like
                        $insertCommentLikes = mysqli_query($db, "INSERT INTO comment_likes (user_id, comment_id, created_at) VALUES ('".$login['id']."', '$idComment', '$now_date')");
                        if($insertCommentLikes){
                            $result = 'commentLiked';
                        } else {
                            $result = $db->error;
                        }
                    } else {
                        // remove comment like
                        
                        $deleteCommentLikes = mysqli_query($db, "DELETE FROM comment_likes WHERE user_id = '".$login['id']."' AND comment_id = '$idComment' ");
                        if($deleteCommentLikes){
                            $result = 'commentUnliked';
                        } else {
                            $result = 'SQL Error(04)';
                        }
                        
                    }
                } 
                // ini untuk delete comment
                elseif($action === 'deleteComment'){
                    // delete comment likes terlebi dahulu
                    // check jika yang melakukan perintah adalah pemilik feed atau bukan
                    $checkFeedPoster = mysqli_query($db,
                        "SELECT feeds.user_id
                        FROM comments
                        join feeds ON feeds.id = comments.feed_id
                        WHERE comments.id = '$idComment' ");
                    if(mysqli_num_rows($checkFeedPoster) == 1){
                        $deleteCommentLike = mysqli_query($db, "DELETE FROM comment_likes WHERE comment_id = '$idComment'");
                        if($deleteCommentLike){
                            $deleteComment = mysqli_query($db, "DELETE FROM comments WHERE id = '$idComment' ");
                            if($deleteComment){
                                $deleteCommentLikes = mysqli_query($db, "DELETE comment_likes WHERE comment_id = '$idComment' ");
                                if($deleteCommentLikes){
                                    $result = true;
                                } else {
                                    $result = 'SQL error (07)';
                                }
                            } else {
                                $result = 'SQL error (06)';
                            }
                        } else {
                            $result = 'SQL Error (05)';
                        }
                    } else {
                        $deleteCommentLike = mysqli_query($db, "DELETE FROM comment_likes WHERE comment_id = '$idComment' AND user_id = '".$login['id']."' ");
                        if($deleteCommentLike){
                            $deleteComment = mysqli_query($db, "DELETE FROM comments WHERE id = '$idComment' ");
                            if($deleteComment){
                                $deleteCommentLikes = mysqli_query($db, "DELETE comment_likes WHERE comment_id = '$idComment' ");
                                if($deleteCommentLikes){
                                    $result = true;
                                } else {
                                    $result = 'SQL error (08)';
                                }
                            } else {
                                $result = 'SQL error (06)';
                            }
                        } else {
                            $result = 'SQL Error (05)';
                        }
                    }
                   
                    

                } 
                // menampilkan komentar ke modal
                elseif($action === 'editComment' ){
                    $result = $dataComment['comment'];
                } 
                // update komentar yang diubah
                elseif($action === 'updateComment'){
                    $checkComment = mysqli_query($db, "SELECT * FROM comments WHERE id = '$idComment' AND user_id = '".$login['id']."' ");
                    if(mysqli_num_rows($checkComment) == 1){
                        $commentUpdate = $db->real_escape_string(trim(htmlspecialchars($data['commentUpdate'])));
                        $updateComment = mysqli_query($db, "UPDATE comments SET comment = '$commentUpdate', updated_at = '$now_date'  WHERE id = '$idComment' ");
                        if($updateComment){
                            $result = true;
                        } else {
                            $result = 'SQL Error';
                        }
                    } else {
                        $result = 'Your access denied';
                    }
                }
                
            }
               
        }
        
    } else {
        $result = 'Access Denied!';
    }
    echo $result;
}