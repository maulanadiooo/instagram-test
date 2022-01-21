<?php
// memeriksa session pada form auth, jika session valid redirect ke halaman home
if(isset($_SESSION['loggedin']) && $_SESSION["loggedin"] === true){
    exit(header("Location: ".$url_website));
}