<?php
session_start();
include 'db.php';
if (!isset($_SESSION['username'])) { header("Location: login.php"); exit(); }
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <title>التقارير المالية</title>
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f8f9fc; }
        .report-card { border-radius: 12px; box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15); transition: 0.3s; }
        .report-card:hover { transform: translateY(-5px); }
    </style>
</head>
<body class="text-right">

    <?php include 'header.php'; ?>

    <div class="container" style="max-width: 900px; margin: auto; margin-top: 30px;">
        <h3 class="text-primary mb-4 text-center">📊 تقرير مبيعات اليوم</h3>
        
        <div class="row justify-content-center">
            
            <div class="col-md-5 mb-4">
                <div class="card border-right-primary shadow h-100 py-2 report-card">
                    <div class="card-body text-center">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">عدد عمليات البيع اليوم</div>
                        <?php
                        $res_count = mysqli_query($conn, "SELECT COUNT(*) as count FROM sales WHERE DATE(sale_date) = CURDATE()");
                        $data_count = mysqli_fetch_assoc($res_count);
                        ?>
                        <div class="h3 mb-0 font-weight-bold text-gray-800"><?php echo $data_count['count']; ?> عملية</div>
                    </div>
                </div>
            </div>

            <div class="col-md-5 mb-4">
                <div class="card border-right-success shadow h-100 py-2 report-card">
                    <div class="card-body text-center">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">إجمالي مبيعات اليوم</div>
                        <?php
                        $res_sum = mysqli_query($conn, "SELECT SUM(total_amount) as total FROM sales WHERE DATE(sale_date) = CURDATE()");
                        $data_sum = mysqli_fetch_assoc($res_sum);
                        ?>
                        <div class="h3 mb-0 font-weight-bold text-gray-800"><?php echo number_format($data_sum['total'] ?? 0, 2); ?> ₪</div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>
</html>