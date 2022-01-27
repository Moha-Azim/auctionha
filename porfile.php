<?php
ob_start();
session_start();
$pageTitle =  "AuctionHA";
include "init.php";
if (isset($_SESSION['user'])) {

    $getUser = $con->prepare("SELECT * FROM users WHERE Username =?");
    $getUser->execute(array($sessionUser)); // the variable $sessionUser exsist in init.php file
    $info = $getUser->fetch();
?>
<h1 class="text-center"> My Profile</h1>
<div class="information block">
    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">My information</div>
            <div class="panel-body">
                <ul class="list-unstyled">
                    <li> <i class="fa fa-unlock-alt fa-fw"></i> <span>Name</span> : <?php echo $info['Username']; ?>
                    </li>
                    <li> <i class="fa fa-envelope fa-fw"></i> <span>Email</span>: <?php echo $info['Email']; ?></li>
                    <li> <i class="fa fa-user-alt fa-fw"></i> <span>Full Name</span> : <?php echo $info['FullName']; ?>
                    </li>
                    <li> <i class="fa fa-calendar-alt fa-fw"></i> <span>Date</span> : <?php echo $info['Date']; ?> </li>
                    <li> <i class="fa fa-tags fa-fw"></i> <span>Fav Category</span> : </li>
                </ul>
                <a href="#" class="btn btn-default">Edit information</a>
            </div>
        </div>
    </div>
</div>

<div id="myads" class="myads block">
    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">My Items</div>
            <div class="panel-body">

                <?php
                    if (!empty(getItems('Member_ID', $info['UserID'], 0))) {
                        echo '<div class="row">';
                        foreach (getItems('Member_ID', $info['UserID']) as $item) { // to get  only itmes in this category
                            echo '<div class="col-sm-6 col-md-3">';
                            echo '<div class="thumbnail item-box">';
                            if ($item['Approve'] == 0) {
                                echo '<span class="approve-status">Waiting Approval</span>';
                            }
                            echo '<span class="price-tag">$' . $item['Price'] . '</span>';
                            echo '<img class="img-responsive" src="imgtest.png" alt="">';
                            echo '<div class="caption">';
                            echo '<h3><a href="items.php?itemid=' . $item['Item_ID'] . '">' . $item['Name'] . '</a></h3>';
                            echo '<p>' . $item['Description'] . '</p>';
                            echo '<div class="date">' . $item['Add_Date'] . '</div>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                        }
                        echo '</div>';
                    } else {
                        echo 'There\'s no Ads To show, Create <a href="newad.php">New Ad</a> ';
                    }
                    ?>

            </div>
        </div>
    </div>
</div>

<div class=" my-comments block">
    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">latest Comments</div>
            <div class="panel-body">
                <?php
                    $stmt = $con->prepare("SELECT comment FROM comments WHERE user_id = ?");
                    $stmt->execute(array($info['UserID']));
                    $comments = $stmt->fetchAll();
                    if (!empty($comments)) {
                        foreach ($comments as $comment) {
                            echo '<p>' . $comment['comment']   . '</p>';
                        }
                    } else {
                        echo 'There\'s no Comments To Show';
                    }
                    ?>
            </div>
        </div>
    </div>
</div>

<?php } else {
    header('Location: login.php');
}



include $temp . "footer.php";
ob_end_flush();