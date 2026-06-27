<?php
// 1. استدعاء الجلسة 
include 'auth.php'; 

// 2. استدعاء ملف الاتصال بقاعدة البيانات 
include 'db.php'; 

// التحقق من أن المستخدم مسجل دخول وأنه "أدمن"
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <title>لوحة تحكم الأدمن</title>
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body style="background-color: #f8f9fc;">

    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand font-weight-bold" href="#">لوحة تحكم الأدمن</a>
            <div class="navbar-nav mr-auto">
                <a class="nav-link" href="admin_dashboard.php">سجل المبيعات</a>
                <a class="nav-link" href="shop.php">المتجر</a>
                <a class="nav-link" href="admin_orders.php">إدارة طلبات العملاء</a>
            </div>
            <div class="d-flex">
                <a href="logout.php" class="btn btn-outline-danger btn-sm">تسجيل خروج</a>
            </div>
        </div>
    </nav>

    <div style="height: 80px;"></div>

    <div class="container-fluid">
        <h2 class="text-center mb-4">سجل جميع المبيعات</h2>
        <div class="card shadow p-3">
            <table class="table table-bordered table-striped">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>اسم المستخدم</th>
                        <th>اسم الدواء</th>
                        <th>تاريخ الطلب</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT sales.*, users.username, medicines.name 
                              FROM sales 
                              JOIN users ON sales.user_id = users.id 
                              JOIN medicines ON sales.medicine_id = medicines.id 
                              ORDER BY sales.sale_date DESC";
                    $result = mysqli_query($conn, $query);
                    
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<tr>
                                <td>'.$row['username'].'</td>
                                <td>'.$row['name'].'</td>
                                <td>'.$row['sale_date'].'</td>
                              </tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>