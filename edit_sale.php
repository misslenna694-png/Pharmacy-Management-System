<?php
session_start();
include 'db.php';
if (!isset($_SESSION['username'])) { header("Location: login.php"); exit(); }

$sale_id = $_GET['id'];

// جلب بيانات الفاتورة الحالية
$query = "SELECT sd.medicine_id, sd.quantity, m.name, m.price 
          FROM sale_details sd 
          JOIN medicines m ON sd.medicine_id = m.id 
          WHERE sd.sale_id = '$sale_id'";
$result = mysqli_query($conn, $query);
$sale = mysqli_fetch_assoc($result);

if (!$sale) {
    echo "الفاتورة غير موجودة!";
    exit();
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <title>تعديل فاتورة</title>
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card p-4 shadow" style="max-width: 500px; margin: auto;">
            <h3 class="text-primary text-center">تعديل الفاتورة #<?php echo $sale_id; ?></h3>
            <p>اسم الدواء: <strong><?php echo $sale['name']; ?></strong></p>
            
            <form method="POST" action="update_sale_process.php">
                <input type="hidden" name="sale_id" value="<?php echo $sale_id; ?>">
                <input type="hidden" name="medicine_id" value="<?php echo $sale['medicine_id']; ?>">
                <input type="hidden" name="old_quantity" value="<?php echo $sale['quantity']; ?>">
                
                <label>الكمية الجديدة:</label>
                <input type="number" name="new_quantity" class="form-control mb-3" value="<?php echo $sale['quantity']; ?>" required>
                
                <button type="submit" class="btn btn-warning text-white btn-block">حفظ التعديلات</button>
                <a href="sales.php" class="btn btn-secondary btn-block">إلغاء</a>
            </form>
        </div>
    </div>
</body>
</html>