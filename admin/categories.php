<?php


ob_start(); // Output Buffering Start

session_start();
$pageTitle = 'Categories';
if (isset($_SESSION['userloged'])) {
    include 'init.php';
    $do = isset($_GET['do']) ? $_GET['do'] : 'manage';



    if ($do == 'manage') {
        // Start Manage Page

        $sort = 'ASC'; // to set default ordering

        $sorting_cats = array('ASC', 'DESC');

        if (isset($_GET['sort']) && in_array($_GET['sort'], $sorting_cats)) {
            $sort  = $_GET['sort'];
        }

        $stmt2 = $con->prepare("SELECT * FROM categories WHERE parent = 0 ORDER BY Ordering $sort");
        $stmt2->execute();
        $cats = $stmt2->fetchAll(); ?>

<h1 class="text-center">Manage Categories</h1>
<div class="container categories">
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-edit"></i> Manage Categories
            <div class="option pull-right"><i class="fa fa-sort"></i> Ordering: [
                <a class="<?php echo $sort == 'ASC' ? 'activate' : ""; // to set the class and turn to red color 
                                    ?>" href="?sort=ASC">Asc</a>
                |
                <a class="<?php echo $sort == 'DESC' ? 'activate' : ""; // to set the class and turn to red color 
                                    ?>" href="?sort=DESC">Desc</a> ]
                <i class="fa fa-eye"></i> View: [
                <span class="activate" data-view="full">Full </span>|
                <span data-view="classic">Classic</span> ]
            </div>
        </div>
        <div class="panel-body">
            <?php
                    foreach ($cats as $catego) {
                        echo "<div class='cat'>";
                        echo "<div class='hidden-bottons'>";
                        echo "<a href='categories.php?do=edit&catid=" . $catego['ID'] . "' class='btn btn-xs btn-primary'><i class='fa fa-edit'></i> Edit</a>";
                        echo "<a href='categories.php?do=delete&catid=" . $catego['ID'] . "' class='confirm btn btn-xs btn-danger'><i class='fa fa-close'></i> Delete</a>";
                        echo "</div>";
                        echo "<h3>" . $catego['Name'] . "</h3>";
                        echo "<div class='full-view'>";
                        echo "<p>";
                        echo $catego['Description'] == '' ? 'There is no Description For this Category' : $catego['Description']; // to check if the Desc is Empty
                        echo "</p>";
                        echo $catego['Visibility'] == '1' ? "<span class='visibility'><i class='fa fa-eye-slash'></i> Hidden Category</span>" : null;
                        echo $catego['Allow_Comment'] == '1' ? "<span class='comments'><i class='fa fa-close'></i> Comment Disabled</span>" : null;
                        echo $catego['Allow_Ads'] == '1' ? "<span class='advertising'><i class='fas fa-ban'></i> Ads Blocked</span>" : null;


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
                        }
                        echo '</div>';
                        echo '</div>';
                        echo '<hr>';
                    }
                    ?>
        </div>
    </div>
    <a href='categories.php?do=add' class='btn btn-primary'><i class='fa fa-plus'></i> Add Category</a>
</div>
<?php
    } elseif ($do == 'add') {
        // Start Add Page 

    ?><h1 class="text-center">Add Categories</h1>
<div class="container">
    <form class="form-horizontal" action="?do=insert" method="POST">

        <!-- Start Name Field -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Categories Name</label>
            <div class="col-sm-10 col-md-6">
                <input type="text" name="name" class="form-control" required="required" placeholder="Add Category Name"
                    autocomplete="off" />
            </div>

        </div>
        <!-- End Name Field -->

        <!-- Start Descroption Field-->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Descroption</label>
            <div class="col-sm-10 col-md-6">
                <input type="text" name="descroption" class="form-control" placeholder="Describe the Category" />
            </div>

        </div>
        <!-- End Descroption Field -->

        <!-- Start Ordering Field -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Ordaring</label>
            <div class="col-sm-10 col-md-6">
                <input type="text" name="ordaring" class="form-control" placeholder="Number to Arrange Categories" />
            </div>

        </div>
        <!-- End Ordering Field -->

        <!-- Start Category  Level -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Category Parent</label>
            <div class="col-sm-10 col-md-6">
                <select name="parent">
                    <option value="0">None</option>
                    <?php
                            $stmt = $con->prepare("SELECT * FROM categories WHERE parent = 0");
                            $stmt->execute();
                            $categories = $stmt->fetchAll();
                            foreach ($categories as $category) {
                                echo '<option value="' . $category['ID'] . '">' . $category["Name"] . '</option>';
                            }
                            ?>
                </select>
            </div>
        </div>
        <!-- End Category  Level -->

        <!-- Start Visiblty Field -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Visible</label>
            <div class="col-sm-10 col-md-6">
                <div>
                    <input id="vis-yes" type="radio" name="visibility" value="0" checked />
                    <label for="vis-yes">Yes</label>
                </div>
                <div>
                    <input id="vis-no" type="radio" name="visibility" value="1" />
                    <label for="vis-no">No</label>
                </div>
            </div>

        </div>
        <!-- End Visiblty Field -->

        <!-- Start Allow_Comments Field -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Allow Comments</label>
            <div class="col-sm-10 col-md-6">
                <div>
                    <input id="com-yes" type="radio" name="commenting" value="0" checked />
                    <label for="com-yes">Yes</label>
                </div>
                <div>
                    <input id="com-no" type="radio" name="commenting" value="1" />
                    <label for="com-no">No</label>
                </div>
            </div>

        </div>
        <!-- End Allow_Comments Field -->

        <!-- Start Allow_Ads Field -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Allow Ads</label>
            <div class="col-sm-10 col-md-6">
                <div>
                    <input id="ads-yes" type="radio" name="ads" value="0" checked />
                    <label for="ads-yes">Yes</label>
                </div>
                <div>
                    <input id="ads-no" type="radio" name="ads" value="1" />
                    <label for="ads-no">No</label>
                </div>
            </div>

        </div>
        <!-- End Allow_Ads Field -->

        <!-- Start Save Field -->
        <div class="form-group form-group-lg">
            <div class="col-sm-offset-2 col-sm-10">
                <input type="submit" value="Add Category" class="btn btn-primary btn-lg" />
            </div>
        </div>
        <!-- End Save Field -->

    </form>
</div>

<?php // End Add Page
    } elseif ($do == 'insert') {
        // Start Insert Page

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            echo '<h1 class="text-center">Insert Category</h1>';
            echo '<div class="container">';


            // get the result from the post method
            $name       = $_POST['name'];
            $desc       = $_POST['descroption'];
            $order      = $_POST['ordaring'];
            $parent     = $_POST['parent'];
            $visible    = $_POST['visibility'];
            $comment    = $_POST['commenting'];
            $ads        = $_POST['ads'];


            // Validate Form




            // Check if the Category Name is already exist using checkItem Function
            $checkCateName = checkItem("Name", "categories",  $name);
            if ($checkCateName > 0) {
                $theMsg = "<div class='alert alert-danger'>The Category Name Is already Used</div>";
                redirectHome($theMsg, 'back', 4);
            } else {
                $stmt = $con->prepare("INSERT INTO categories (Name,Description	,Ordering,parent,Visibility,Allow_Comment,Allow_Ads) VALUES (:name , :desc , :order ,:parent, :visible ,:comment,:ads)");
                $stmt->execute(array(
                    ':name'     => $name,
                    ':desc'     => $desc,
                    ':order'    => $order,
                    ':parent'   => $parent,
                    ':visible'  => $visible,
                    ':comment'  => $comment,
                    ':ads'      => $ads
                ));

                $counter = $stmt->rowCount();
                if ($stmt) {
                    $theMsg = '<div class=" alert alert-success">' . $counter . ' Record Inserted </div>';
                    redirectHome($theMsg, "categories.php", 5);
                }
            }
        } else {
            $theMsg = "<div class='alert alert-danger'> You Can't Reach this Page Direct </div>";
            redirectHome($theMsg, "categories.php", 5);
        }
        echo '</div>';
        //End Inset Page
    } elseif ($do == 'edit') { // Start Edit Page

        if (isset($_GET['catid']) && is_numeric($_GET['catid'])) { // select user based  on  id
            $catid = $_GET['catid'];
            //Select All data depend on this id
            $stmt = $con->prepare("SELECT * FROM categories WHERE ID = ?  ");
            $stmt->execute(array($catid));
            $catego = $stmt->fetch();
            $conter =  $stmt->rowCount();

            if ($conter > 0) // to check if the ID in the link is correct 
            {
        ?>

<h1 class="text-center">Edit Categories</h1>
<div class="container">
    <form class="form-horizontal" action="?do=update" method="POST">

        <!-- Hidden input to send the Category ID -->
        <input name="catid" type="hidden" value="<?php echo $catego['ID'];  ?>">
        <!-- Start Name Field -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Categories Name</label>
            <div class="col-sm-10 col-md-6">
                <input type="text" name="name" class="form-control" required="required" placeholder="Add Category Name"
                    value="<?php echo $catego['Name'];  ?>" />
            </div>

        </div>
        <!-- End Username Field -->

        <!-- Start Descroption Field-->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Descroption</label>
            <div class="col-sm-10 col-md-6">
                <input type="text" name="descroption" class="form-control" placeholder="Describe the Category"
                    value="<?php echo $catego['Description'];  ?>" />
            </div>

        </div>
        <!-- End Descroption Field -->

        <!-- Start Ordering Field -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Ordaring</label>
            <div class="col-sm-10 col-md-6">
                <input type="text" name="ordaring" class="form-control" placeholder="Number to Arrange Categories"
                    value="<?php echo $catego['Ordering']; ?>" />
            </div>

        </div>
        <!-- End Ordering Field -->

        <!-- Start Category  Level -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Category Parent</label>
            <div class="col-sm-10 col-md-6">
                <select name="parent">
                    <option value="0">None (Not a Sub-Category)</option>
                    <?php
                                    $stmt = $con->prepare("SELECT * FROM categories WHERE parent = 0");
                                    $stmt->execute();
                                    $categories = $stmt->fetchAll();
                                    foreach ($categories as $category) {
                                        echo '<option value="' . $category['ID'] . '"';
                                        if ($category['ID'] == $catego['parent']) {
                                            echo 'selected';
                                        }
                                        echo ">" . $category['Name']  . "</option>";
                                    }
                                    ?>
                </select>
            </div>
        </div>
        <!-- End Category  Level -->

        <!-- Start Visiblty Field -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Visible</label>
            <div class="col-sm-10 col-md-6">
                <div>
                    <input id="vis-yes" type="radio" name="visibility" value="0"
                        <?php echo $catego['Visibility'] == "0" ? 'checked' : ""; ?> />
                    <label for="vis-yes">Yes</label>
                </div>
                <div>
                    <input id="vis-no" type="radio" name="visibility" value="1"
                        <?php echo $catego['Visibility'] == "1" ? 'checked' : ""; ?> />
                    <label for="vis-no">No</label>
                </div>
            </div>

        </div>
        <!-- End Visiblty Field -->

        <!-- Start Allow_Comments Field -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Allow Comments</label>
            <div class="col-sm-10 col-md-6">
                <div>
                    <input id="com-yes" type="radio" name="commenting" value="0"
                        <?php echo $catego['Allow_Comment'] == "0" ? 'checked' : ""; ?> />
                    <label for="com-yes">Yes</label>
                </div>
                <div>
                    <input id="com-no" type="radio" name="commenting" value="1"
                        <?php echo $catego['Allow_Comment'] == "1" ? 'checked' : ""; ?> />
                    <label for="com-no">No</label>
                </div>
            </div>

        </div>
        <!-- End Visiblty Field -->

        <!-- Start Allow_Ads Field -->
        <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Allow Ads</label>
            <div class="col-sm-10 col-md-6">

                <div>
                    <input id="ads-yes" type="radio" name="ads" value="0"
                        <?php echo $catego['Allow_Ads'] == "0" ? 'checked' : ""; ?> />
                    <!-- to put check on the same value choosen in database-->

                    <label for="ads-yes">Yes</label>
                </div>
                <div>
                    <input id="ads-no" type="radio" name="ads" value="1"
                        <?php echo $catego['Allow_Ads'] == "1" ? 'checked' : ""; ?> />
                    <!-- to put check on the same value choosen in database-->
                    <label for="ads-no">No</label>
                </div>
            </div>

        </div>
        <!-- End Allow_Ads Field -->

        <!-- Start Save Field -->
        <div class="form-group form-group-lg">
            <div class="col-sm-offset-2 col-sm-10">
                <input type="submit" value="Update Category" class="btn btn-primary btn-lg" />
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
            echo '<h1 class="text-center">Update Category</h1>';
            echo '<div class="container">';


            // get the result from the post method
            $name       = $_POST['name'];
            $desc       = $_POST['descroption'];
            $ordaring   = $_POST['ordaring'];
            $parent     = $_POST['parent'];
            $visibl     = $_POST['visibility'];
            $ads        = $_POST['ads'];
            $comment    = $_POST['commenting'];
            $catid      = $_POST['catid'];



            $stmt = $con->prepare(" UPDATE    
                                        categories 
                                    SET 
                                        name = ? ,
                                        Description= ?,
                                        parent = ?,
                                        Ordering = ? ,
                                        Visibility = ?,
                                        Allow_Ads = ? ,
                                        Allow_Comment = ? 
                                    WHERE 
                                        ID = ? ");
            $stmt->execute(array($name, $desc, $parent, $ordaring, $visibl,  $ads, $comment, $catid));
            $row = $stmt->fetch();
            $counter =  $stmt->rowCount();

            if ($stmt) {
                $theMsg = "<div class='alert alert-success'>$counter Record Updated </div>";
                redirectHome($theMsg, "back", 5);
            }
        } else {
            $theMsg = "<div class='alert alert-danger'> you Can't Reach this page Directly </div>";
            redirectHome($theMsg, "back", 5);
        }
        echo '</div>';
    } elseif ($do == 'delete') { // Start Delete Page

        echo "<h1 class='text-center'>Delete Category</h1>
                <div class='container'>";

        // check if the UserID is correct
        $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;
        $check = checkItem('ID', 'categories', $catid);

        // all above to check if the id in link is correct

        if ($check > 0) {
            $stmt =  $con->prepare("DELETE FROM categories  WHERE ID = :catid");
            $stmt->bindParam(":catid",  $catid);
            $stmt->execute();
            if ($stmt) {
                $theMsg = '<div class=" alert alert-success">' . $check . ' Record Deleted </div>';
                redirectHome($theMsg, "categories.php");
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