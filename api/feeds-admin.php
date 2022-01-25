<?php

require '../lib/function.php';
require '../lib/admin-session.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $idFeed = $db->real_escape_string(trim(htmlspecialchars($_GET['q'])));
    $feeds = mysqli_query($db, "SELECT *  FROM feeds WHERE id = '$idFeed'");

    $datas = [];
    while ($data = mysqli_fetch_assoc($feeds)) {
        $datas[] = $data;
        
    }
    $ret = array('results' => $datas);
    echo json_encode($ret); 
}



?>