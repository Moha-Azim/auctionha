<?php
ob_start();
session_start();
$pageTitle =  "AuctionHA";
include "init.php";
?>

<div class="container">

    <h1 class="text-center"> <?php
                                if (isset($_GET['pagename'])) {
                                    echo str_replace('-', " ", $_GET['pagename']);
                                } else {
                                    echo 'Category Not Found !!!';
                                }
                                ?></h1>
    <?php
    //$items = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;

    if (isset($_GET['catid']) && is_numeric($_GET['catid'])) {
        $items = intval($_GET['catid']);

        $stmt = $con->prepare("SELECT * FROM items WHERE Cat_ID IN ( SELECT ID FROM categories WHERE ID = ? OR parent = ?) AND Approve = 1 ");
        $stmt->execute(array($items, $items));
        $allItmes = $stmt->fetchAll();


        foreach ($allItmes as $item) { // to get  only itmes in this category
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
        echo "<div class='alert alert-danger'>NO Items Found </div>";
    }
    ?>
</div>

<?php include $temp . "footer.php";
ob_end_flush();