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
            if (isset($_SESSION['user'])) {

                $header_stmt = $con->prepare('SELECT * FROM users WHERE UserID = ?');
                $header_stmt->execute(array($_SESSION['uid']));
                $user_info =  $header_stmt->fetch();

            ?>
            <img class="my-image image-thumbnail img-circle " src="<?php
                                                                        if (empty($user_info['avatar'])) {
                                                                            echo "admin/uploaded/avatars/999999999_default.png";
                                                                        } else {
                                                                            echo "admin/uploaded/avatars/" . $user_info['avatar'];
                                                                        }
                                                                        ?>" alt="">
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

                    // to put $grayActive class if the user press on one of the main category and color it to gray
                    foreach (getCat('WHERE parent = 0') as $categ) {
                        if (isset($_GET['catid']) &&  $_GET['catid'] == $categ['ID']) {
                            $grayActive = "gray-active";
                        } else {
                            $grayActive = null;
                        }
                        echo "<li class='$grayActive'> <a href='categories.php?catid=" . $categ['ID'] . "&pagename=" . str_replace(' ', '-', $categ['Name']) . "'>" . $categ['Name'] . "</a></li> ";
                    }
                    ?>
                </ul>
            </div>

    </nav>






    <?php

    // to select the sub-categories if the parent have sub category
    if (isset($_GET['catid'])) {
        $stmt = $con->prepare("SELECT * FROM categories WHERE parent ={$_GET['catid']}");
        $stmt->execute();
        $childCats = $stmt->fetchAll();
        if (!empty($childCats)) {
            echo  "<div class='container'><ul class='nav nav-pills  justify-content-center sub-cate' >";
            foreach ($childCats as $childcat) {
                echo "<li class='nav-item'>";
                echo "<a class='nav-link' href='categories.php?catid=" . $childcat["ID"] . "&pagename=" . $childcat["Name"] . "'>" . $childcat["Name"] . " </a>";
                echo "</li>";
            }
            echo "</ul>
    </div>";
        }
    }
    ?>





    <!-- 
    // to select the sub-categories
                        $stmt = $con->prepare("SELECT * FROM categories WHERE parent ={$catego['ID']}");
                        $stmt->execute();
                        $childCats = $stmt->fetchAll();
                        if (!empty($childCats)) {
                            echo "<h4 class='child-head'>Child Categories :</h4>";
                            echo  "<ul class='list-unstyled  child-cats'>";
                            foreach ($childCats as $childcat) {
                                echo "<li class='child-link'> 
                                <a href='categories.php?do=edit&catid=" . $childcat['ID'] . "' > " . $childcat['Name'] . "</a>
                                <a href='categories.php?do=delete&catid=" . $childcat['ID'] . "' class='show-delete confirm '><i class='fa fa-close'></i> Delete</a>
                                </li>";
                            }
                            echo  "</ul>";
                        } -->