<?php
session_start();
include 'db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <title>إدارة طلبات العملاء</title>
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body class="p-4" style="background-color: #f8f9fc;">
    <div class="container">
        <div class="d-flex justify-content-between mb-4 align-items-center">
            <h2>إدارة طلبات العملاء 📋</h2>
            <div>
                <a href="admin_dashboard.php" class="btn btn-primary">الرئيسية</a>
                <a href="medicines.php" class="btn btn-info">الأدوية</a>
                <a href="admin_orders.php" class="btn btn-success">الطلبات</a>
                <a href="logout.php" class="btn btn-danger">خروج</a>
            </div>
        </div>
        
        <div class="card shadow p-3">
            <table class="table table-bordered table-striped">
                <thead class="bg-dark text-white">
                    <tr>
                        <th>اسم المستخدم</th>
                        <th>اسم الدواء</th>
                        <th>تاريخ الطلب</th>
                        <th>إجراء</th>
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
                                <td>
                                    <a href="delete_order.php?id='.$row['id'].'&admin=1" class="btn btn-danger btn-sm" 
                                       onclick="return confirm(\'هل أنت متأكد من حذف هذا الطلب؟\')">حذف</a>
                                </td>
                              </tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>