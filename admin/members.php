<?php
ob_start(); // Output Buffering Start
session_start();


if (isset($_SESSION['userloged'])) {
    $pageTitle =  "Members";
    include 'init.php';


    $do = isset($_GET['do']) ? $_GET['do'] : 'manage';

    if ($do == 'manage') { // Start Manage Members Page

        $query = "";
        if (isset($_GET['page']) && $_GET['page'] == 'pending') {
            $query = "AND RegStatus = 0";
        }
        $stmt = $con->prepare("SELECT * FROM users WHERE GroupID != 1 $query");
        $stmt->execute();
        $rows = $stmt->fetchAll();

?><h1 class="text-center">Manage Members</h1>
<div class="container">

    <div class="table-responsive">
        <table class="main-table text-center table  table-bordered">
            <tr>
                <td>#ID</td>
                <td>Username</td>
                <td>Email</td>
                <td>Full Name</td>
                <td>Registerd Date</td>
                <td>Control</td>
            </tr>

            <?php
                    foreach ($rows as $row) {
                        echo "<tr>";
                        echo "<td>" . $row['UserID'] . "</td>";
                        echo "<td>" . $row['Username'] . "</td>";
                        echo "<td>" . $row['Email'] . "</td>";
                        echo "<td>" . $row['FullName'] . "</td>";
                        // Registerd Date
                        echo "<td>" . $row['Date']  . "</td>";
                        echo "<td>";
                        echo '<a href="?do=edit&id=' . $row['UserID'] . '" class="btn btn-success"><i class="fa fa-edit"></i> Edit</a>
                            <a href="?do=delete&id=' . $row['UserID'] . '" class="btn btn-danger confirm"><i class = "fa fa-close"></i> Delete</a>';

                        if ($row['RegStatus'] == 0) { // show the Active btn for Pending Members only
                            echo '<a href="?do=activate&id=' . $row['UserID'] . '" class="btn btn-info activate"><i class = "far fa-check-circle"></i> Active</a>';
                        }
                        echo  "</td>";
                        echo "</tr>";
                    }

                    ?>
            </tr>

        </table>
    </div>
    <a class="btn btn-primary" href='?do=add'> <i class="fa fa-plus"></i> Add New Member </a>
</div>



<?php // End Manage Page
    } elseif ($do == 'add') {

        // Start Add Page 
    ?><h1 class="text-center">Add Member</h1>
<div class="container">
    <form class="form-horizontal" action="?do=insert" method="POST" enctype="multipart/form-data">

        <!-- Start Username Field -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Username</label>
            <div class="col-sm-10 col-md-6">
                <input type="text" name="username" class="form-control" required="required" autocomplete="off" />
            </div>

        </div>
        <!-- End Username Field -->

        <!-- Start Password Field -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Password</label>
            <div class="col-sm-10 col-md-6">
                <input type="password" name="password" class="password form-control"
                    placeholder="Password must be hard & complex" required="required" />
                <i class="show-pass fa fa-eye fa-1x"></i>
            </div>

        </div>
        <!-- End Password Field -->

        <!-- Start Email Field -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Email</label>
            <div class="col-sm-10 col-md-6">
                <input type="email" name="email" class="form-control" required="required" />
            </div>

        </div>
        <!-- End Email Field -->

        <!-- Start Full Name Field -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Full Name </label>
            <div class="col-sm-10 col-md-6">
                <input type="text" name="full" class="form-control" required="required" />
            </div>

        </div>
        <!-- End Full Name Field -->

        <!-- Start Avatar Field -->

        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">User Avatar </label>
            <div class="col-sm-10 col-md-6">
                <input type="file" name="avatar" class="form-control" required="required" />
            </div>
        </div>
        <!-- End Avatar Field -->

        <!-- Start Save Field -->
        <div class="form-group form-group-lg">
            <div class="col-sm-offset-2 col-sm-10">
                <input type="submit" value="Add Member" class="btn btn-primary btn-lg" />
            </div>
        </div>
        <!-- End Save Field -->




    </form>
</div>

<?php // End Add Page
    } elseif ($do == 'insert') {

        // Start Insert Page

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            echo '<h1 class="text-center">Insert Member</h1>';
            echo '<div class="container">';


            // get the result from the post method
            $username = $_POST['username'];
            $email    = $_POST['email'];
            $fullname = $_POST['full'];
            $pass   = $_POST['password'];

            // Password  hash
            $hashPass = sha1($_POST['password']);
            // Validate Form

            $formErrors = array();




            if (strlen($username) > 20) {
                $formErrors[] = 'The username Can\'t be More than 20 characters';
            }

            if (strlen($username) < 4 && strlen($username) != 0) {
                $formErrors[] = 'The username Can\'t be Less than 4 characters';
            }

            if (empty($username)) {
                $formErrors[] = 'The username Can\'t be Empty ';
            }

            if (empty($email)) {
                $formErrors[] = 'The Email Can\'t be Empty ';
            }

            if (empty($fullname)) {
                $formErrors[] = 'The Full Name Can\'t be Empty ';
            }

            if (empty($pass)) {
                $formErrors[] = 'The Password Can\'t be Empty ';
            }

            if (strlen($pass) < 8 && strlen($pass) != 0) {
                $formErrors[] = 'The Password Can\'t be Less than 8 digits';
            }

            foreach ($formErrors as $errors) {
                echo "<div class='alert alert-danger'>" . $errors . "</div>";
            }

            if (empty($formErrors)) {

                // Check if the username is already exist using checkItem Function
                $checkUsername = checkItem("Username", "users", $username);
                if ($checkUsername > 0) {
                    $theMsg = "<div class='alert alert-danger'>The username Is already Exist</div>";
                    redirectHome($theMsg, 'back', 4);
                } else {
                    $stmt = $con->prepare("INSERT INTO users (Username,Password,Email,FullName,RegStatus,Date) VALUES (:user , :pass , :email , :fname ,1,now())");
                    $stmt->execute(array(
                        ':user'     => $username,
                        ':pass'     => $hashPass,
                        ':email'    => $email,
                        ':fname'    => $fullname
                    ));

                    $counter = $stmt->rowCount();
                    if ($stmt) {
                        $theMsg = '<div class=" alert alert-success">' . $counter . ' Record Inserted </div>';
                        redirectHome($theMsg, "members.php", 2);
                    }
                }
            }
        } else {
            $theMsg = "<div class='alert alert-danger'> You Can't Reach this Page Direct </div>";
            redirectHome($theMsg, "back", 5);
        }
        echo '</div>';
        //End Inset Page
    } elseif ($do == 'edit') { // Start Edit Page

        if (isset($_GET['id']) && is_numeric($_GET['id'])) { // select user based  on  id
            $user_id = $_GET['id'];
            $stmt = $con->prepare("SELECT * FROM users WHERE UserID = ?  LIMIT  1 ");
            $stmt->execute(array($user_id));
            $row = $stmt->fetch();
            $conter =  $stmt->rowCount();

            if ($conter > 0) // to check if the ID in the link is correct 
            {
        ?>

<h1 class="text-center">Edit Member</h1>
<div class="container">
    <form class="form-horizontal" action="members.php?do=update" method="POST">
        <input type="hidden" name="userid" value='<?php echo $user_id; ?>' /> <!-- send the user id -->
        <!-- Start Username Field -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Username</label>
            <div class="col-sm-10 col-md-6">
                <input type="text" name="username" class="form-control" required="required"
                    value="<?php echo $row['Username'] ?>" autocomplete="off" />
            </div>

        </div>
        <!-- End Username Field -->

        <!-- Start Password Field -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Password</label>
            <div class="col-sm-10 col-md-6">
                <input type="hidden" name="oldpassword" value="<?php echo $row['Password'] ?>" />
                <input type="password" name="newpassword" class="password form-control" autocomplete="new-password"
                    placeholder="Leave it Blank to keep the same Password" />
                <i class="show-pass fa fa-eye fa-1x"></i>
            </div>

        </div>
        <!-- End Password Field -->

        <!-- Start Email Field -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Email</label>
            <div class="col-sm-10 col-md-6">
                <input type="email" name="email" class="form-control" required="required"
                    value="<?php echo $row['Email'] ?>" />
            </div>

        </div>
        <!-- End Email Field -->

        <!-- Start Full Name Field -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Full Name </label>
            <div class="col-sm-10 col-md-6">
                <input type="text" name="full" class="form-control" required="required"
                    value="<?php echo $row['FullName'] ?>" />
            </div>

        </div>
        <!-- End Full Name Field -->

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
            echo '<h1 class="text-center">Update Member</h1>';
            echo '<div class="container">';


            // get the result from the post method
            $username = $_POST['username'];
            $email    = $_POST['email'];
            $fullname = $_POST['full'];
            $userid   = $_POST['userid'];
            // Password  Trick
            $pass = empty($_POST['newpassword']) ? $_POST['oldpassword'] : sha1($_POST['newpassword']);
            // Validate Form

            $formErrors = array();

            if (strlen($username) > 20) {
                $formErrors[] = 'The username Can\'t be More than 20 characters';
            }

            if (strlen($username) < 4 && strlen($username) != 0) {
                $formErrors[] = 'The username Can\'t be Less than 4 characters';
            }

            if (empty($username)) {
                $formErrors[] = 'The username Can\'t be Empty ';
            }

            if (empty($email)) {
                $formErrors[] = 'The Email Can\'t be Empty ';
            }

            if (empty($fullname)) {
                $formErrors[] = 'The Full Name Can\'t be Empty ';
            }

            if (empty($pass)) {
                $formErrors[] = 'The Password Can\'t be Empty ';
            }

            foreach ($formErrors as $errors) {
                echo "<div class='alert alert-danger'> $errors </div>";
            }


            if (empty($formErrors)) {

                // Check if the username is already exist
                $stmtCheck = $con->prepare("SELECT UserID,Username FROM users WHERE UserID != ? AND Username = ?");
                $stmtCheck->execute(array($userid, $username));
                $counter1 = $stmtCheck->rowCount();
                if ($counter1 == 0) {

                    $stmt = $con->prepare("UPDATE users SET Username = ? , Password = ?, Email = ? , FullName = ? WHERE UserID = ? ");
                    $stmt->execute(array($username, $pass, $email, $fullname,  $userid));
                    $row = $stmt->fetch();
                    $counter =  $stmt->rowCount();
                    if ($stmt) {
                        $theMsg = "<div class='alert alert-success'>$counter Record Updated </div>";
                        redirectHome($theMsg, "back", 5);
                    }
                } else {
                    $theMsg = "<div class='alert alert-danger'>The username Is already Exist</div>";
                    redirectHome($theMsg, 'back', 4);
                }
            }
        } else {
            $theMsg = "<div class='alert alert-danger'> you Can't Reach this page Directly </div>";
            redirectHome($theMsg, "back", 5);
        }
        echo '</div>';
    } elseif ($do == 'activate') { // Start Active Page

        echo "<h1 class='text-center'>Active Member</h1>
                <div class='container'>";

        // check if the UserID is correct
        $user_id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
        $check = checkItem('UserID', 'users',  $user_id);

        // all above to check if the id in link is correct

        if ($check > 0) {
            $stmt =  $con->prepare("UPDATE  users SET Regstatus = 1 WHERE UserID = ?");
            $stmt->execute(array($user_id));
            if ($stmt) {
                $theMsg = '<div class=" alert alert-success">' . $check . ' Record Activated </div>';
                redirectHome($theMsg, "members.php");
            }
        } else {
            $theMsg = '<div class=" alert alert-danger"> No Record Activated </div>';
            redirectHome($theMsg, "members.php");
        }
        echo "</div>";
    } elseif ($do == 'delete') { // Start Delete Page

        echo "<h1 class='text-center'>Delete Member</h1>
                <div class='container'>";

        // check if the UserID is correct
        $user_id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
        $check = checkItem('UserID', 'users',  $user_id);

        // all above to check if the id in link is correct

        if ($check > 0) {
            $stmt =  $con->prepare("DELETE FROM users WHERE UserID = :userid AND GroupID != 1");
            $stmt->bindParam(":userid",  $user_id);
            $stmt->execute();
            if ($stmt) {
                $theMsg = '<div class=" alert alert-success">' . $check . ' Record Deleted </div>';
                redirectHome($theMsg, "members.php");
            }
        } else {
            $theMsg = '<div class=" alert alert-danger"> No Record Deleted </div>';
            redirectHome($theMsg, "members.php");
        }
        echo "</div>";
    }

    include $temp . "footer.php";
} else {
    header('Location:index.php');
    exit();
}

ob_end_flush(); // Release The Output