<?php
header('Content-Type: application/json');
require '../lib/function.php';
require '../lib/session.php';
require '../lib/is_login.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
// proses post request
$data = json_decode(file_get_contents("php://input"), true);
$idUserLogin = $login['id'];
if($idUserLogin === $login['id']){

    $array = [];
    $a = mysqli_query($db, "SELECT user_follow FROM follows WHERE user_id = '$idUserLogin' AND status IN (1,4) ");
    while($data = mysqli_fetch_assoc($a)){
        $array[] = $data['user_follow'];
    }
    $b = mysqli_query($db, "SELECT user_id FROM follows WHERE user_follow = '$idUserLogin' AND status IN (3,4) ");
    while($datas = mysqli_fetch_assoc($b)){
        $array[] = $datas['user_id'];
    }
    $followed = implode(",", $array);
    $check = mysqli_query($db,"SELECT users.id,users.username,users.photo,users.name
    FROM users
    WHERE id != '".$login['id']."' AND id NOT IN ($followed)
    ORDER by rand()
    LIMIT 10");
    $datas = [];
    $a = [];
    while($data = mysqli_fetch_assoc($check)){
        $datas[] = $data;
        foreach($datas as $key => $dataUser){
            
            $a[$key] = array('data' => $dataUser, 'urlProfile' => $url_website.$dataUser['username'], 'urlPhoto' => $url_website.'assets/images/profile/'.$dataUser['photo']);
            
        }
    }
    
} else {
    $a = 'Access ilegal';
}
    $ret = array('results' => $a);
    echo json_encode($ret); 

}

?>