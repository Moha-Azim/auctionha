<?php

/*
===================================
== Manage Commments Page
== You Can Edit | Delete | Aproove Comments From Here
===================================


*/

ob_start(); // Output Buffering Start
session_start();


if (isset($_SESSION['userloged'])) {
    $pageTitle =  "Comments";
    include 'init.php';


    $do = isset($_GET['do']) ? $_GET['do'] : 'manage';

    if ($do == 'manage') { // Start Manage Members Page

        $stmt = $con->prepare("SELECT comments.*,users.Username AS member ,items.Name as item_name FROM comments
        INNER JOIN users ON users.UserID = comments.user_id 
        INNER JOIN items ON items.Item_ID = comments.item_id
        ORDER BY c_id DESC
        ");
        $stmt->execute();
        $rows = $stmt->fetchAll();

?><h1 class="text-center">Manage Comments</h1>
<div class="container">

    <div class="table-responsive">
        <table class="main-table text-center table  table-bordered">
            <tr>
                <td>ID</td>
                <td>Comment</td>
                <td>Item Name</td>
                <td>Username</td>
                <td>Added Date</td>
                <td>Control</td>
            </tr>

            <?php
                    foreach ($rows as $row) {
                        echo "<tr>";
                        echo "<td>" . $row['c_id'] . "</td>";
                        echo "<td>" . $row['comment'] . "</td>";
                        echo "<td>" . $row['item_name'] . "</td>";
                        echo "<td>" . $row['member'] . "</td>";
                        // Registerd Date
                        echo "<td>" . $row['comment_date']  . "</td>";
                        echo "<td>";
                        echo '<a href="?do=edit&id=' . $row['c_id'] . '" class="btn btn-success"><i class="fa fa-edit"></i> Edit</a>
                            <a href="?do=delete&id=' . $row['c_id'] . '" class="btn btn-danger confirm"><i class = "fa fa-close"></i> Delete</a>';

                        if ($row['status'] == 0) { // show the Active btn for Pending Members only
                            echo '<a href="?do=approve&id=' . $row['c_id'] . '" class="btn btn-info activate"><i class = "far fa-check-circle"></i> Approve</a>';
                        }
                        echo  "</td>";
                        echo "</tr>";
                    }

                    ?>
            </tr>

        </table>
    </div>

</div>



<?php // End Manage Page
    } elseif ($do == 'edit') { // Start Edit Page

        if (isset($_GET['id']) && is_numeric($_GET['id'])) { // select user based  on  id
            $comid = $_GET['id'];
            $stmt = $con->prepare("SELECT * FROM comments WHERE c_id = ?");
            $stmt->execute(array($comid));
            $row = $stmt->fetch();
            $conter =  $stmt->rowCount();

            if ($conter > 0) // to check if the ID in the link is correct 
            {
        ?>

<h1 class="text-center">Edit Comment</h1>
<div class="container">
    <form class="form-horizontal" action="?do=update" method="POST">
        <input type="hidden" name="comid" value='<?php echo $comid; ?>' /> <!-- send the user id -->
        <!-- Start Comment Field -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Comment</label>
            <div class="col-sm-10 col-md-6">
                <textarea class="form-control" name="comment"> <?php echo $row['comment'] ?></textarea>
            </div>

        </div>
        <!-- End Comment Field -->



        <!-- Start Save Field -->
        <div class="form-group form-group-lg">
            <div class="col-sm-offset-2 col-sm-10">
                <input type="submit" value="Save" class="btn btn-primary btn-lg" />
            </div>
        </div>
        <!-- End Save Field -->


    </form>
</div>

<?php
            } else {
                echo "<div class='container'>";
                $theMsg = "<div class='alert alert-danger'>no Such ID </div>";
                redirectHome($theMsg, 'back');
                echo "</div>";
            }
        } else {
            echo "<div class='container'>";
            $theMsg = "<div class='alert alert-danger'>no Such ID </div>";
            redirectHome($theMsg, 'back');
            echo "</div>";
        }
    } elseif ($do == 'update') { // Start Update Page

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            echo '<h1 class="text-center">Update Comment</h1>';
            echo '<div class="container">';


            // get the result from the post method
            $comid   = $_POST['comid'];
            $comment = $_POST['comment'];



            $stmt = $con->prepare("UPDATE comments SET comment = ?  WHERE c_id = ? ");
            $stmt->execute(array($comment, $comid));
            $row = $stmt->fetch();
            $counter =  $stmt->rowCount();
            if ($stmt) {
                $theMsg = "<div class='alert alert-success'>$counter Record Updated </div>";
                redirectHome($theMsg, "back", 5);
            }
        } else {
            $theMsg = "<div class='alert alert-danger'> you Can't Reach this page Directly </div>";
            redirectHome($theMsg, "back", 5);
        }
        echo '</div>';
    } elseif ($do == 'approve') { // Start Approve Page

        echo "<h1 class='text-center'>Approve Comment</h1>
                <div class='container'>";

        // check if the UserID is correct
        $comid = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
        $check = checkItem('c_id', 'comments',  $comid);

        // all above to check if the id in link is correct

        if ($check > 0) {
            $stmt =  $con->prepare("UPDATE  comments SET status = 1 WHERE c_id = ?");
            $stmt->execute(array($comid));
            if ($stmt) {
                $theMsg = '<div class=" alert alert-success">' . $check . ' Record Approved </div>';
                redirectHome($theMsg, "comments.php");
            }
        } else {
            $theMsg = '<div class=" alert alert-danger"> No Record Approved </div>';
            redirectHome($theMsg, "comments.php");
        }
        echo "</div>";
    } elseif ($do == 'delete') { // Start Delete comment

        echo "<h1 class='text-center'>Delete Comment</h1>
                <div class='container'>";

        // check if the UserID is correct
        $comid = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
        $check = checkItem('c_id', 'comments',  $comid);

        // all above to check if the id in link is correct

        if ($check > 0) {
            $stmt =  $con->prepare("DELETE FROM comments WHERE c_id = :comid");
            $stmt->bindParam(":comid",  $comid);
            $stmt->execute();
            if ($stmt) {
                $theMsg = '<div class=" alert alert-success">' . $check . ' Record Deleted </div>';
                redirectHome($theMsg, "comments.php");
            }
        } else {
            $theMsg = '<div class=" alert alert-danger"> No Record Deleted </div>';
            redirectHome($theMsg, "comments.php");
        }
        echo "</div>";
    }

    include $temp . "footer.php";
} else {
    header('Location:index.php');
    exit();
}

ob_end_flush(); // Release The Output