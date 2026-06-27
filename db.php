<?php
$host = "localhost";
$user = "root";
$password = ""; 
$dbname = "pharmacy_db"; 

// إنشاء الاتصال
$conn = new mysqli($host, $user, $password, $dbname);

// التحقق من الاتصال
if ($conn->connect_error) {
    die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}

// دعم اللغة العربية
$conn->set_charset("utf8mb4");
?>