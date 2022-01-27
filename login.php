<?php
ob_start();

session_start();
$pageTitle = "Login";
if (isset($_SESSION['user'])) {
    header('Location: index.php');
}
include "init.php";



if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['login'])) { //  i put a login name for the button if each form the login and singup to realize the difference between them 
        $user = $_POST['username'];
        $pass = $_POST['password'];
        $hashPass = sha1($pass);

        $stmt = $con->prepare("SELECT UserID,Username , Password FROM users WHERE Username = ? AND Password = ?");
        $stmt->execute(array($user, $hashPass));
        $get = $stmt->fetch();
        $conter =  $stmt->rowCount();
        if ($conter > 0) {
            $_SESSION['uid'] = $get['UserID']; // to use this session in newad.php  page when user add the Ads put the session value in member_id in database And Use it in adding comment in items.php page
            $_SESSION['user'] = $user;
            header('Location: index.php');
            exit();
        }
    } else { // sing up page code (will to the else code if user press on singup  case i put value in the button singup ==> value='singup')//
        $formErrors = array();
        if (isset($_POST['username'])) {
            $filterdUser = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
            if (strlen($filterdUser) < 4) {
                $formErrors[] = 'Username Must be More than 4 Characters';
            }
        }
        if (isset($_POST['email'])) {
            $filterdEmail = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            if (filter_var($filterdEmail, FILTER_VALIDATE_EMAIL) != true) {

                $formErrors[] = 'This Email Is Not Valid';
            }
        }
        if (isset($_POST['password']) && isset($_POST['password2'])) {
            if (strlen($_POST['password']) < 8) {
                $formErrors[] = 'The Password Can\'t be Less than 8 digits';
            }
            $pass1 = sha1($_POST['password']);
            $pass2 = sha1($_POST['password2']);
            if ($pass1 !== $pass2) {
                $formErrors[] = 'Sorry Passwords Is Not Match';
            }
        }

        if (empty($formErrors)) {

            // Check if the username is already exist using checkItem Function
            $checkUsername = checkItem("Username", "users", $_POST['username']);
            if ($checkUsername > 0) {
                $formErrors[] = "The username Is already Exist";
            } else {
                $stmt = $con->prepare("INSERT INTO users (Username,Email,Password,RegStatus,Date) VALUES (:user , :email, :pass ,0,now())");
                $stmt->execute(array(
                    ':user'     =>  $_POST['username'],
                    ':email'    => $_POST['email'],
                    ':pass'     => sha1($_POST['password'])
                ));

                $counter = $stmt->rowCount();
                $theMsg = '<div class=" alert alert-success">  Now You are member with Us:) </div>';
            }
        }
    }
}
?>

<div class="container login-page">
    <h1 class="text-center"><span class="z selected" data-class="login">Login </span>|<span data-class="signup">
            Signup</span>
    </h1>
    <!--Start Login Form-->
    <form class="login" action="<?php echo $_SERVER['PHP_SELF']; ?>" method='POST'>
        <div class=" input-container">
            <input class="form-control" type="text" name="username" autocomplete="off" placeholder="Username" required>
        </div>
        <div class="input-container">
            <input class="form-control" type="password" name="password" autocomplete="new-password"
                placeholder="Password" required>
        </div>
        <input class="btn btn-primary btn-block" type="submit" name="login" value="Login">
    </form>
    <!--End Login Form-->


    <!--Start Signup Form-->
    <form class="signup" action="<?php echo $_SERVER['PHP_SELF']; ?>" method='POST'>
        <div class="input-container">
            <input pattern=".{5,}" title="UserName Must Be More than 4 Chars" class="form-control" type="text"
                name="username" autocomplete="off" placeholder="Username" required>
        </div>
        <div class="input-container">
            <input class="form-control" type="email" name="email" placeholder="Email" required>
        </div>
        <div class="input-container">
            <input minlength="8" class="form-control" type="password" name="password" autocomplete="new-password"
                placeholder="Type complex Password" required>
        </div>
        <div class="input-container">
            <input minlength="8" class="form-control" type="password" name="password2" autocomplete="new-password"
                placeholder="Confirm Password" required>
        </div>
        <input class="btn btn-success btn-block" type="submit" name="singup" value="Signup">
    </form>
    <!--End Signup Form-->

    <div class="the-errors text-center">
        <?php
        if (!empty($formErrors)) {
            foreach ($formErrors as $error) {
                echo "<div class='the-errors'><div class='msg error'>" . $error . "</div></div>";
            }
        }

        if (isset($theMsg)) {
            echo $theMsg;
        }
        ?>
    </div>

</div>


<?php include $temp . "footer.php";
ob_end_flush();
?>