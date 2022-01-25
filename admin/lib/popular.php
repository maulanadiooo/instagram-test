<?php

$totalPost = mysqli_num_rows(mysqli_query($db, "SELECT * FROM feeds"));
$totalComments = mysqli_num_rows(mysqli_query($db, "SELECT * FROM comments"));
$totalLikes = mysqli_num_rows(mysqli_query($db, "SELECT * FROM likes"));
$totalUsers = mysqli_num_rows(mysqli_query($db, "SELECT * FROM users"));
$feeds = mysqli_query($db, "SELECT feeds.*, users.username as username FROM feeds join users ON users.id = feeds.user_id ORDER by feeds.id DESC LIMIT 10");

// most followers
$user = mysqli_query($db, 'SELECT * FROM users');
$total_Followers = [];
while($data_user = mysqli_fetch_assoc($user)){
    // check followers dan following
      $checkFollowsbyUserId = mysqli_query($db, "SELECT * FROM follows WHERE user_id = '".$data_user['id']."'");
      $checkFollowsbyUserFollow = mysqli_query($db, "SELECT * FROM follows WHERE user_follow = '".$data_user['id']."'");

      if(mysqli_num_rows($checkFollowsbyUserId) > 0){

          
          $followers = mysqli_query($db, "SELECT * FROM follows WHERE user_id = '".$data_user['id']."' AND status IN (3,4)");
          
          
      } else {

          $followers = false;
      }

      if(mysqli_num_rows($checkFollowsbyUserFollow) > 0){

          
          $followers1 = mysqli_query($db, "SELECT * FROM follows WHERE user_follow = '".$data_user['id']."' AND status IN (1,4)");
          
          
      } else {
          $followers1 = false;
      }
      
      if($followers && $followers1){
          $totalFollowers = mysqli_num_rows($followers) + mysqli_num_rows($followers1);
      } elseif($followers){
          $totalFollowers = mysqli_num_rows($followers);
      } elseif($followers1){
          $totalFollowers = mysqli_num_rows($followers1);
      } else {
          $totalFollowers = 0;
      }
      $total_Followers[] = array('totalFollowers' => $totalFollowers."_".$data_user['id']);
}
$userWithMostFollowers = max($total_Followers);
$explode = explode("_", $userWithMostFollowers['totalFollowers']);
$followersTotal = $explode[0];
$user_id = $explode[1];
$getuserInfo = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM users WHERE id = '$user_id' "));

// poost with most likes
$postFeed = mysqli_query($db, "SELECT count(feed_id) as total, feed_id, feeds.*, users.username 
FROM likes 
join feeds ON feeds.id = likes.feed_id
join users ON users.id = feeds.user_id
GROUP by feed_id 
ORDER by total DESC 
LIMIT 1");

$dataMostLike = mysqli_fetch_assoc($postFeed);
