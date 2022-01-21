<?php
header('Content-Type: application/json');
require '../lib/function.php';
require '../lib/session.php';
require '../lib/is_login.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $idPost = $db->real_escape_string(trim(htmlspecialchars($_GET['q'])));

    $checkPost = mysqli_query($db, "SELECT * FROM feeds WHERE id = '$idPost' AND user_id = '".$login['id']."' ");
    $dataPost = mysqli_fetch_assoc($checkPost);
    if(mysqli_num_rows($checkPost) == 1){
        // check dan delete database comments serta likes, karena terdapat foregin keys jadi tidak dapat dihapus begitu saja untuk postingan
        $checkLikes = mysqli_query($db, "SELECT * FROM likes WHERE feed_id = '$idPost' ");
        $checkComment = mysqli_query($db, "SELECT * FROM comments WHERE feed_id = '$idPost' ");
        if(mysqli_num_rows($checkLikes) > 0){
            $deleteLikes = mysqli_query($db, "DELETE FROM likes WHERE feed_id = '$idPost' ");
        }
        
        if(mysqli_num_rows($checkComment) > 0){
            $deleteComment = mysqli_query($db, "DELETE FROM comments WHERE feed_id = '$idPost' ");
        }

        $deletePost = mysqli_query($db, "DELETE FROM feeds WHERE id = '$idPost' "); 
        if($deletePost){
            unlink('../assets/images/feeds/'.$dataPost['photo']);
            $result = true;
        } else {
            $result = 'SQL Error';
        }
    } else {
        $result = 'Access Denied!';
    }
    echo $result;
}