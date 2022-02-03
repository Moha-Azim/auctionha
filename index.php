<?php
ob_start();
session_start();
$pageTitle =  "AuctionHA";
include "init.php";

?>
<div class="container">
    <h1 class="text-center">Auction-HA</h1>
    <?php
    $items = getAllFrom('items', 'Item_ID', 'WHERE Approve = 1');
    foreach ($items as $item) { // to get  only itmes in this category
        echo '<div class="col-sm-6 col-md-3">';
        echo '<div class="thumbnail item-box">';
        echo '<span class="price-tag">$' . $item['Price'] . '</span>';

        if (empty($item['mainImg'])) {
            $src = "admin/uploaded/itemsImg/999999999_default.png";
        } else {
            $src = "admin/uploaded/itemsImg/" . $item['mainImg'];
        }

        echo '<img class="img-responsive" src="' . $src . '" alt="">';
        echo '<div class="caption">';
        echo '<a href="items.php?itemid=' . $item['Item_ID'] . '"><h3> ' . $item['Name'] . '</h3></a>';
        echo '<p>' . $item['Description'] . '</p>';
        echo '<div class="date">' . $item['Add_Date'] . '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
    ?>
</div>

<?php
include $temp . "footer.php";
ob_end_flush();