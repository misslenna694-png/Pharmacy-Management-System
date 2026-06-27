<?php
session_start();
include 'db.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$message = "";
if (isset($_POST['add_medicine'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $category = $_POST['category_id'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    @mysqli_query($conn, "SET FOREIGN_KEY_CHECKS=0");
    
    $insert_query = "INSERT INTO medicines (name, category_id, price, quantity) VALUES ('$name', '$category', '$price', '$quantity')";
    if (mysqli_query($conn, $insert_query)) {
        $message = "<div class='alert alert-success text-right'>تم إضافة الدواء بنجاح!</div>";
    } else {
        $message = "<div class='alert alert-danger text-right'>خطأ في الإضافة: " . mysqli_error($conn) . "</div>";
    }
    
    @mysqli_query($conn, "SET FOREIGN_KEY_CHECKS=1");
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM medicines WHERE id=$id");
    header("Location: medicines.php");
    exit();
}

$query = "SELECT * FROM medicines";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>إدارة الأدوية - نظام الصيدلية</title>
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f8f9fc; }
        .main-card { background: white; border-radius: 12px; box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15); padding: 30px; margin-bottom: 20px; }
    </style>
</head>
<body dir="rtl" class="text-right">

    <?php include 'header.php'; ?>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                
                <?php echo $message; ?>
                
                <div class="main-card text-right">
                    <h4 class="text-primary mb-4">➕ إضافة دواء جديد للمخزن</h4>
                    <form method="POST" action="medicines.php">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="font-weight-bold">اسم الدواء</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="font-weight-bold">رقم التصنيف</label>
                                <input type="number" name="category_id" class="form-control" value="1" readonly required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="font-weight-bold">السعر (₪)</label>
                                <input type="number" step="0.01" name="price" class="form-control" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="font-weight-bold">الكمية المتاحة</label>
                                <input type="number" name="quantity" class="form-control" required>
                            </div>
                        </div>
                        <button type="submit" name="add_medicine" class="btn btn-primary px-4 mt-2">حفظ الدواء في النظام</button>
                    </form>
                </div>

                <div class="main-card mb-5 text-right">
                    <h4 class="text-success mb-4">📋 قائمة الأدوية المتوفرة حالياً</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered text-right" width="100%" cellspacing="0">
                            <thead class="bg-light">
                                <tr>
                                    <th>الرقم العام</th>
                                    <th>اسم الدواء</th>
                                    <th>السعر</th>
                                    <th>الكمية بالمخزن</th>
                                    <th>العمليات</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($row = mysqli_fetch_assoc($result)) { ?>
                                <tr>
                                    <td><?php echo $row['id']; ?></td>
                                    <td><strong><?php echo $row['name']; ?></strong></td>
                                    <td><?php echo $row['price']; ?> ₪</td>
                                    <td><?php echo $row['quantity']; ?> وحدة</td>
                                    <td>
                                        <a href="edit_medicine.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">تعديل</a>
                                        <a href="medicines.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('هل أنتِ متأكدة من حذف هذا الدواء؟')">حذف</a>
                                    </td>
                                </tr>
                                <?php } ?>
                                <?php if(mysqli_num_rows($result) == 0) { echo "<tr><td colspan='5' class='text-center text-muted'>لا يوجد أدوية مضافة بعد.</td></tr>"; } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

</body>
</html>