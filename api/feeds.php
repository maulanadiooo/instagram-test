<?php
header('Content-Type: application/json');
require '../lib/function.php';
require '../lib/session.php';
require '../lib/is_login.php';


$dataPerHalaman = 10;

$feeds = mysqli_query($db, "SELECT feeds.*, users.username, users.photo as photoUser FROM feeds 
join users  ON feeds.user_id = users.id 
ORDER by created_at DESC");

$jumlahData = mysqli_num_rows($feeds);
$jumlahHalaman = ceil($jumlahData/$dataPerHalaman);

if (isset($_GET['page'])) { 
    $pageActive = $db->real_escape_string(trim(htmlspecialchars($_GET['page'])));
} else {
    $pageActive = 1;
}
$awalData = ($dataPerHalaman * $pageActive) - $dataPerHalaman;

$feeds = mysqli_query($db, "SELECT feeds.*, users.username, users.photo as photoUser  FROM feeds 
join users  ON feeds.user_id = users.id
ORDER by created_at DESC
LIMIT $awalData,$dataPerHalaman");

$datas = [];
$a = [];
while ($data = mysqli_fetch_assoc($feeds)) {
    $datas[] = $data;
    foreach($datas as $key => $dataFeed){
        $checkUserLike = mysqli_query($db, "SELECT * FROM likes WHERE user_id = '".$login['id']."' AND feed_id = '".$dataFeed['id']."' ");
        if(mysqli_num_rows($checkUserLike) == 1){
            $a[$key] = array('data' => $dataFeed, 'liked' => 'ya');
        } else {
            $a[$key] = array('data' => $dataFeed, 'liked' => 'no');
        }
        
    }
    
}
$ret = array('lastPage' => $jumlahHalaman, 'results' => $a);
echo json_encode($ret); 


?>