<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <title>طلباتي</title>
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body class="p-4" style="background-color: #f8f9fc;">
    <div class="container">
        <div class="d-flex justify-content-between mb-4 align-items-center">
            <h2>قائمة طلباتي 📦</h2>
            <div>
                <a href="shop.php" class="btn btn-primary">المتجر</a>
                <a href="my_orders.php" class="btn btn-success">طلباتي</a>
                <a href="logout.php" class="btn btn-danger">تسجيل خروج</a>
            </div>
        </div>
        
        <?php
        if (isset($_SESSION['order_success'])) {
            echo "<div class='alert alert-success text-center'>".$_SESSION['order_success']."</div>";
            unset($_SESSION['order_success']);
        }
        ?>

        <hr>
        <div class="card shadow p-3">
            <table class="table table-bordered table-striped">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>اسم الدواء</th>
                        <th>تاريخ الطلب</th>
                        <th>العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT sales.*, medicines.name 
                              FROM sales 
                              JOIN medicines ON sales.medicine_id = medicines.id 
                              WHERE sales.user_id = '$user_id' ORDER BY sales.sale_date DESC";
                    $result = mysqli_query($conn, $query);
                    
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<tr>
                                <td><strong>'.$row['name'].'</strong></td>
                                <td>'.$row['sale_date'].'</td>
                                <td>
                                    <a href="delete_order.php?id='.$row['id'].'" class="btn btn-danger btn-sm" 
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