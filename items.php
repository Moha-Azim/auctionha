<?php
ob_start();
session_start();
$pageTitle =  "Item Details";
include "init.php";

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
            <img class="img-responsive img-thumbnail center-block" src="imgtest.png" alt="">
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
                    <a href="bidding.php?itemid=<?php echo $itemid ?>" class="btn btn-primary pull-right bidding-btn"
                        role="button">Bidding
                        Page</a>
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

    <!--Start Add Comment-->
    <?php if (isset($_SESSION['user'])) { ?>
    <div class="row">
        <div class="col-md-offset-3">
            <div class="add-comment">
                <h3>Add Your Comment</h3>
                <form action="<?php echo $_SERVER['PHP_SELF'] . '?itemid=' . $item['Item_ID'] ?>" method="POST">
                    <textarea name="comment" required></textarea>
                    <input class="btn btn-primary" type="submit" value="Add Comment">
                </form>
                <?php
                        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                            $comment = filter_var($_POST['comment'], FILTER_SANITIZE_STRING);
                            $userid = $_SESSION['uid'];
                            $itemid = $item['Item_ID'];

                            if (!empty($_POST['comment'])) {
                                $stmt = $con->prepare("INSERT INTO comments(comment,status,comment_date,item_id,user_id) VALUES (:comment, 0,NOW(),:itemid,:userid)");
                                $stmt->execute(array(
                                    ":comment" => $comment,
                                    ":itemid" =>  $itemid,
                                    ":userid" => $userid
                                ));
                            }

                            if ($stmt) {
                                echo '<div class="alert alert-success"> the Comment is Inserted </div>';
                            } else {
                                echo '<div class="alert alert-danger"> No record Inserted</div>';
                            }
                        }
                        ?>
            </div>
        </div>
    </div>
    <?php } else {
            echo '<a href="login.php">Login</a> Or <a href="login.php">Register</a> To Add Comment';
        } ?>
    <!--End Add Comment-->
    <hr class="custom-hr">
    <?php   // All comment from database
        $stmt = $con->prepare("SELECT comments.*,users.* FROM comments INNER JOIN users ON users.UserID = comments.user_id WHERE Status = 1 AND Item_ID = ? ORDER BY c_id DESC");
        $stmt->execute(array($item['Item_ID']));
        $comments = $stmt->fetchAll();
        foreach ($comments as $comment) { ?>
    <div class="comment-box">
        <div class="row">
            <div class="col-sm-2 text-center">

                <img class="img-responsive img-thumbnail img-circle center-block" src="<?php
                                                                                                if (empty($comment['avatar'])) {
                                                                                                    echo "admin/uploaded/avatars/999999999_default.png";
                                                                                                } else {
                                                                                                    echo 'admin/uploaded/avatars/' . $comment['avatar'];
                                                                                                }

                                                                                                ?>" alt="">
                <?php echo $comment['Username']; ?>
            </div>
            <div class="col-sm-10">
                <p class="lead"><?php echo $comment['comment']; ?></p>
                <div class="date"> <?php echo $comment['comment_date']; ?> </div>

            </div>
        </div>
    </div>
    <hr class="custom-hr">

    <?php } ?>
</div>






<?php
} else {
    redirectHome('<div class="alert alert-danger">There is No Item Here Or the Item Need Approval form Admin</div>', 'login.php');
}
include $temp . "footer.php";
ob_end_flush();