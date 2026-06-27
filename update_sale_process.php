<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sale_id = $_POST['sale_id'];
    $med_id = $_POST['medicine_id'];
    $old_qty = $_POST['old_quantity'];
    $new_qty = $_POST['new_quantity'];

    // 1. حساب الفرق لإعادة أو سحب الكمية من المخزن
    $diff = $new_qty - $old_qty;

    // 2. تحديث المخزن بناءً على الفرق
    // إذا كان $diff موجباً (زيادة)، نطرح من المخزن. إذا كان سالباً (نقص)، نجمع للمخزن.
    mysqli_query($conn, "UPDATE medicines SET quantity = quantity - '$diff' WHERE id = '$med_id'");

    // 3. تحديث الفاتورة (الكمية والمبلغ)
    $med_price_query = mysqli_query($conn, "SELECT price FROM medicines WHERE id = '$med_id'");
    $med_price = mysqli_fetch_assoc($med_price_query)['price'];
    $new_total = $med_price * $new_qty;

    mysqli_query($conn, "UPDATE sale_details SET quantity = '$new_qty' WHERE sale_id = '$sale_id'");
    mysqli_query($conn, "UPDATE sales SET total_amount = '$new_total' WHERE id = '$sale_id'");

    header("Location: sales.php");
    exit();
}
?>