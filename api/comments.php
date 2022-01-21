<?php
header('Content-Type: application/json');
require '../lib/function.php';
require '../lib/session.php';
require '../lib/is_login.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
// proses post request
$data = json_decode(file_get_contents("php://input"), true);
$idPost = $db->real_escape_string(trim(htmlspecialchars($data['id'])));

$comments = mysqli_query($db, "SELECT *, users.username FROM comments 
join users ON comments.user_id = users.id
WHERE feed_id = '$idPost' 
ORDER by created_at ASC");
$datas = [];
while ($data = mysqli_fetch_assoc($comments)) {
    $datas[] = $data;
    
}
$ret = array('results' => $datas);
echo json_encode($ret); 
}

?>