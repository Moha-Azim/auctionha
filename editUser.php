<?php
ob_start();
session_start();
$pageTitle =  "Edit";
include "init.php";
if (isset($_SESSION['user'])) {

    $edit = isset($_GET['edit']) ? $_GET['edit'] : 'profile';

    // start profile edite
    if ($edit == 'profile') {
        $getUser = $con->prepare("SELECT * FROM users WHERE Username =?");
        $getUser->execute(array($sessionUser)); // the variable $sessionUser exsist in init.php file
        $info = $getUser->fetch();

        // fetch all item for this user by betItems function in the fuction.php file i put it here to count the ads this user was make by ==> count($userItems)
        $userItems = getItems('Member_ID', $info['UserID']);


        //updating

        ////////////////////////////////////++++++

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {


            // Upload Variables if the user won't edit the avatar 
            if (empty($_FILES['avatar']['name'])) {
                $samePic = $info['avatar'];
            }

            $avatarName = $_FILES['avatar']['name'];
            $avatarType = $_FILES['avatar']['type'];
            $avatarTmp  = $_FILES['avatar']['tmp_name'];
            $avatarSize = $_FILES['avatar']['size'];

            // extract the extension and make it to lower case  and ignore the waring if  there is no image
            @$extention = strtolower(pathinfo($avatarName)['extension']);


            //List Of Allowed File Typed To Upload
            $avatarExtension = array("jpeg", "jpg", "png", "gif");


            // get the result from the post method
            $email    = $_POST['email'];
            $fullname = $_POST['full'];
            // Password  trick
            $pass = empty($_POST['newpassword']) ? $_POST['oldpassword'] : sha1($_POST['newpassword']);


            // Validate Form
            $formErrors = array();

            if (empty($email)) {
                $formErrors[] = 'The Email Can\'t be Empty ';
            }

            if (empty($fullname)) {
                $formErrors[] = 'The Full Name Can\'t be Empty ';
            }

            if (empty($_POST['newpassword']) && empty($_POST['oldpassword'])) {
                $formErrors[] = 'The Password Can\'t be Empty ';
            }

            if (strlen($_POST['newpassword']) < 8 && strlen($_POST['newpassword']) != 0) {
                $formErrors[] = 'The Password Can\'t be Less than 8 digits';
            }

            if (!in_array($extention, $avatarExtension) && !empty($avatarName)) {
                $formErrors[] = 'The Image Extension Not Allowed You can upload image "jpeg", "jpg", "png", "gif" Only';
            }

            if (@$avatarSize > 4194304) {
                $formErrors[] = 'The Image Can\'t be larger than 4MB';
            }



            if (empty($formErrors)) {

                $avatar = rand(0, 9999999999999) . "_" . $avatarName;
                move_uploaded_file($avatarTmp, "admin\uploaded\avatars\\" . $avatar);
                if (isset($samePic)) {
                    $avatar = $samePic; // if the user want the same pic (do not want to change the pic)
                }

                $stmt = $con->prepare("UPDATE users SET Password = ?, Email = ? , FullName = ? , avatar = ? WHERE UserID = ? ");
                $stmt->execute(array($pass, $email, $fullname, $avatar, $_SESSION['uid']));
                $row = $stmt->fetch();
                $counter =  $stmt->rowCount();
                if ($stmt) {
                    header('Location:editUser.php?edit=profile');
                }
            } else {
                echo "<div class='container'>";
                foreach ($formErrors as $errors) {
                    echo "<div class='alert alert-danger'>" . $errors . "</div>";
                }
                echo "</div>";
            }
        }


        ///////////////////////////////////////++++

?>
<h1 class="text-center">Edit Profile
</h1>
<div class="information block">
    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">Edit Profile</div>
            <div class="panel-body">

                <div class="row">
                    <div class="col-sm-3">
                        <img class="img-responsive img-thumbnail center-block" src="<?php
                                                                                            if (empty($info['avatar'])) {
                                                                                                echo "admin/uploaded/avatars/999999999_default.png";
                                                                                            } else {
                                                                                                echo "admin/uploaded/avatars/" . $info['avatar'];
                                                                                            }
                                                                                            ?>" alt="">
                        <?php if (!empty($info['avatar'])) {
                                    echo '<a href="editUser.php?edit=delimg" class="btn btn-danger confirm"><i class="fa fa-close"></i> Delete image</a>';
                                }
                                ?>
                    </div>
                    <div class=" col-sm-9">
                        <form class="form-horizontal edit-userss" action="editUser.php?edit=profile"
                            enctype="multipart/form-data" method="POST">
                            <input type="hidden" name="userid" value='<?php echo $user_id; ?>' />
                            <!-- send the user id -->

                            <!-- Start Password Field -->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">Password</label>
                                <div class="col-sm-10 col-md-6 showthe-pass">
                                    <input type="hidden" name="oldpassword" value="<?php echo $info['Password'] ?>" />
                                    <input type="password" name="newpassword" class="password form-control"
                                        autocomplete="new-password"
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
                                        value="<?php echo $info['Email'] ?>" />
                                </div>

                            </div>
                            <!-- End Email Field -->

                            <!-- Start Full Name Field -->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">Full Name </label>
                                <div class="col-sm-10 col-md-6">
                                    <input type="text" name="full" class="form-control" required="required"
                                        value="<?php echo $info['FullName'] ?>" />
                                </div>

                            </div>
                            <!-- End Full Name Field -->

                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">User Avatar </label>
                                <div class="col-sm-10 col-md-6">
                                    <input type="file" name="avatar" class="form-control" />
                                </div>
                            </div>
                            <!-- End Avatar Field -->

                            <!-- Start Save Field -->
                            <div class="form-group form-group-lg">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <input type="submit" value="Save" class="btn btn-primary btn-lg" />
                                </div>
                            </div>
                            <!-- End Save Field -->
                        </form>
                    </div>
                </div>



            </div>
        </div>
    </div>
</div>





<?php

    } elseif ($edit == "delimg") {      //  Start Delete img (Avatar)

        $stmt = $con->prepare("UPDATE users SET avatar = ? WHERE UserID = ? ");
        $stmt->execute(array("", $_SESSION['uid']));
        $row = $stmt->fetch();
        $counter =  $stmt->rowCount();
        header('Location:editUser.php?edit=profile');



        // start Items edite
    } elseif ($edit == 'items') {

        $stmt = $con->prepare("SELECT * FROM items WHERE Item_ID = ? ");
        $stmt->execute(array($_GET['itemid']));
        $row = $stmt->fetch();

        if ($row['Approve'] == 0  && $row['Member_ID'] == $_SESSION['uid']) {

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                echo '<div class="container">';

                $getUser = $con->prepare("SELECT mainImg FROM items WHERE Item_ID =?");
                $getUser->execute(array($_POST['item_id']));
                $info = $getUser->fetch();

                // Upload Variables if the user won't edit the avatar 
                if (empty($_FILES['avatar']['name'])) {
                    $samePic = $info['mainImg'];
                }

                $avatarName = $_FILES['avatar']['name'];
                $avatarType = $_FILES['avatar']['type'];
                $avatarTmp  = $_FILES['avatar']['tmp_name'];
                $avatarSize = $_FILES['avatar']['size'];

                // extract the extension and make it to lower case  and ignore the waring if  there is no image
                @$extention = strtolower(pathinfo($avatarName)['extension']);


                //List Of Allowed File Typed To Upload
                $avatarExtension = array("jpeg", "jpg", "png", "gif");


                // get the result from the post method
                $name     = $_POST['name'];
                $desc     = $_POST['description'];
                $price    = $_POST['price'];
                $country  = $_POST['country'];
                $status   = $_POST['status'];
                $category = $_POST['category'];
                $item_id  = $_POST['item_id'];
                $tags     = $_POST['tags'];

                // Validate Form

                $formErrors = array();

                if (empty($name)) {
                    $formErrors[] = 'The name Can\'t be Empty ';
                }

                if (empty($desc)) {
                    $formErrors[] = 'The description Can\'t be Empty ';
                }

                if (empty($price)) {
                    $formErrors[] = 'The price Can\'t be Empty ';
                }

                if (empty($country)) {
                    $formErrors[] = 'The country Can\'t be Empty ';
                }

                if ($status == "0") {
                    $formErrors[] = 'You Must Choos The Status';
                }

                if ($category == "0") {
                    $formErrors[] = 'You Must Choos The Category';
                }

                if (!in_array($extention, $avatarExtension) && !empty($avatarName)) {
                    $formErrors[] = 'The Image Extension Not Allowed You can upload image "jpeg", "jpg", "png", "gif" Only';
                }

                if (@$avatarSize > 4194304) {
                    $formErrors[] = 'The Image Can\'t be larger than 4MB';
                }

                if (empty($formErrors)) {

                    $avatar = rand(0, 9999999999999) . "_" . $avatarName;
                    move_uploaded_file($avatarTmp, "admin\uploaded\itemsImg\\" . $avatar);
                    if (isset($samePic)) {
                        $avatar = $samePic; // if the user want the same pic (do not want to change the pic)
                    }

                    $stmt = $con->prepare("UPDATE items SET Name = ? , Description = ?, Price = ? , Conutry_Made = ?,Status =? ,Cat_ID=?, tags=?,mainImg=? WHERE Item_ID = ? ");
                    $stmt->execute(array($name, $desc, $price, $country,  $status, $category,  $tags, $avatar, $item_id));
                    $row = $stmt->fetch();
                    $counter =  $stmt->rowCount();
                    if ($stmt) {
                        $theMsg = "<div class='alert alert-success'>$counter Record Updated </div>";
                        redirectHome($theMsg, "back", 0);
                    }
                }
            }

        ?>

<h1 class="text-center">Edit Item</h1>
<div class="information block">
    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">Edit Item</div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-8">
                        <form class="form-horizontal main-form" enctype="multipart/form-data"
                            action="editUser.php?edit=items&itemid=<?php echo $_GET['itemid'] ?> " method="POST">

                            <input type="hidden" name="item_id" value="<?php echo $_GET['itemid'] ?>">
                            <!-- Start Name Field -->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-3 control-label">Item Name</label>
                                <div class="col-sm-10 col-md-9">
                                    <input type="text" name="name" class="form-control live" data-class=".live-title"
                                        placeholder="Add Item Name" autocomplete="off"
                                        value="<?php echo $row['Name']; ?>" required />
                                </div>
                            </div>
                            <!-- End Name Field -->


                            <!-- Start Description Field -->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-3 control-label">Item Description</label>
                                <div class="col-sm-10 col-md-9">
                                    <input type="text" pattern=".{10,}"
                                        title="This Field Require at least 10 characters " name="description"
                                        class="form-control live" data-class=".live-desc" placeholder="Add Description"
                                        autocomplete="off" value="<?php echo $row['Description']; ?>" required />
                                </div>
                            </div>
                            <!-- End Description Field -->


                            <!-- Start Price Field -->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-3 control-label">Item Price</label>
                                <div class="col-sm-10 col-md-9">
                                    <input type="text" name="price" class="form-control live" data-class=".live-price"
                                        placeholder="Add Item Price" autocomplete="off"
                                        value="<?php echo $row['Price']; ?>" required />
                                </div>
                            </div>
                            <!-- End Price Field -->


                            <!-- Start Country Field -->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-3 control-label">Country Made</label>
                                <div class="col-sm-10 col-md-9">
                                    <input type="text" name="country" class="form-control"
                                        placeholder="Add Item Country" autocomplete="on"
                                        value="<?php echo $row['Conutry_Made']; ?>" required />
                                </div>
                            </div>
                            <!-- End Country Field -->

                            <!-- Start Category Field -->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-3 control-label">Category</label>
                                <div class="col-sm-10 col-md-9">
                                    <select name="category" value="<?php echo $row['Cat_ID']; ?>">
                                        <?php
                                                    $stmt = $con->prepare("SELECT * FROM categories WHERE parent = 0");
                                                    $stmt->execute();
                                                    $categories = $stmt->fetchAll();

                                                    foreach ($categories as $category) {
                                                        echo '<option value="' . $category['ID'] . '">' . $category["Name"];
                                                        $stmt = $con->prepare("SELECT * FROM categories WHERE parent ={$category['ID']}");
                                                        $stmt->execute();
                                                        $childCats = $stmt->fetchAll();
                                                        foreach ($childCats as $childcat) {
                                                            echo "<option value='" . $childcat["ID"] . "' > --" . $childcat['Name'] . "</option>";
                                                        }
                                                        echo '</option>';
                                                    }
                                                    ?>
                                    </select>
                                </div>
                            </div>
                            <!-- End Category Field -->

                            <!-- Start Status Field -->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-3 control-label">Status</label>
                                <div class="col-sm-10 col-md-9">
                                    <select name="status" value="<?php echo $row['Status']; ?>" required>
                                        <option value="1">New</option>
                                        <option value="2">Like New</option>
                                        <option value="3">Used</option>
                                        <option value="4">Old</option>
                                    </select>
                                </div>
                            </div>
                            <!-- End Status Field -->

                            <!-- Start Tags Field -->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-3 control-label">Tags</label>
                                <div class="col-sm-10 col-md-9">
                                    <input type="text" name="tags" class="form-control"
                                        placeholder="Separate tags with Comma ( , )"
                                        value="<?php echo $row['tags']; ?>" />
                                </div>
                            </div>
                            <!-- End Tags Field -->

                            <!-- Start Avatar Field -->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-3 control-label">Item Image</label>
                                <div class="col-sm-10 col-md-9">
                                    <input type="file" name="avatar" class="form-control" />
                                </div>
                            </div>
                            <!-- End Avatar Field -->

                            <!-- Start Save Field -->
                            <div class="form-group form-group-lg">
                                <div class="col-sm-offset-3 col-sm-9">
                                    <input type="submit" value="Update Item" class="btn btn-primary btn-lg" />
                                </div>
                            </div>
                            <!-- End Save Field -->
                        </form>
                    </div>

                    <div class="col-md-4">
                        <div class="thumbnail item-box live-preview">
                            <span class="price-tag">$<span class="live-price">0</span></span>
                            <img class="img-responsive" src="<?php
                                                                            if (empty($row['mainImg'])) {
                                                                                echo "admin/uploaded/itemsImg/999999999_default.png";
                                                                            } else {
                                                                                echo "admin/uploaded/itemsImg/" . $row['mainImg'];
                                                                            }
                                                                            ?>" alt="">
                            <div class="caption">
                                <h3 class="live-title">Test</h3>
                                <p class="live-desc">desc teste</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Start Looping Error Array-->
                <?php
                            if (!empty($formErrors)) {
                                foreach ($formErrors as $error) {
                                    echo '<div class="alert alert-danger">' . $error . '</div>';
                                }
                            }

                            if (@$stmta) {
                                echo '<div class="alert alert-success">Item Inserted</div>';
                            }
                            ?>
                <!--End Looping Error Array-->
            </div>
        </div>
    </div>
</div>

<?php
        } else {
            header('Location: login.php');
        }
    }
} else {
    header('Location: login.php');
}

include $temp . "footer.php";
ob_end_flush();