<?php
session_start();
include 'db.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <title>متجر الأدوية</title>
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <style>
        .product-card { border: 1px solid #ddd; padding: 15px; border-radius: 15px; margin-bottom: 20px; text-align: center; transition: 0.3s; background: white; }
        .product-card:hover { box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        .product-img { width: 100%; height: 150px; object-fit: contain; margin-bottom: 10px; border-radius: 10px; }
    </style>
</head>
<body class="p-4" style="background-color: #f8f9fc;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>مرحباً بك يا <?php echo htmlspecialchars($_SESSION['username']); ?> في الصيدلية 💊</h2>
        <a href="logout.php" class="btn btn-danger">تسجيل خروج</a>
    </div>
    <hr>

    <div class="row mb-4">
        <div class="col-md-6">
            <form action="shop.php" method="GET" class="form-inline">
                <input type="text" name="search" class="form-control ml-2" placeholder="ابحث عن دواء..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                <button type="submit" class="btn btn-primary ml-2">بحث</button>
                <a href="shop.php" class="btn btn-secondary">الكل</a>
            </form>
        </div>
    </div>

    <div class="row">
        <?php
        $search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

        if ($search != "") {
            $query = "SELECT * FROM medicines WHERE name LIKE '%$search%'";
        } else {
            $query = "SELECT * FROM medicines";
        }

        $result = mysqli_query($conn, $query);
        
        while ($row = mysqli_fetch_assoc($result)) {
            $imgSrc = !empty($row['image_path']) ? 'images/' . $row['image_path'] : 'images/default.png';
            
            echo '<div class="col-md-3">
                    <div class="product-card shadow-sm">
                        <img src="'.$imgSrc.'" class="product-img" alt="'.$row['name'].'">
                        <h5>'.$row['name'].'</h5>
                        <p class="text-primary font-weight-bold">السعر: '.$row['price'].' شيكل</p>
                        <form action="order.php" method="POST">
                            <input type="hidden" name="medicine_id" value="'.$row['id'].'">
                            <button type="submit" class="btn btn-primary btn-block">طلب الآن</button>
                        </form>
                    </div>
                  </div>';
        }
        ?>
    </div>
</body>
</html>