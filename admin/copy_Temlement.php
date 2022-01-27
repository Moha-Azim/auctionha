<?php

/*
===============================================
==Template Page
===============================================
*/


ob_start(); // Output Buffering Start

session_start();
$pageTitle = '';
if (isset($_SESSION['userloged'])) {
    include 'init.php';
    $do = isset($_GET['do']) ? $_GET['do'] : 'manage';

    if ($do == 'manage') {
    } elseif ($do == 'add') {
        //
    } elseif ($do == 'insert') {
        //
    } elseif ($do == 'edit') {
        //
    } elseif ($do == 'update') {
        //
    } elseif ($do == 'delete') {
        //
    } elseif ($do == 'activate') {
        //
    }

    include $temp . "footer.php";
} else {
    header('Location:index.php');
    exit();
}
ob_end_flush(); // Release The Output