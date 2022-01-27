<?php
ob_start();
session_start();


if (isset($_SESSION['userloged'])) {
    $pageTitle =  "Dashboard";
    include 'init.php';
    // <!--Start Dashboard Page -->


    $userLimit = 5; // to put a limit 
    $theLatestusers = getLatest('*', 'users', 'UserID', $userLimit); // use getLatest Function from function.php file

    $ItemsLimit = 5; // to put a limit 
    $theLatestItems = getLatest('*', 'items', 'Item_ID', $ItemsLimit); // use getLatest Function from function.php file

    $CommentLimit = 5;
?>


<div class="home-stats">
    <div class="container text-center">
        <h1>Dashboard</h1>
        <div class="row">
            <div class="col-md-3">
                <div class="stat st-members">
                    <i class="fa fa-users"></i>
                    <div class="info">
                        Total Members
                        <span>
                            <a href="members.php">
                                <?php
                                    echo checkItem('GroupID', 'users', 0) // to count how many member in the website 
                                    ?>
                            </a>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat st-pending">
                    <i class="fa fa-user-plus"></i>
                    <div class="info">
                        Pending Members
                        <span><a href="members.php?do=manage&page=pending">
                                <?php
                                    echo checkItem('RegStatus', 'users', 0) // to count how many member in the website 
                                    ?></a></span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat st-items">
                    <i class="fa fa-tag"></i>
                    <div class="info">
                        Total Items
                        <span><a href="items.php?do=manage">
                                <?php
                                    echo checkItem('Item_ID', 'items') // to count how many Item in the website 
                                    ?></a></span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat st-comments">
                    <i class="fa fa-comments"></i>
                    <div class="info">
                        Total Comments
                        <span><a href="comments.php?do=manage">
                                <?php
                                    echo checkItem('c_id', 'comments') // to count how many comments in the website 
                                    ?></a></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="latest">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-users"></i> Latest <?php echo $userLimit ?> Registerd Users
                        <span class="toggle-info pull-right">
                            <i class="fa fa-minus fa-lg"></i>
                        </span>
                    </div>
                    <div class="panel-body">
                        <ul class="list-unstyled latest-users">
                            <?php
                                foreach ($theLatestusers as $userby) {
                                    echo "<li>" . $userby['Username'] .
                                        "<a href='members.php?do=edit&id=" . $userby['UserID'] . "'> <span class='btn btn-success  pull-right'>";
                                    echo "<i class='fa fa-edit'></i>Edit</span></a>";
                                    if ($userby['RegStatus'] == 0) { // show the Active btn for Pending Members only
                                        echo '<a href="members.php?do=activate&id=' . $userby['UserID'] . '"> <span class="btn btn-info pull-right activate"><i class = "far fa-check-circle"></i> Active </span></a>';
                                    }
                                    echo "</li>";
                                }
                                ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-tag"></i> Latest <?php echo $ItemsLimit ?> Items Added
                        <span class="toggle-info pull-right">
                            <i class="fa fa-minus fa-lg"></i>
                        </span>
                    </div>
                    <div class="panel-body">
                        <ul class="list-unstyled latest-users">
                            <?php
                                foreach ($theLatestItems as $ItemBy) {
                                    echo "<li>" . $ItemBy['Name'] .
                                        "<a href='items.php?do=edit&id=" . $ItemBy['Item_ID'] . "'> <span class='btn btn-success  pull-right'>";
                                    echo "<i class='fa fa-edit'></i>Edit</span></a>";
                                    if ($ItemBy['Approve'] == 0) { // show the Active btn for Pending Members only
                                        echo '<a href="items.php?do=approve&id=' . $ItemBy['Item_ID'] . '"> <span class="btn btn-info pull-right activate"><i class = "far fa-check-circle"></i> Approve </span></a>';
                                    }
                                    echo "</li>";
                                }
                                ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!--Start Latest Comment-->
        <div class="row">
            <div class="col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-comments"></i> Latest <?php echo  $CommentLimit ?> Comments
                        <span class="toggle-info pull-right">
                            <i class="fa fa-minus fa-lg"></i>
                        </span>
                    </div>
                    <div class="panel-body">
                        <?php
                            $stmt = $con->prepare("SELECT comments.*,users.Username AS member FROM comments INNER JOIN users ON users.UserID = comments.user_id ORDER BY c_id DESC LIMIT $CommentLimit");
                            $stmt->execute();
                            $comments = $stmt->fetchAll();
                            foreach ($comments as $comment) {
                                echo '<div class="comment-box">';
                                echo '<span class="member-n">' . $comment['member'] . '</span>';
                                echo '<p class="member-c">' . $comment['comment'] . '</p>';
                                echo '</div>';
                            }
                            ?>
                    </div>
                </div>
            </div>
        </div>
        <!--End Latest Comment-->

    </div>
</div>

<!--End Dashboard Page -->
<?php

    include $temp . "footer.php";
} else {
    header('Location: index.php');
    exit();
};
ob_end_flush();