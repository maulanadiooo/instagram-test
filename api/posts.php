<?php
header('Content-Type: application/json');
require '../lib/function.php';

// menampilkan API post
$userId = $db->real_escape_string(trim(htmlspecialchars($_GET['q'])));
// jumlah per Halaman
$dataPerHalaman = 12;

$feeds = mysqli_query($db, "SELECT feeds.*, users.username, users.photo as photoUser FROM feeds 
        join users  ON feeds.user_id = users.id 
        WHERE user_id = '$userId'
        ORDER by created_at DESC");

$jumlahData = mysqli_num_rows($feeds);
$jumlahHalaman = ceil($jumlahData/$dataPerHalaman);

if (isset($_GET['page'])) { 
    $pageActive = $db->real_escape_string(trim(htmlspecialchars($_GET['page'])));
} else {
    $pageActive = 1;
}
$awalData = ($dataPerHalaman * $pageActive) - $dataPerHalaman;

$feeds = mysqli_query($db, "SELECT feeds.*, users.username, users.photo as photoUser FROM feeds 
        join users  ON feeds.user_id = users.id 
        WHERE user_id = '$userId'
        ORDER by created_at DESC
        LIMIT $awalData,$dataPerHalaman");

$datas = array();
while ($data = mysqli_fetch_assoc($feeds)) {
    $datas[] = $data;
}
$ret = array('lastPage' => $jumlahHalaman, 'results' => $datas);
echo json_encode($ret);


?>