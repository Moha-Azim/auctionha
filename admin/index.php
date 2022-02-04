<?php
ob_start();
session_start();

if (isset($_SESSION['userloged'])) {
    header('Location: dashboard.php');
}


$noNavbar = ""; // To prevent the  include
$pageTitle = "Login";
include "init.php";


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $username = $_POST['user'];
    $password = $_POST['password'];
    $hashedPass = sha1($password);

    $stmt = $con->prepare("SELECT UserID, Username , Password FROM users WHERE Username = ? AND Password = ? AND GroupID = 1 LIMIT  1 ");
    $stmt->execute(array($username, $hashedPass));
    $row = $stmt->fetch();
    $conter =  $stmt->rowCount();
    if ($conter > 0) {
        $_SESSION['userloged'] = $username;
        $_SESSION['userID'] = $row['UserID'];
        header('Location: dashboard.php');
        exit();
    } else {
        header('Location: index.php?msg=failed');
    }
}

?>

<form class="login" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    <h3 class="text-center">Admin Login</h3>
    <?php if (isset($_GET["msg"]) && $_GET["msg"] == 'failed') {
        echo "<p class='text-danger text-center'>The username or password is incorrect</p>";
    } ?>
    <input class="form-control input-lg" type="text" name='user' placeholder="Username" autocomplete="off">
    <input class="form-control input-lg" type="password" name='password' placeholder="Password" autocomplete="off">
    <input class="btn btn-lg btn-primary btn-block " type="submit" value="Login">
</form>


<?php include $temp . "footer.php";
ob_end_flush();
?>