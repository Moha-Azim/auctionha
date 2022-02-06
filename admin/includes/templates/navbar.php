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
            <a class="navbar-brand" href="dashboard.php"><?php echo lang('HOME_ADMIN') ?></a>
        </div>


        <div class="collapse navbar-collapse" id="app-nav" aria-expanded="false" style="height: 1px;">
            <ul class="nav navbar-nav">
                <li><a href="categories.php"><?php echo lang("CATEGORIES") ?><span class="sr-only">(current)</span></a>
                </li>
                <li><a href="items.php"><?php echo lang("ITEMS") ?><span class="sr-only">(current)</span></a></li>
                <li><a href="members.php"><?php echo lang("MEMBERS") ?><span class="sr-only">(current)</span></a></li>
                <li><a href="comments.php"><?php echo lang("COMMENTS") ?><span class="sr-only">(current)</span></a></li>
                <li><a href="adminManage.php">Admins</a>
                </li>
                </li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">

                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                        aria-expanded="false"><?php echo $_SESSION['userloged'] ?> <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="../index.php">Visit Shop</a>
                        </li>
                        <li><a
                                href="members.php?do=edit&id=<?php echo $_SESSION['userID'] ?>"><?php echo lang("EDIT_PROFILE") ?></a>
                        </li>
                        <li><a href="#"><?php echo lang("SETTING") ?></a></li>

                        <li role="separator" class="divider"></li>
                        <li><a href="logout.php"><?php echo lang("LOG_OUT") ?></a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>