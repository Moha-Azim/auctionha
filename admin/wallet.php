<?php
ob_start(); // Output Buffering Start
session_start();


if (isset($_SESSION['userloged'])) {
    $pageTitle =  "Wallet";
    include 'init.php';


    $do = isset($_GET['do']) ? $_GET['do'] : 'manage';

    $stmtu = $con->prepare("SELECT * FROM users WHERE UserID = ?");
    $stmtu->execute(array($_GET['id']));
    $userInfo = $stmtu->fetch();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // adming Check
        $username = $_POST['user'];
        $password = $_POST['password'];
        $hashedPass = sha1($password);



        $stmt = $con->prepare("SELECT UserID, Username , Password FROM users WHERE Username = ? AND Password = ? AND GroupID = 1 ");
        $stmt->execute(array($username, $hashedPass));
        $row = $stmt->fetch();
        $conter =  $stmt->rowCount();
        if ($conter > 0) {

            // wallet insert
            $mony     = $_POST['amount'];
            $admin_id = $row['UserID'];
            $user     = $userInfo['UserID'];

            $monyadd = $con->prepare("INSERT INTO wallet_add (mony_added, Date, admin_id, user) VALUES (:mony , now(), :admin_id , :user)");
            $monyadd->execute(array(
                ':mony'     => $mony,
                ':admin_id' => $admin_id,
                ':user'     => $user
            ));

            $counter = $monyadd->rowCount();
            if ($monyadd) {
                // update wallet field if the mony add done
                $update = $con->prepare("UPDATE users SET wallet = wallet + {$mony} WHERE UserID = {$user}");
                $update->execute();

                $theMsg = '<div class=" alert alert-success">' . $counter . ' Record Inserted </div>';
                redirectHome($theMsg, "back", 3);
            }
        } else {
            // if the username or the password uncorrect will logout
            header('Location: logout.php');
        }
    }


?>

<h1 class="text-center"><?php echo $userInfo['Username'] ?></h1>
<div class="container">
    <form class="form-horizontal" action="wallet.php?id=<?php echo $userInfo['UserID'] ?>" method="POST">
        <!-- Start Username Field -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Admin Username</label>
            <div class="col-sm-10 col-md-6">
                <input type="text" name="user" class="form-control" required="required" autocomplete="off" />
            </div>

        </div>
        <!-- End Username Field -->

        <!-- Start Password Field -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Admin Password</label>
            <div class="col-sm-10 col-md-6">
                <input type="password" name="password" class="password form-control" required="required" />
                <i class="show-pass fa fa-eye fa-1x"></i>
            </div>

        </div>
        <!-- End Password Field -->

        <!-- Start Email Field -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">The Amount</label>
            <div class="col-sm-10 col-md-6">
                <input type="text" name="amount" class="form-control" required="required" />
            </div>

        </div>
        <!-- End Email Field -->

        <!-- Start Save Field -->
        <div class="form-group form-group-lg">
            <div class="col-sm-offset-2 col-sm-10">
                <input type="submit" value="Save" class="btn btn-success btn-lg" />
            </div>
        </div>
        <!-- End Save Field -->

    </form>
</div>
</div>

<?php
    include $temp . "footer.php";
} else {
    header('Location:index.php');
    exit();
}

ob_end_flush(); // Release The Output