<?php

if (isset($_SESSION['id'])) {
	$login = mysqli_query($db, "SELECT * FROM users WHERE id = '".$_SESSION['id']."' ");
	if (mysqli_num_rows($login) == 0) {
		exit(header("Location: ".$url_website."auth/signout"));
	} 
	$login = mysqli_fetch_assoc($login);
}