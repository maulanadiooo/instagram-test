<?php
include_once("web_config.php");
include_once("database.php");

session_start();

function format_date($date) {
	$split = explode("-", $date);
	$month = array('01' => 'Jan', '02' => 'Feb', '03' => 'Mar', '04' => 'Apr', '05' => 'Mei', '06' => 'Jun', '07' => 'Jul', '08' => 'Agu', '09' => 'Sep', '10' => 'Okt', '11' => 'Nov', '12' => 'Des');
	if (in_array($split[1], array_keys($month)) == false) {
		return "Something Wrong.";
	}
	return $split[2].' '.$month[$split[1]].' '.$split[0];
}