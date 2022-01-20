<?php
include_once("web_config.php");
include_once("database.php");

session_start();

// merubah format tanggal 
function format_date($date) {
	$split = explode("-", $date);
	$month = array('01' => 'Jan', '02' => 'Feb', '03' => 'Mar', '04' => 'Apr', '05' => 'Mei', '06' => 'Jun', '07' => 'Jul', '08' => 'Agu', '09' => 'Sep', '10' => 'Okt', '11' => 'Nov', '12' => 'Des');
	if (in_array($split[1], array_keys($month)) == false) {
		return "Something Wrong.";
	}
	return $split[2].' '.$month[$split[1]].' '.$split[0];
}

// merubah format no hp menjadi global
function hp($nohp){
	 // cek apakah no hp mengandung karakter + dan 0-9
	 if(!preg_match('/[^+0-9]/',trim($nohp))){
        // cek apakah no hp karakter 1-2 adalah 62
        if(substr(trim($nohp), 0, 2)=='62'){
            $hp = trim($nohp);
        }
        // cek apakah no hp karakter 1 adalah 0
        elseif(substr(trim($nohp), 0, 1)=='0'){
            $hp = '62'.substr(trim($nohp), 1);
        } 
        // cek apakah no hp karakter 1-3 adalah +62
        elseif(substr(trim($nohp), 0, 3)=='+62'){
            $hp = '62'.substr(trim($nohp), 3);
        }else {
            $hp = trim($nohp);
        }
    }
    return $hp;
}

function send_email($to, $subject, $message){

	

	
	$msg = wordwrap($message,70);

	// send email
	$mail = mail($to,$subject,$msg);
	return $mail;

}

function resizeImage($resourceType, $image_width, $image_height, $resizeWidth, $resizeHeight)
{
    
    $imageLayer = imagecreatetruecolor($resizeWidth, $resizeHeight);
    imagecopyresampled($imageLayer, $resourceType, 0, 0, 0, 0, $resizeWidth, $resizeHeight, $image_width, $image_height);
    return $imageLayer;
}
