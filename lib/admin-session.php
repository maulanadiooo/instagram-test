<?php
// memeriksa session login atau belum
if(!isset($_SESSION["admin"]) || $_SESSION["admin"] !== true){
    exit(header("Location: ".$url_website."admin/auth/signin"));
}