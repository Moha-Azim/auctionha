<?php

function lang($phrase)
{
    static $lang = array(

        // Navbar
        "HOME_ADMIN"    => "Home",
        "CATEGORIES"    => "Categories",
        "ITEMS"         => "Items",
        "MEMBERS"       => "Members",
        "STATISTICS"    => "Statistics",
        "COMMENTS"      => "Comments",
        "LOGS"          => "logs",
        "EDIT_PROFILE"  => "Edit Profile",
        "SETTING"       => "Setting",
        "LOG_OUT"       => "Logout",
        "ADMIN"         => "Admin",
        "DASHBOARD"      => "Dashboard"

    );

    return $lang[$phrase];
}