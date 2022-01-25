<?php
// memanggil detail user dengan $login
if (isset($_SESSION['id'])) {
	$login = mysqli_query($db, "SELECT * FROM users WHERE id = '".$_SESSION['id']."' ");
	if (mysqli_num_rows($login) == 0) {
		unset($_SESSION['id']);
		exit(header("Location: ".$url_website."auth/signin"));
	} 
	$login = mysqli_fetch_assoc($login);
}