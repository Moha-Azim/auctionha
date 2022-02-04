<?php
ob_start();
session_start();


$pageTitle =  "Bidding";
include "init.php";



if (isset($_SESSION['user'])) {

    // to refresh the page every two min
    $url1 = $_SERVER['REQUEST_URI'];
    header("Refresh: 120; URL=$url1");

    $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

    $stmt = $con->prepare("SELECT items.*, users.Username, categories.Name AS category_name FROM items INNER JOIN users ON Member_ID = UserID INNER JOIN categories ON Cat_ID = ID WHERE Item_ID = ? AND Approve = 1;
");
    $stmt->execute(array($itemid));

    $count = $stmt->rowCount();
    if ($count > 0) {
        $item = $stmt->fetch();
?>
<h1 class="text-center"><?php echo $item['Name'] ?></h1>
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <img class="img-responsive img-thumbnail center-block" src="<?php if (empty($item['mainImg'])) {
                                                                                    echo "admin/uploaded/itemsImg/999999999_default.png";
                                                                                } else {
                                                                                    echo "admin/uploaded/itemsImg/" . $item['mainImg'];
                                                                                }  ?>" alt="">
        </div>
        <div class="col-md-9 item-info">
            <h2><?php echo $item['Name'] ?></h2>
            <p><?php echo $item['Description'] ?></p>
            <ul class="list-unstyled">
                <li> <i class="fa fa-calendar fa-fw"></i>
                    <span>Added Date</span> : <?php echo $item['Add_Date'] ?>
                </li>
                <li>
                    <i class="far fa-money-bill-alt fa-fw"></i>
                    <span>Price</span> : $<?php echo $item['Price'] ?>
                </li>
                <li>
                    <i class=" fa fa-building fa-fw"></i>
                    <span>Made IN</span> : <?php echo $item['Conutry_Made'] ?>
                </li>
                <li>
                    <i class="fa fa-tags fa-fw"></i>
                    <span>Category</span> : <a
                        href="categories.php?catid=<?php echo $item['Cat_ID'] . '&pagename=' . $item['category_name'] ?> "><?php echo $item['category_name'] ?></a>
                </li>
                <li>
                    <i class="fa fa-user fa-fw"></i>
                    <span>Added By</span> : <a href="#"> <?php echo $item['Username'] ?> </a>
                </li>
                <li class="tags-item">
                    <i class="fa fa-tag fa-fw"></i>
                    <span>Tags</span> :
                    <?php
                            $allTags = explode(",", $item['tags']);
                            foreach ($allTags as $tag) {
                                $tag = str_replace(" ", "", $tag);
                                $tagtolower = strtolower($tag);
                                if (!empty($tag)) {
                                    echo "<a href='tags.php?name={$tagtolower}'>" . $tag . "</a>";
                                } else {
                                    echo 'No Tags Found';
                                }
                            }
                            ?>
                </li>
            </ul>
        </div>
    </div>
    <hr class="custom-hr">


    <?php
            // set the time zone
            date_default_timezone_set("Asia/Amman");

            // to count the bidding and find the max bid on this item
            $stmtb = $con->prepare('SELECT COUNT(*) AS counte , MAX(New_Price) AS current FROM bidding WHERE item_id = ?;');
            $stmtb->execute(array($itemid));
            $current = $stmtb->fetch();

            //if there is no bid on the item the current bid will be the price on this item
            if ($current['counte'] == 0) {
                $current['current'] =  $item['Price'];
            }

            // to select the id who make the last bid if is he this user will  echo span says you make the last bid
            $stmtMaxprice = $con->prepare('SELECT member_id FROM bidding WHERE item_id = ? AND New_Price = ?;');
            $stmtMaxprice->execute(array($itemid, $current['current']));
            $id_Lastbid =  $stmtMaxprice->fetch();

            // to Check how much the user have in the wallet 
            $wallet = $con->prepare('SELECT wallet,RegStatus FROM users WHERE UserID = ?');
            $wallet->execute(array($_SESSION['uid']));
            $wallet_bid = $wallet->fetch();

            // to select the time
            $now = new DateTime();
            $bid_time_remaining = new DateTime($item['end_biddingDate']);
            $interval = $bid_time_remaining->diff($now);


            // bidding inserting
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                $newPrice = filter_var($_POST['bid'], FILTER_SANITIZE_NUMBER_INT);
                $userid = $_SESSION['uid'];
                $itemid = $item['Item_ID'];


                $formErrors = array();


                if ($now > $bid_time_remaining) {
                    $formErrors[] = 'Sorry bidding time is over';
                }


                if ($item['Member_ID'] === $_SESSION['uid']) {
                    $formErrors[] = 'You can\'t bid on your item';
                }
                if (empty($_POST['bid'])) {
                    $formErrors[] = 'You have to put a number';
                }
                if (!is_numeric($_POST['bid'])) {
                    $formErrors[] = 'use numbers only';
                }

                /* the @ for ignoring the warning that will be showen if user add bid for first time on item 
                the warning about the var $id_Lastbid['member_id'] have no value cuse there is no bid yet on biddin table 
                */
                if (@$id_Lastbid['member_id'] == $_SESSION['uid']) {
                    $formErrors[] = 'You did the last bid You can\'t make another one';
                }

                if (is_numeric($_POST['bid'])   &&  $_POST['bid'] > $wallet_bid['wallet']) {
                    $formErrors[] = 'You did that much mony in the wallet';
                }

                if ($wallet_bid['RegStatus'] == 0) {
                    $formErrors[] = 'Your account need admin approved';
                }


                if ($current['current'] >= $_POST['bid']) {
                    $formErrors[] = 'You have to Choos Number More Than $' . $current['current'];
                }

                if (empty($formErrors)) {


                    if (!empty($_POST['bid'])) {
                        $stmts = $con->prepare("INSERT INTO bidding (New_Price,Date_time,item_id,member_id) VALUES (:New_Price,NOW(),:itemid,:userid)");
                        $stmts->execute(array(
                            ":New_Price" => $newPrice,
                            ":itemid" =>  $itemid,
                            ":userid" => $userid
                        ));
                    }

                    if ($stmts) {
                        // to add one more hour if user bid and the time will end in less than one hour
                        @$sec = (strtotime($item['end_biddingDate']) - strtotime(date("Y-m-d H:i:s")));
                        if ($sec <= 3600) {
                            $hourp =  $con->prepare("UPDATE  items SET end_biddingDate = ADDTIME(end_biddingDate, '1:00:00') WHERE Item_ID = ?");
                            $hourp->execute(array($itemid));
                        }

                        header("Location:" . $_SERVER['PHP_SELF'] . '?itemid=' . $itemid);
                    } else {
                        echo '<div class="alert alert-danger"> No record Inserted</div>';
                    }
                }
            }

            if ($now < $bid_time_remaining) {
            ?>
    <div class="row justify-content-md-center add-bid">
        <div class="col col-md-3">
            <p>Item Condition : New</p>
            <p> Time left: <?php


                                        // to check if the remaining time 0 month  or 0 day won't print it the zero value
                                        if ($now < $bid_time_remaining) {
                                            if ($interval->format('%m') != 0) {
                                                echo $interval->format('%m Month, %d days , %h hours, %i minutes');
                                            } elseif ($interval->format('%d') != 0) {
                                                echo $interval->format(' %d days , %h hours, %i minutes');
                                            } elseif ($interval->format('%h') != 0) {
                                                echo $interval->format('%h hours, %i minutes');
                                            } elseif ($interval->format('%i') != 0) {
                                                echo $interval->format(' %i minutes');
                                            }
                                        } else {
                                            echo 'the time is up';
                                        }


                                        ?></p>
            <span> <?php echo "End Date: " . $item['end_biddingDate'] ?></span>
        </div>
        <div class="col-md-9">
            <div class="col-md-2 the-bid">
                <p>Current bid:</p>
            </div>

            <div class="col-md-4 bid-price">
                <p class="current-bid"><?php echo "$" . $current['current'] ?>

                    <?php  // check if the last bid from this user but check first if there is bid on this item
                                if ($current['counte'] > 0) {
                                    if ($id_Lastbid['member_id'] == $_SESSION['uid']) {
                                        echo "<span class='last-bid'> You Did The Last Bid </span>";
                                    }
                                }
                                ?>
                </p>

                <form action="<?php echo $_SERVER['PHP_SELF'] . '?itemid=' . $itemid ?>" method="POST">
                    <input type="text" name="bid" required></input>
                    <p>Enter US <?php echo "$" . $current['current'] + 1 ?> or more</p>
            </div>
            <div class="col-md-4 the-bid">
                <p>[ <?php echo $current['counte'] ?> Bids ]</p>
                <input class="btn btn-primary btn-lg" type="submit" value="Place Bid">
                </form>
            </div>

        </div>

    </div>
    <?php
                if (!empty($formErrors)) {
                    foreach ($formErrors as $error) {
                        echo "<div class='the-errors'><div class='msg error'>" . $error . "</div></div>";
                    }
                }
                ?>
</div>

<?php
            } else {

                echo '<div class="alert alert-danger text-center"><strong>The Time is over  You Can\'t bid on this item</strong></div>';
            }
        } else {
            redirectHome('<div class="alert alert-danger">There is No Item Here Or the Item Need Approval form Admin</div>', 'login.php');
        }
    } else {
        redirectHome('<div class="alert alert-danger">You Should Login in or Sign Up to reach this page</div>', 'login.php');
    }
    include $temp . "footer.php";
    ob_end_flush();