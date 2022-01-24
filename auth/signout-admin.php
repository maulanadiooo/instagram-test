<?php
// Initialize the session
require '../lib/function.php';
require '../lib/admin-session.php';


// Unset all of the session variables
$_SESSION = array();

// Destroy the session.
session_destroy();
// Redirect to login page
exit(header("Location: ".$url_website."admin/auth/signin"));
?>