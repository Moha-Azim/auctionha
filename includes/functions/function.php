<?php




/*
==function checkUserStatus($user)
== Check if the user is activated by admin or not  by check the RegStatus in users table in database
== $user ==> the username  you will take it from $_SESSION['user']
*/

function checkUserStatus($user)
{

    global $con;

    $stmt = $con->prepare("SELECT Username , RegStatus FROM users WHERE Username = ? AND RegStatus = 0");
    $stmt->execute(array($user));
    $conter =  $stmt->rowCount();

    return $conter;
}




/*

    getAllFrom()  function to get the all record from any table in datea vase

    $tableName ==> the name of table you want fetch record from
*/

function getAllFrom($tableName, $order, $where = NULL)
{
    global $con;
    $getAll = $con->prepare("SELECT *  FROM  $tableName $where ORDER BY $order DESC");
    $getAll->execute();
    $records = $getAll->fetchAll();

    return $records;
}
/*



/*

getCat()  function to get the category
*/


function getCat($where = NULL)
{
    global $con;
    $getCat = $con->prepare("SELECT *  FROM  categories $where ORDER BY  ID ASC");
    $getCat->execute();
    $cats = $getCat->fetchAll();

    return $cats;
}
/*

getItems()  function to get the ({[ AD ]})  item in choosen category   just AD  advertising

$catid ==> the id of the category to get the items from it


AD   AD    AD   AD   AD for advertising  only
*/

function getItems($where, $value, $approve = NULL,)
{

    $sql = $approve == 1 ? 'AND Approve = 1' : '';
    global $con;
    $getItems = $con->prepare("SELECT *  FROM  items WHERE $where = ?   $sql ORDER BY  Item_ID DESC");
    $getItems->execute(array($value));
    $items = $getItems->fetchAll();

    return $items;
}














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
** $theMsg = echo the  message
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