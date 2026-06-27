<?php
session_start();
include 'db.php';

// التحقق من تسجيل الدخول
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// 1. استعلام إجمالي الأدوية
$med_query = "SELECT COUNT(*) AS total_meds FROM medicines";
$med_result = mysqli_query($conn, $med_query);
$med_data = mysqli_fetch_assoc($med_result);
$total_medicines = $med_data['total_meds'] ?? 0;

// 2. استعلام إجمالي المبيعات
$sales_query = "SELECT SUM(total_amount) AS total_sales FROM sales";
$sales_result = mysqli_query($conn, $sales_query);
$sales_data = mysqli_fetch_assoc($sales_result);
$total_sales_amount = $sales_data['total_sales'] ?? 0.00;

// 3. استعلام التنبيهات (نقص المخزون)
$low_stock_query = "SELECT name, quantity FROM medicines WHERE quantity < 5 AND quantity > 0";
$low_stock_result = mysqli_query($conn, $low_stock_query);
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <title>لوحة التحكم - نظام إدارة الصيدلية</title>
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f8f9fc; }
        .welcome-card { background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); color: white; border-radius: 15px; padding: 35px; margin-top: 30px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); }
        .stat-card { border-left: 4px solid #4e73df; background: white; border-radius: 10px; box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15); padding: 20px; transition: transform 0.2s; }
        .stat-card.info { border-left-color: #36b9cc; }
    </style>
</head>
<body>

    <?php include 'header.php'; ?>

    <div class="container">
        
        <div class="mt-4">
            <?php while($low_med = mysqli_fetch_assoc($low_stock_result)) { ?>
                <div class="alert alert-danger shadow-sm border-right-danger">
                    ⚠️ <strong>تنبيه نقص مخزون:</strong> دواء <strong><?php echo $low_med['name']; ?></strong> يوشك على النفاد، المتبقي: <strong><?php echo $low_med['quantity']; ?></strong> فقط!
                </div>
            <?php } ?>
        </div>

        <div class="welcome-card text-center mb-4">
            <h2 class="font-weight-bold mb-3">🚀 أهلاً بكِ في لوحة التحكم الرئيسية</h2>
            <p class="lead mb-4">اختصارات سريعة للوصول إلى أقسام النظام:</p>
            
            <div class="d-flex justify-content-center flex-wrap">
                <a href="medicines.php" class="btn btn-light btn-lg text-primary font-weight-bold m-2 shadow-sm">📂 إدارة الأدوية</a>
                <a href="sales.php" class="btn btn-success btn-lg font-weight-bold m-2 shadow-sm">🛒 شاشة المبيعات</a>
                <a href="reports.php" class="btn btn-info btn-lg font-weight-bold m-2 shadow-sm">📊 التقارير المالية</a>
                <a href="register.php" class="btn btn-warning btn-lg font-weight-bold m-2 shadow-sm">👤 إضافة مستخدم</a>
                <a href="admin_orders.php" class="btn btn-primary">إدارة طلبات العملاء</a>
            </div>
        </div>

        <div class="row mt-4 mb-5">
            <div class="col-md-6 mb-4">
                <div class="stat-card">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">إجمالي عدد الأدوية بالمخزن</div>
                    <div class="h3 mb-0 font-weight-bold text-gray-800"><?php echo $total_medicines; ?> دواء</div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="stat-card info">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">إجمالي المبيعات الحالية</div>
                    <div class="h3 mb-0 font-weight-bold text-gray-800"><?php echo number_format($total_sales_amount, 2); ?> ₪</div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>