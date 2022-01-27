<?php

ini_set('display_errors', 'On');
error_reporting(E_ALL);

include "admin/connect.php";

$sessionUser = '';
if (isset($_SESSION['user'])) {
    $sessionUser = $_SESSION['user'];
}

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