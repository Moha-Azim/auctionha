<?php
ob_start();
session_start();
$pageTitle =  "Creat Item";
include "init.php";
if (isset($_SESSION['user'])) {

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $formErrors = array();

        $name       = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
        $desc       = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
        $price      = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_INT);
        $country    = filter_var($_POST['country'], FILTER_SANITIZE_STRING);
        $category   = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
        $status     = filter_var($_POST['status'], FILTER_SANITIZE_NUMBER_INT);
        $tags       = filter_var($_POST['tags'], FILTER_SANITIZE_STRING);
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


        if (empty($formErrors)) {

            $stmta = $con->prepare("INSERT INTO items (Name,Description,Price,Conutry_Made,Status,Add_Date ,Cat_ID,Member_ID,tags) VALUES (:name , :desc , :price , :country ,:status,now(),:category,:member,:tags)");
            $stmta->execute(array(
                ':name'     => $name,
                ':desc'     => $desc,
                ':price'    => $price,
                ':country'  => $country,
                ':status'   => $status,
                ':category' => $category,
                ':member'   => $_SESSION['uid'],
                ':tags'     => $tags
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
                            method="POST">

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
                            <img class="img-responsive" src="imgtest.png" alt="">
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