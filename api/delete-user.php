<?php
header('Content-Type: application/json');
require '../lib/function.php';
require '../lib/admin-session.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $data = json_decode(file_get_contents("php://input"), true);
    $idUser = $db->real_escape_string(trim(htmlspecialchars($data['q'])));

    $checkUser = mysqli_query($db, "SELECT * FROM users WHERE id = '$idUser' ");
    $dataUser = mysqli_fetch_assoc($checkUser);

    if(mysqli_num_rows($checkUser) == 1){
        // check dan delete database feeds, comments, comments like, follows serta likes, karena terdapat foregin keys jadi tidak dapat dihapus begitu saja untuk postingan

        // delete comment likes yang ada user id yang akan di hapus
        $checkCommentLikes = mysqli_query($db, "SELECT * FROM comment_likes WHERE user_id = '$idUser' ");
        if(mysqli_num_rows($checkCommentLikes) > 0){
            $deleteCommentLikes = mysqli_query($db, "DELETE FROM comment_likes WHERE user_id = '$idUser' ");
        }

        // check and delete likes
        $checkLikes = mysqli_query($db, "SELECT * FROM likes WHERE user_id = '$idUser' ");
        if(mysqli_num_rows($checkLikes) > 0){
            $deleteLikes = mysqli_query($db, "DELETE FROM likes WHERE user_id = '$idUser' ");
        }

        // check and delete comments
        $checkComment = mysqli_query($db, "SELECT * FROM comments WHERE user_id = '$idUser' ");
        if(mysqli_num_rows($checkComment) > 0){
            $deleteComment = mysqli_query($db, "DELETE FROM comments WHERE user_id = '$idUser' ");
        }
        
        // check and delete follows by user_id and user_follow
        $checkFollowsbyUserId= mysqli_query($db, "SELECT * FROM follows WHERE user_id = '$idUser' ");
        if(mysqli_num_rows($checkFollowsbyUserId) > 0){
            $deleteFollowsbyUserId = mysqli_query($db, "DELETE FROM follows WHERE user_id = '$idUser' ");
        }
        $checkFollowsbyUserFollow= mysqli_query($db, "SELECT * FROM follows WHERE user_follow = '$idUser' ");
        if(mysqli_num_rows($checkFollowsbyUserFollow) > 0){
            $deleteFollowsbyUserFollow = mysqli_query($db, "DELETE FROM follows WHERE user_follow = '$idUser' ");
        }

        // check feed and delete
        $checkPost = mysqli_query($db, "SELECT * FROM feeds WHERE user_id = '$idUser' ");
        if(mysqli_num_rows($checkPost) > 0){
            while($dataPost = mysqli_fetch_assoc($checkPost)){
                unlink('../assets/images/feeds/'.$dataPost['photo']);
            }
        }
        $deletePost = mysqli_query($db, "DELETE FROM feeds WHERE user_id = '$idUser' ");

        // delete USER
    
        $deleteUser = mysqli_query($db, "DELETE FROM users WHERE id = '$idUser' ");

        // delete photo profle jika tidak menggunakan photo default
        if($dataUser['photo'] != 'instagram.png'){
            unlink('../assets/images/profile/'.$dataUser['photo']);
        }
        
        if($deleteUser){
            $result = true;
        } else {
            $result = $db->error;
        }
        

    } else {
        $result = 'Access Denied!';
    }
    echo $result;

}