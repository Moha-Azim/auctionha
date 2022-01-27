<?php
/*

** Title Function that Echo the page title in caset the  page 
** Has the Variable $pageTitle and Echo defult Title for other pages

*/

function getTitle()
{
    global $pageTitle;
    if (isset($pageTitle)) {
        echo $pageTitle;
    } else {
        echo 'Default';
    }
}



/*
**  redirectHome Function [ This Function Accept parameters ] 
** $theMsg = echo the  message  the alert-danger  of the sucsess message with Html class
** $seconds = seconds beform Redirecting  "
*/

function  redirectHome($theMsg, $url = null, $seconds = 3)
{
    if ($url == null) {
        $url = 'index.php';
        $pagename = "Home Page";
    } elseif ($url == 'back') {
        if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== "") {
            $url = $_SERVER['HTTP_REFERER'];
            $pagename = "Previous Page";
        } else {
            $url = "index.php";
            $pagename = "Home Page";
        }
    } else {
        $pagename = basename($url, ".php") . " Page";
    }
    echo "<div class='container'>";
    echo "<h1></h1>";
    echo $theMsg;
    echo "<div class='alert alert-info'> you Will be Redirect to $pagename  After  $seconds secounds</div>";
    echo "</div>";
    header("refresh:$seconds; url=$url");
    exit();
}



/*
** Check Items function v2.0
** Function to Check Item In database [ Function Accept Parameters ]
** $select   = The Item To Select [ Example: user , item , category ]
** $from     = The Table To Select From [ Example: users, items]
** $value    = The Value of select [ Example: Osama , box Electronics]
*/


function checkItem($select, $from, $value = null)
{

    global $con;
    $subquiry = "";
    if ($value !== null) {
        $subquiry = "WHERE $select = ?";
    }
    $statment = $con->prepare("SELECT $select FROM $from $subquiry ");
    if ($value !== null) {
        $statment->execute(array($value));
    } else {
        $statment->execute();
    }
    $counter = $statment->rowCount();

    return $counter;
}



/*

** count Number of Items or Rows v1.0
** countItems
** $items = items you want to count
** $table = the table you want to count from it


function countItems($items, $table)
{
    global $con;
    $stmt2 = $con->prepare("SELECT COUNT($items) FROM $table"); // to count how many member in the website
    $stmt2->execute();

    return $stmt2->fetchColumn();
}

*/



/*
** Get Latest Records Function v1.0
** Function To Get Latest Items From Database [Users, Items , Comments]
** $select = Field To Select
** $table = The Table To Choos From 
** $order = The Desc Ordering
**$limit = Number Of Record to get
*/


function getLatest($select, $table, $order, $limit = 5)
{
    global $con;
    $stmt = $con->prepare("SELECT $select FROM  $table ORDER BY  $order DESC LIMIT $limit");
    $stmt->execute();
    $usersnames = $stmt->fetchAll();

    return $usersnames;
}