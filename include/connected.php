<?php
// include/connected.php
include_once("conf.php");

try {
    $dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8";
    $conn = new PDO($dsn, DB_USER, DB_PASS); // سميناه $conn ليكون مشابهاً لمشروع التسوق
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "فشل الاتصال بقاعدة البيانات: " . $e->getMessage();
    exit();
}
?>