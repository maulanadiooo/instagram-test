<?php
// memeriksa session pada form auth, jika session valid redirect ke halaman home
if(isset($_SESSION['admin']) && $_SESSION["admin"] === true){
    exit(header("Location: ".$url_website."admin/home"));
}