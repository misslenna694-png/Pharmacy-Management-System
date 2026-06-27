<?php
session_start();
include 'db.php';
if (!isset($_SESSION['username'])) { header("Location: login.php"); exit(); }

$message = "";

// 1. معالجة عملية البيع
if (isset($_POST['create_invoice'])) {
    $medicine_id = $_POST['medicine_id'];
    $quantity_sold = $_POST['quantity'];
    
    $med_query = "SELECT price, quantity FROM medicines WHERE id = '$medicine_id'";
    $med_result = mysqli_query($conn, $med_query);
    $med_data = mysqli_fetch_assoc($med_result);

    if ($med_data) {
        $total_price = $med_data['price'] * $quantity_sold;
        if ($med_data['quantity'] >= $quantity_sold) {
            mysqli_query($conn, "INSERT INTO sales (total_amount) VALUES ('$total_price')");
            $sale_id = mysqli_insert_id($conn);
            mysqli_query($conn, "INSERT INTO sale_details (sale_id, medicine_id, quantity) VALUES ('$sale_id', '$medicine_id', '$quantity_sold')");
            mysqli_query($conn, "UPDATE medicines SET quantity = quantity - '$quantity_sold' WHERE id = '$medicine_id'");
            $message = "<div class='alert alert-success'>تمت عملية البيع بنجاح!</div>";
        } else { $message = "<div class='alert alert-danger'>عذراً، الكمية غير متوفرة!</div>"; }
    }
}

// 2. معالجة الحذف (مع إرجاع الكمية للمخزن)
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $details = mysqli_query($conn, "SELECT medicine_id, quantity FROM sale_details WHERE sale_id = '$delete_id'");
    $row = mysqli_fetch_assoc($details);
    if ($row) {
        mysqli_query($conn, "UPDATE medicines SET quantity = quantity + '{$row['quantity']}' WHERE id = '{$row['medicine_id']}'");
        mysqli_query($conn, "DELETE FROM sale_details WHERE sale_id = '$delete_id'");
        mysqli_query($conn, "DELETE FROM sales WHERE id = '$delete_id'");
        header("Location: sales.php");
        exit();
    }
}

$med_list_result = mysqli_query($conn, "SELECT * FROM medicines WHERE quantity > 0");
$sales_history_result = mysqli_query($conn, "SELECT s.id, s.total_amount, m.name, sd.quantity FROM sales s JOIN sale_details sd ON s.id = sd.sale_id JOIN medicines m ON sd.medicine_id = m.id ORDER BY s.id DESC");
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <style>
        .container { margin-top: 50px; }
        .card { border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); padding: 25px; margin-bottom: 30px; }
    </style>
</head>
<body class="bg-light">
    <div class="container">
        <?php echo $message; ?>
        <div class="card">
            <h3 class="text-primary text-center">🛒 تسجيل عملية بيع جديدة</h3>
            <form method="POST">
                <select name="medicine_id" class="form-control mb-3" required>
                    <option value="">اختر الدواء</option>
                    <?php while($med = mysqli_fetch_assoc($med_list_result)) { ?>
                        <option value="<?php echo $med['id']; ?>"><?php echo $med['name']; ?></option>
                    <?php } ?>
                </select>
                <input type="number" name="quantity" class="form-control mb-3" placeholder="الكمية المطلوبة" required>
                <button type="submit" name="create_invoice" class="btn btn-primary w-100">إتمام البيع</button>
            </form>
        </div>

        <div class="card">
            <h3 class="text-success text-center">📋 سجل المبيعات</h3>
            <table class="table table-hover">
                <thead class="bg-light">
                    <tr><th>رقم الفاتورة</th><th>اسم الدواء</th><th>الكمية</th><th>المبلغ الإجمالي</th><th class="text-center">إجراءات</th></tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($sales_history_result)) { ?>
                    <tr>
                        <td>#<?php echo $row['id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['quantity']; ?></td>
                        <td class="font-weight-bold text-primary"><?php echo $row['total_amount']; ?> ₪</td>
                        <td class="text-center">
                            <a href="edit_sale.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm text-white">تعديل</a>
                            <a href="?delete_id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('تنبيه: سيتم إرجاع الكمية للمخزن!');">حذف</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>