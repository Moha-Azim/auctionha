<?php

function lang($phrase)
{
    static $lang = array(

        // Navbar
        "HOME_ADMIN"    => "الرئيسية",
        "CATEGORIES"    => "الأقسام",
        "ITEMS"         => "العناصر",
        "MEMBERS"       => "الأعضاء",
        "STATISTICS"    => "الأحصائيات",
        "COMMENTS"      => "التعليقات",
        "LOGS"          => "السجلات",
        "EDIT_PROFILE"  => "تعديل الملف الشخصي",
        "SETTING"       => "الأعدادت",
        "LOG_OUT"       => "تسجيل الخروج",
        "ADMIN"         => "المدير",
        "DASHBOARD"      => "لوحة التحكم"
    );

    return $lang[$phrase];
}