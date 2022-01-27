<?php
ob_start(); // Output Buffering Start

session_start();
$pageTitle = 'Items';
if (isset($_SESSION['userloged'])) {
    include 'init.php';
    $do = isset($_GET['do']) ? $_GET['do'] : 'manage';

    if ($do == 'manage') { // Start Manage Items Page


        $stmt = $con->prepare("SELECT items.* , users.Username,categories.Name AS categoryname FROM items INNER JOIN users ON UserID = Member_ID INNER JOIN categories ON ID = Cat_ID ORDER BY Item_ID DESC");
        $stmt->execute();
        $items = $stmt->fetchAll();

?><h1 class="text-center">Manage Items</h1>
<div class="container">

    <div class="table-responsive">
        <table class="main-table text-center table  table-bordered">
            <tr>
                <td>#ID</td>
                <td>Name</td>
                <td>Description</td>
                <td>Price</td>
                <td>Adding Date</td>
                <td>Category</td>
                <td>Username</td>
                <td>Control</td>
            </tr>

            <?php
                    foreach ($items as $item) {
                        echo "<tr>";
                        echo "<td>" . $item['Item_ID'] . "</td>";
                        echo "<td>" . $item['Name'] . "</td>";
                        echo "<td>" . $item['Description'] . "</td>";
                        echo "<td>$" . $item['Price'] . "</td>";
                        echo "<td>" . $item['Add_Date']  . "</td>";
                        echo "<td>" . $item['categoryname'] . "</td>";
                        echo "<td>" . $item['Username'] . "</td>";
                        echo "<td>";
                        echo '<a href="?do=edit&id=' . $item['Item_ID'] . '" class="btn btn-success"><i class="fa fa-edit"></i> Edit</a>
                            <a href="?do=delete&id=' . $item['Item_ID'] . '" class="btn btn-danger confirm"><i class = "fa fa-close"></i> Delete</a>';
                        if ($item['Approve'] == 0) { // show the Active btn for Pending Members only
                            echo '<a href="items.php?do=approve&id=' . $item['Item_ID'] . '" class="btn btn-info activate"><i class = "far fa-check-circle"></i> Approve</a>';
                        }
                        echo  "</td>";
                        echo "</tr>";
                    }

                    ?>
            </tr>

        </table>
    </div>
    <a class="btn btn-primary" href='items.php?do=add'> <i class="fa fa-plus"></i> Add New Item </a>
</div>



<?php // End Manage Page
    } elseif ($do == 'add') {
        // Start Add Page 

    ?><h1 class="text-center">Add Item</h1>
<div class="container">
    <form class="form-horizontal" action="?do=insert" method="POST">

        <!-- Start Name Field -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Item Name</label>
            <div class="col-sm-10 col-md-6">
                <input type="text" name="name" class="form-control" required="required" placeholder="Add Item Name"
                    autocomplete="off" />
            </div>
        </div>
        <!-- End Name Field -->


        <!-- Start Description Field -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Item Description</label>
            <div class="col-sm-10 col-md-6">
                <input type="text" name="description" class="form-control" required="required"
                    placeholder="Add Description" autocomplete="off" />
            </div>
        </div>
        <!-- End Description Field -->


        <!-- Start Price Field -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Item Price</label>
            <div class="col-sm-10 col-md-6">
                <input type="text" name="price" class="form-control" required="required" placeholder="Add Item Price"
                    autocomplete="off" />
            </div>
        </div>
        <!-- End Price Field -->


        <!-- Start Country Field -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Country Made</label>
            <div class="col-sm-10 col-md-6">
                <input type="text" name="country" class="form-control" required="required"
                    placeholder="Add Item Country" autocomplete="on" />
            </div>
        </div>
        <!-- End Country Field -->

        <!-- Start Category Field -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Category</label>
            <div class="col-sm-10 col-md-6">
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
            <label class="col-sm-2 control-label">Status</label>
            <div class="col-sm-10 col-md-6">
                <select name="status">
                    <option value="0">...</option>
                    <option value="1">New</option>
                    <option value="2">Like New</option>
                    <option value="3">Used</option>
                    <option value="4">Old</option>
                </select>
            </div>
        </div>

        <!-- End Status Field -->

        <!-- Start Members Field -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Members</label>
            <div class="col-sm-10 col-md-6">
                <select name="members">
                    <option value="0">...</option>
                    <?php
                            $stmt = $con->prepare("SELECT * FROM users");
                            $stmt->execute();
                            $users = $stmt->fetchAll();
                            foreach ($users as $user) {
                                echo '<option value="' . $user['UserID'] . '">' . $user["Username"] . '</option>';
                            }
                            ?>
                </select>
            </div>
        </div>
        <!-- End Members Field -->



        <!-- Start Tags Field -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Tags</label>
            <div class="col-sm-10 col-md-6">
                <input type="text" name="tags" class="form-control" placeholder="Separate tags with Comma ( , )" />
            </div>
        </div>
        <!-- End Tags Field -->

        <!-- Start Save Field -->
        <div class="form-group form-group-lg">
            <div class="col-sm-offset-2 col-sm-10">
                <input type="submit" value="+ Add Item" class="btn btn-primary btn-lg" />
            </div>
        </div>
        <!-- End Save Field -->

    </form>
</div>

<?php // End Add Page
    } elseif ($do == 'insert') {

        // Start Insert Page

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            echo '<h1 class="text-center">Insert Item</h1>';
            echo '<div class="container">';


            // get the result from the post method
            $name     = $_POST['name'];
            $desc     = $_POST['description'];
            $price    = $_POST['price'];
            $country  = $_POST['country'];
            $status   = $_POST['status'];
            $members   = $_POST['members'];
            $category = $_POST['category'];
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

            if ($members == "0") {
                $formErrors[] = 'You Must Choos The Member';
            }
            if ($category == "0") {
                $formErrors[] = 'You Must Choos The Category';
            }

            foreach ($formErrors as $errors) {
                echo "<div class='alert alert-danger'>" . $errors . "</div>";
            }

            if (empty($formErrors)) {



                $stmt = $con->prepare("INSERT INTO items (Name,Description,Price,Conutry_Made,Status,Add_Date ,Cat_ID,Member_ID,tags) VALUES (:name , :desc , :price , :country ,:status,now(),:category,:member,:tags)");
                $stmt->execute(array(
                    ':name'     => $name,
                    ':desc'     => $desc,
                    ':price'    => $price,
                    ':country'  => $country,
                    ':status'   => $status,
                    ':category' => $category,
                    ':member'   => $members,
                    ':tags'     => $tags

                ));

                $counter = $stmt->rowCount();
                if ($stmt) {
                    $theMsg = '<div class=" alert alert-success">' . $counter . ' Record Inserted </div>';
                    redirectHome($theMsg, "back", 2);
                }
            }
        } else {
            $theMsg = "<div class='alert alert-danger'> You Can't Reach this Page Direct </div>";
            redirectHome($theMsg, 'items.php');
        }
        echo '</div>';
        //End Inset Page
    } elseif ($do == 'edit') { // Start Edit Page

        if (isset($_GET['id']) && is_numeric($_GET['id'])) { // select user based  on  id
            $itemid = $_GET['id'];
            $stmt = $con->prepare("SELECT * FROM items WHERE Item_ID = ?");
            $stmt->execute(array($itemid));
            $item = $stmt->fetch();
            $conter =  $stmt->rowCount();

            if ($conter > 0) // to check if the ID in the link is correct 
            {
        ?>

<h1 class="text-center">Edit Item</h1>
<div class="container">
    <form class="form-horizontal" action="items.php?do=update" method="POST">
        <input type="hidden" name="item_id" value="<?php echo $item['Item_ID'] ?>">
        <!-- Start Name Field -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Item Name</label>
            <div class="col-sm-10 col-md-6">
                <input type="text" name="name" class="form-control" required="required" placeholder="Add Item Name"
                    autocomplete="off" value=" <?php echo $item['Name'] ?>" />
            </div>
        </div>
        <!-- End Name Field -->


        <!-- Start Description Field -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Item Description</label>
            <div class="col-sm-10 col-md-6">
                <input type="text" name="description" class="form-control" required="required"
                    placeholder="Add Description" autocomplete="off" value=" <?php echo $item['Description'] ?>" />
            </div>
        </div>
        <!-- End Description Field -->


        <!-- Start Price Field -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Item Price</label>
            <div class="col-sm-10 col-md-6">
                <input type="text" name="price" class="form-control" required="required" placeholder="Add Item Price"
                    autocomplete="off" value=" <?php echo $item['Price'] ?>" />
            </div>
        </div>
        <!-- End Price Field -->


        <!-- Start Country Field -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Country Made</label>
            <div class="col-sm-10 col-md-6">
                <input type="text" name="country" class="form-control" required="required"
                    placeholder="Add Item Country" autocomplete="on" value=" <?php echo $item['Conutry_Made'] ?>" />
            </div>
        </div>
        <!-- End Country Field -->

        <!-- Start Category Field -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Category</label>
            <div class="col-sm-10 col-md-6">
                <select name="category" required>
                    <?php
                                    $stmt = $con->prepare("SELECT * FROM categories");
                                    $stmt->execute();
                                    $categories = $stmt->fetchAll();
                                    foreach ($categories as $category) {


                                        echo '<option value="' . $category['ID'] . '"';
                                        if ($item['Cat_ID'] == $category['ID']) {  // to choose the selected value in the database
                                            echo 'selected';
                                        }
                                        echo '>' . $category["Name"] . '</option>';
                                    }

                                    ?>
                </select>
            </div>
        </div>
        <!-- End Category Field -->

        <!-- Start Status Field -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Status</label>
            <div class="col-sm-10 col-md-6">
                <select name="status">
                    <option value="<?php if ($item['Status'] == 1) {   // to choose the selected value in the database
                                                        echo 'selected';
                                                    } ?>">New</option>
                    <option value="<?php if ($item['Status'] == 2) {
                                                        echo 'selected';
                                                    } ?>">Like New</option>
                    <option value="<?php if ($item['Status'] == 3) {
                                                        echo 'selected';
                                                    } ?>">Used</option>
                    <option value="<?php if ($item['Status'] == 4) {
                                                        echo 'selected';
                                                    } ?>">Old</option>
                </select>
            </div>
        </div>

        <!-- End Status Field -->

        <!-- Start Members Field -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Members</label>
            <div class="col-sm-10 col-md-6">
                <select name="members">
                    <?php
                                    $stmt = $con->prepare("SELECT * FROM users");
                                    $stmt->execute();
                                    $users = $stmt->fetchAll();
                                    foreach ($users as $user) {
                                        echo '<option value="' . $user['UserID'] . '"';
                                        if ($item['Member_ID'] == $user['UserID']) {  // to choose the selected value in the database
                                            echo 'selected';
                                        }
                                        echo '>' . $user["Username"] . '</option>';
                                    }
                                    ?>
                </select>
            </div>
        </div>
        <!-- End Members Field -->


        <!-- Start Tags Field -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Tags</label>
            <div class="col-sm-10 col-md-6">
                <input type="text" name="tags" class="form-control" placeholder="Separate tags with Comma ( , )"
                    value="<?php echo $item['tags'] ?>" />
            </div>
        </div>
        <!-- End Tags Field -->

        <!-- Start Save Field -->
        <div class="form-group form-group-lg">
            <div class="col-sm-offset-2 col-sm-10">
                <input type="submit" value="Update Item" class="btn btn-primary btn-lg" />
            </div>
        </div>
        <!-- End Save Field -->

    </form>
    <?php
                    $stmt = $con->prepare("SELECT comments.*,users.Username AS member FROM comments INNER JOIN users ON users.UserID = comments.user_id WHERE item_id = ?");
                    $stmt->execute(array($itemid));
                    $rows = $stmt->fetchAll();


                    if (!empty($rows)) {
                    ?><h1 class="text-center">Manage [<?php echo $item['Name'] ?>] Comments</h1>


    <div class="table-responsive">
        <table class="main-table text-center table  table-bordered">
            <tr>
                <td>Comment</td>
                <td>Username</td>
                <td>Added Date</td>
                <td>Control</td>
            </tr>

            <?php
                                foreach ($rows as $row) {
                                    echo "<tr>";
                                    echo "<td>" . $row['comment'] . "</td>";
                                    echo "<td>" . $row['member'] . "</td>";
                                    // Registerd Date
                                    echo "<td>" . $row['comment_date']  . "</td>";
                                    echo "<td>";
                                    echo '<a href="comments.php?do=edit&id=' . $row['c_id'] . '" class="btn btn-success"><i class="fa fa-edit"></i> Edit</a>
                            <a href="comments.php?do=delete&id=' . $row['c_id'] . '" class="btn btn-danger confirm"><i class = "fa fa-close"></i> Delete</a>';

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
    <?php } ?>
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
            echo '<h1 class="text-center">Update Items</h1>';
            echo '<div class="container">';


            // get the result from the post method
            $name     = $_POST['name'];
            $desc     = $_POST['description'];
            $price    = $_POST['price'];
            $country  = $_POST['country'];
            $status   = $_POST['status'];
            $members  = $_POST['members'];
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

            if ($members == "0") {
                $formErrors[] = 'You Must Choos The Member';
            }
            if ($category == "0") {
                $formErrors[] = 'You Must Choos The Category';
            }

            foreach ($formErrors as $errors) {
                echo "<div class='alert alert-danger'>" . $errors . "</div>";
            }

            if (empty($formErrors)) {
                $stmt = $con->prepare("UPDATE items SET Name = ? , Description = ?, Price = ? , Conutry_Made = ?,Status =? ,Cat_ID=?,Member_ID=? , tags=? WHERE Item_ID = ? ");
                $stmt->execute(array($name, $desc, $price, $country,  $status, $category, $members, $tags, $item_id));
                $row = $stmt->fetch();
                $counter =  $stmt->rowCount();
                if ($stmt) {
                    $theMsg = "<div class='alert alert-success'>$counter Record Updated </div>";
                    redirectHome($theMsg, "back", 5);
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
            $theMsg = '<div class=" alert alert-danger"> No Record Deleted </div>';
            redirectHome($theMsg, "members.php");
        }
        echo "</div>";
    } elseif ($do == 'delete') { // Start Delete Page

        echo "<h1 class='text-center'>Delete Item</h1>
                <div class='container'>";

        // check if the UserID is correct
        $item_id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
        $check = checkItem('Item_ID', 'items',  $item_id);

        // all above to check if the id in link is correct

        if ($check > 0) {
            $stmt =  $con->prepare("DELETE FROM items WHERE Item_ID = :itemid ");
            $stmt->bindParam(":itemid",  $item_id);
            $stmt->execute();
            if ($stmt) {
                $theMsg = '<div class=" alert alert-success">' . $check . ' Record Deleted </div>';
                redirectHome($theMsg, "items.php");
            }
        } else {
            $theMsg = '<div class=" alert alert-danger"> No Record Deleted </div>';
            redirectHome($theMsg, "items.php");
        }
        echo "</div>";
    } elseif ($do == 'approve') {
        // Start Approve Page
        echo "<h1 class='text-center'>Approve Items</h1>
                <div class='container'>";

        // check if the UserID is correct
        $item_id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
        $check = checkItem('Item_ID', 'items',  $item_id);

        // all above to check if the id in link is correct

        if ($check > 0) {
            $stmt =  $con->prepare("UPDATE  items SET Approve = 1 WHERE Item_ID = ?");
            $stmt->execute(array($item_id));
            if ($stmt) {
                $theMsg = '<div class=" alert alert-success">' . $check . ' Record Approved </div>';
                redirectHome($theMsg, "items.php");
            }
        } else {
            $theMsg = '<div class=" alert alert-danger"> No Record Approved </div>';
            redirectHome($theMsg, "items.php");
        }
        echo "</div>";
    }

    include $temp . "footer.php";
} else {
    header('Location:index.php');
    exit();
}
ob_end_flush(); // Release The Output