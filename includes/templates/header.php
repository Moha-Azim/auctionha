<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo $css ?>bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $css ?>all.min.css">
    <link rel="stylesheet" href="<?php echo $css ?>jquery-ui.css">
    <link rel="stylesheet" href="<?php echo $css ?>jquery.selectBoxIt.css">
    <link rel="stylesheet" href="<?php echo $css ?>front.css">

    <title><?php echo getTitle(); ?></title>
</head>

<body>

    <div class="upper-bar">
        <div class="container">
            <?php
            if (isset($_SESSION['user'])) { ?>
            <img class="my-image image-thumbnail img-circle " src="imgtest.png" alt="">
            <div class="btn-group my-info">

                <span class="btn dropdown-toggle" data-toggle="dropdown">
                    <?php echo $sessionUser; ?>
                    <span class="caret"></span>
                </span>
                <ul class="dropdown-menu">
                    <li><a href="porfile.php"><i class="far fa-address-card"></i> My Profile</a> </li>
                    <li><a href="newad.php"><i class="fas fa-cart-plus"></i> New Item</a> </li>
                    <li><a href="porfile.php#myads"><i class="fas fa-box-open"></i> My Items</a> </li>
                    <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a> </li>
                </ul>
            </div>

            <?php
                $regStatus = checkUserStatus($sessionUser);
                if ($regStatus == 1) {
                    echo 'Your Member Ship neet to Activate By Admin';
                }
            } else {
                ?>
            <a href="login.php">
                <span class="pull-right">Login/Signup</span>
            </a>
            <?php } ?>
        </div>
    </div>
    <nav class="navbar navbar-inverse">
        <div class="container">

            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav"
                    aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Homepage</a>
            </div>


            <div class="collapse navbar-collapse" id="app-nav" aria-expanded="false" style="height: 1px;">
                <ul class="nav navbar-nav navbar-right">
                    <?php
                    foreach (getCat('WHERE parent = 0') as $categ) {
                        echo "<li> <a href='categories.php?catid=" . $categ['ID'] . "&pagename=" . str_replace(' ', '-', $categ['Name']) . "'>" . $categ['Name'] . "</a></li>";
                    }
                    ?>
                </ul>
            </div>
        </div>
    </nav>