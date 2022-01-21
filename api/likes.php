<?php
header('Content-Type: application/json');
require '../lib/function.php';
require '../lib/session.php';
require '../lib/is_login.php';
// menampilkan api likes
$feeds = mysqli_query($db, "SELECT likes.* FROM likes 
join users  ON likes.user_id = users.id ");
$datas = array();
$likes = [];
while ($data = mysqli_fetch_assoc($feeds)) {
    $datas[] = $data;
}
$ret = $datas;
echo json_encode($ret);


?>