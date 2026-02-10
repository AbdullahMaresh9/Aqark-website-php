<?php
// admin/logout.php
session_start();
session_destroy();
// نوجهه لصفحة تسجيل الدخول الخاصة بالادمن
header("Location: admin.php"); 
exit();
?>