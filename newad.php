<?php
ob_start();
session_start();
$pageTitle =  "Creat Item";
include "init.php";
if (isset($_SESSION['user'])) {

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // to Check if the user account is approved yet 
        $reg = $con->prepare('SELECT RegStatus FROM users WHERE UserID = ?');
        $reg->execute(array($_SESSION['uid']));
        $regStatus = $reg->fetch();


        $avatarName = $_FILES['avatar']['name'];
        $avatarType = $_FILES['avatar']['type'];
        $avatarTmp  = $_FILES['avatar']['tmp_name'];
        $avatarSize = $_FILES['avatar']['size'];

        // extract the extension and make it to lower case  and ignore the waring if  there is no image
        @$extention = strtolower(pathinfo($avatarName)['extension']);


        //List Of Allowed File Typed To Upload
        $avatarExtension = array("jpeg", "jpg", "png", "gif");


        $name       = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
        $desc       = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
        $price      = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_INT);
        $endDate    = date("Y-m-d H:i:s", strtotime($_POST["endbid"]));
        $country    = filter_var($_POST['country'], FILTER_SANITIZE_STRING);
        $category   = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
        $status     = filter_var($_POST['status'], FILTER_SANITIZE_NUMBER_INT);
        $tags       = filter_var($_POST['tags'], FILTER_SANITIZE_STRING);



        $formErrors = array();


        if (strlen($name) < 4) {
            $formErrors[] = 'The Item Name Can\'t be Less Than 4 Characters';
        }
        if (strlen($desc) < 8) {
            $formErrors[] = 'The Item description Can\'t be Less Than 8 Characters';
        }
        if (empty($price)) {
            $formErrors[] = 'The Item price Can\'t be Empty';
        }
        if (empty($country)) {
            $formErrors[] = 'The Item country Can\'t be Empty';
        }
        if (empty($category)) {
            $formErrors[] = 'You Have to choose a Category';
        }
        if (empty($status)) {
            $formErrors[] = 'You Have to choose a Status';
        }
        if (empty($avatarName)) {
            $formErrors[] = 'You have to choose an Image';
        }
        if (!in_array($extention, $avatarExtension) && !empty($avatarName)) {
            $formErrors[] = 'The Image Extension Not Allowed You can upload image "jpeg", "jpg", "png", "gif" Only';
        }
        if (@$avatarSize > 4194304) {
            $formErrors[] = 'The Image Can\'t be larger than 4MB';
        }
        // to check the end bid date more than 24 hour from now
        if ((strtotime($_POST["endbid"]) - strtotime(date("Y-m-d H:i:s"))) < 86400) {
            $formErrors[] = 'End Bid should be at least after 24 hours';
        }
        if ($regStatus['RegStatus'] == 0) {  // to Check if the user account is approved yet 
            $formErrors[] = 'Your account need admin approved';
        }


        if (empty($formErrors)) {

            $avatar = rand(0, 9999999999999) . "_" . $avatarName;
            move_uploaded_file($avatarTmp, "admin\uploaded\itemsImg\\" . $avatar);

            $stmta = $con->prepare("INSERT INTO items (Name,Description,Price,Conutry_Made,Status,Add_Date,end_biddingDate ,Cat_ID,Member_ID,tags,mainImg) VALUES (:name , :desc , :price , :country ,:status,now(),:end_biddingDate,:category,:member,:tags,:mainImg)");
            $stmta->execute(array(
                ':name'             => $name,
                ':desc'             => $desc,
                ':price'            => $price,
                ':country'          => $country,
                ':status'           => $status,
                ':end_biddingDate'  => $endDate,
                ':category'         => $category,
                ':member'           => $_SESSION['uid'],
                ':tags'             => $tags,
                ':mainImg'          => $avatar
            ));
        }
    }


?>
<h1 class="text-center">Creat New Item</h1>
<div class="information block">
    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">Creat New Item</div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-8">
                        <form class="form-horizontal main-form" action="<?php echo $_SERVER['PHP_SELF'] ?> "
                            enctype="multipart/form-data" method="POST">

                            <!-- Start Name Field -->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-3 control-label">Item Name</label>
                                <div class="col-sm-10 col-md-9">
                                    <input type="text" name="name" class="form-control live" data-class=".live-title"
                                        placeholder="Add Item Name" autocomplete="off" required />
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
                                        autocomplete="off" required />
                                </div>
                            </div>
                            <!-- End Description Field -->


                            <!-- Start Price Field -->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-3 control-label">Item Price</label>
                                <div class="col-sm-10 col-md-9">
                                    <input type="text" name="price" class="form-control live" data-class=".live-price"
                                        placeholder="Add Item Price" autocomplete="off" required />
                                </div>
                            </div>
                            <!-- End Price Field -->


                            <!-- Start Country Field -->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-3 control-label">Country Made</label>
                                <div class="col-sm-10 col-md-9">
                                    <input type="text" name="country" class="form-control"
                                        placeholder="Add Item Country" autocomplete="on" required />
                                </div>
                            </div>
                            <!-- End Country Field -->

                            <!-- Start Category Field -->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-3 control-label">Category</label>
                                <div class="col-sm-10 col-md-9">
                                    <select name="category">
                                        <option value="0">...</option>
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
                                    <select name="status" required>
                                        <option value="">...</option>
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
                                        placeholder="Separate tags with Comma ( , )" />
                                </div>
                            </div>
                            <!-- End Tags Field -->

                            <!-- Start Avatar Field -->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-3 control-label">Item Image</label>
                                <div class="col-sm-10 col-md-9">
                                    <input type="file" name="avatar" class="form-control" required />
                                </div>
                            </div>
                            <!-- End Avatar Field -->

                            <!--Start endBid Field -->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-3 control-label">End bid Date</label>
                                <div class="col-sm-10 col-md-9">
                                    <input type="datetime-local" name="endbid" class="form-control" placeholder=""
                                        autocomplete="on" required />
                                </div>
                            </div>
                            <!-- End endBid Field -->

                            <!-- Start Save Field -->
                            <div class="form-group form-group-lg">
                                <div class="col-sm-offset-3 col-sm-9">
                                    <input type="submit" value="+ Add Item" class="btn btn-primary btn-lg" />
                                </div>
                            </div>
                            <!-- End Save Field -->
                        </form>
                    </div>

                    <div class="col-md-4">
                        <div class="thumbnail item-box live-preview">
                            <span class="price-tag">$<span class="live-price">0</span></span>
                            <img class="img-responsive" src="admin/uploaded/itemsImg/999999999_default.png" alt="">
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



<?php } else {
    header('Location: login.php');
}

include $temp . "footer.php";
ob_end_flush();