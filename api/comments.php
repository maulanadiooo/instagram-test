<?php
header('Content-Type: application/json');
require '../lib/function.php';
require '../lib/session.php';
require '../lib/is_login.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
// proses post request
$data = json_decode(file_get_contents("php://input"), true);
$idPost = $db->real_escape_string(trim(htmlspecialchars($data['id'])));

$comments = mysqli_query($db, "SELECT comments.*, users.username FROM comments 
join users ON comments.user_id = users.id
WHERE feed_id = '$idPost' 
ORDER by created_at ASC");
$datas = [];
$a= [];
while ($data = mysqli_fetch_assoc($comments)) {
    $datas[] = $data;
    foreach($datas as $key => $dataComment){
        // check yang punya post
        $checkFeedPoster = mysqli_query($db, "SELECT user_id FROM feeds WHERE id = '".$dataComment['feed_id']."' ");
        $dataFeedPoster = mysqli_fetch_assoc($checkFeedPoster);
        // check apakah user yang login like comment 
        $checkCommentLikes = mysqli_query($db, "SELECT * FROM comment_likes WHERE comment_id = '".$dataComment['id']."' AND user_id = '".$login['id']."' ");
        if(mysqli_num_rows($checkCommentLikes) > 0){
            $dataCommentLikes = mysqli_fetch_assoc($checkCommentLikes);
            $a[$key] = array('data' => $dataComment, 'userFeedPoster' => $dataFeedPoster['user_id'], 'commentLiked' => 'ya');
        } else {
            $a[$key] = array('data' => $dataComment, 'userFeedPoster' => $dataFeedPoster['user_id'], 'commentLiked' => 'no');
        }
        

    }
    
}
$checkFeedLike = mysqli_query($db, "SELECT * FROM likes WHERE feed_id = '$idPost' AND user_id = '".$login['id']."' ");
if(mysqli_num_rows($checkFeedLike) == 1){
    $liked = 'ya';
} else {
    $liked = 'no';
}
$ret = array('results' => $a, 'likedBySession' => $liked);
echo json_encode($ret); 
}

?>