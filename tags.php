<?php
ob_start();
session_start();
$pageTitle =  "Tags";
include "init.php";
?>

<div class="container">
    <?php
    //$items = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;

    if (isset($_GET['name'])) {
        $tag = $_GET['name'];
        echo  "<h1 class='text-center'>" . $tag . " </h1>";


        $getItems = $con->prepare("SELECT *  FROM  items WHERE tags LIKE ?");
        $getItems->execute(array("%" . $tag . "%"));
        $items = $getItems->fetchAll();

        foreach ($items as $item) { // to get  only itmes in this category
            echo '<div class="col-sm-6 col-md-3">';
            echo '<div class="thumbnail item-box">';
            echo '<span class="price-tag">$' . $item['Price'] . '</span>';
            echo '<img class="img-responsive" src="imgtest.png" alt="">';
            echo '<div class="caption">';
            echo '<a href="items.php?itemid=' . $item['Item_ID'] . '"><h3> ' . $item['Name'] . '</h3></a>';
            echo '<p>' . $item['Description'] . '</p>';
            echo '<div class="date">' . $item['Add_Date'] . '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo "<div class='alert alert-danger'>NO Tag Found </div>";
    }
    ?>
</div>

<?php include $temp . "footer.php";
ob_end_flush();