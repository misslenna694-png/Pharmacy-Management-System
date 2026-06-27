<?php
session_start();
include 'db.php';

if (isset($_GET['id'])) {
    $order_id = $_GET['id'];
    
    // إذا كان الطلب قادماً من الأدمن (عبر الرابط admin=1)
    if (isset($_GET['admin']) && $_SESSION['role'] == 'admin') {
        $query = "DELETE FROM sales WHERE id = '$order_id'";
    } else {
        // حذف عادي للمستخدم
        $user_id = $_SESSION['user_id'];
        $query = "DELETE FROM sales WHERE id = '$order_id' AND user_id = '$user_id'";
    }
    
    mysqli_query($conn, $query);
}

// إعادة التوجيه بناءً على من قام بالحذف
if (isset($_GET['admin'])) {
    header("Location: admin_orders.php");
} else {
    header("Location: my_orders.php");
}
exit();
?>