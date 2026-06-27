<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $medicine_id = $_POST['medicine_id'];
    $user_id = $_SESSION['user_id'];
    
    $query = "INSERT INTO sales (user_id, medicine_id, sale_date) VALUES ('$user_id', '$medicine_id', NOW())";
    
    if (mysqli_query($conn, $query)) {
        $_SESSION['order_success'] = "تم إتمام طلبك بنجاح! يمكنك مراجعة تفاصيل طلباتك أدناه.";
        header("Location: my_orders.php");
        exit();
    } else {
        echo "حدث خطأ أثناء الطلب: " . mysqli_error($conn);
    }
}
?>