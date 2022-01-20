<?php

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    exit(header("Location: ".$url_website."auth/signin"));
}