<?php

include "connect.php";
//////////  IN ADMIN FILE ////////
$languages = "includes/languages/";
$temp = "includes/templates/"; // templates file 
$func = "includes/functions/";
$css = "layout/css/";
$js = "layout/js/";



// include the important files
include $languages . "english.php";
include $func . 'function.php';
include $temp . "header.php";

// if the page have variable called $noNavbar the include will not happend
if (!isset($noNavbar)) {
    include $temp . "navbar.php";
}