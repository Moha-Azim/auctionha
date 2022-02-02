<?php

session_start();
$pageTitle =  "AuctionHA";
include "init.php";

// $path_parts = pathinfo('/www/htdocs/inc/lib.inc.PHP');

// print_r($path_parts);

// echo strtolower($path_parts['extension']);

// echo strtolower(pathinfo('/www/htdocs/inc/lib.inc.PHP')['extension']);

?>

<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"
            aria-selected="true">Home</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile"
            aria-selected="false">Profile</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact"
            aria-selected="false">Contact</a>
    </li>
</ul>
<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade " id="home" role="tabpanel" aria-labelledby="home-tab">
        <ul class="nav navbar-nav navbar-right">
            <?php
            foreach (getCat('WHERE parent = 0') as $categ) {
                echo "<li> <a href='categories.php?catid=" . $categ['ID'] . "&pagename=" . str_replace(' ', '-', $categ['Name']) . "'>" . $categ['Name'] . "</a></li>";
            }
            ?>
        </ul>
    </div>
    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
        <ul class="nav navbar-nav navbar-right">
            <?php
            foreach (getCat('WHERE parent = 0') as $categ) {
                echo "<li> <a href='categories.php?catid=" . $categ['ID'] . "&pagename=" . str_replace(' ', '-', $categ['Name']) . "'>" . $categ['Name'] . "</a></li>";
            }
            ?>
        </ul>
    </div>
    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
        <ul class="nav navbar-nav navbar-right">
            <?php
            foreach (getCat('WHERE parent = 0') as $categ) {
                echo "<li> <a href='categories.php?catid=" . $categ['ID'] . "&pagename=" . str_replace(' ', '-', $categ['Name']) . "'>" . $categ['Name'] . "</a></li>";
            }
            ?>
        </ul>
    </div>
</div>
















<!-- 


<div class="tabbable">
    
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab1" data-toggle="tab">Section 1</a></li>

        <a style="display: inline;" href="zztest.php">
            <li> <a href="#tab2" data-toggle="tab">Section 2</a> </li>
        </a>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="tab1">
            <ul class="nav navbar-nav navbar-right">
           
            
            </ul>
        </div>
        <div class="tab-pane" id="tab2">
            <ul class="nav navbar-nav navbar-right">
                <li>hellow</li>
                <li>hellow</li>
                <li>hellow</li>
            </ul>
        </div>
    </div>
</div> -->
<?php include $temp . "footer.php";
?>