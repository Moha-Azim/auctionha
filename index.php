<?php
ob_start();
session_start();
$pageTitle =  "AuctionHA";
include "init.php";


//if bid time remaining is 0  and there is no bid on itme will add another 1 day on bid time remaining

?>
<div class="container">
    <h1 class="text-center">Auction-HA</h1>
    <?php
    $items = getAllFrom('items', 'Item_ID', 'WHERE Approve = 1'); // OR make the oreder by  rand()
    foreach ($items as $item) {
        echo '<div class="col-sm-6 col-md-3">';
        echo '<div class="thumbnail item-box">';
        echo '<span class="price-tag">$' . $item['Price'] . '</span>';

        $now = new DateTime();
        $bid_time_remaining = new DateTime($item['end_biddingDate']);

        $stmtb = $con->prepare('SELECT COUNT(*) AS counte FROM bidding WHERE item_id = ?'); // to count if there bid process befor or not 
        $stmtb->execute(array($item['Item_ID']));
        $current = $stmtb->fetch();

        if ($bid_time_remaining < $now && $current['counte'] == 0) {
            $result = $now->format('Y-m-d H:i:s'); // to convert the format
            $hourp =  $con->prepare("UPDATE  items SET end_biddingDate =  date_add(now(),interval 1 day); WHERE Item_ID = ?");
            $hourp->execute(array($item['Item_ID']));
        }
        // change the var $bid_time_remaining value if the above statment done because  the valeu will change 
        $bid_time_remaining = new DateTime($item['end_biddingDate']);
        if ($bid_time_remaining < $now) {
            echo '<span class="rotated-sold">Sold</span>';
        }


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