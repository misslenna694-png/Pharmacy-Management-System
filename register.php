<?php
include 'db.php';
$message = "";

if (isset($_POST['register'])) {
    $user = $_POST['username'];
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $query = "INSERT INTO users (username, password) VALUES ('$user', '$pass')";
    if (mysqli_query($conn, $query)) {
        $message = "<div class='alert alert-success'>تم التسجيل بنجاح! يمكنك الآن <a href='login.php'>تسجيل الدخول</a></div>";
    } else {
        $message = "<div class='alert alert-danger'>خطأ في التسجيل!</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <title>إنشاء حساب جديد</title>
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-primary">
    <div class="container mt-5">
        <div class="card o-hidden border-0 shadow-lg my-5" style="max-width: 400px; margin: auto;">
            <div class="card-body p-4">
                <h3 class="text-center text-primary">إنشاء حساب جديد</h3>
                <?php echo $message; ?>
                <form method="POST">
                    <input type="text" name="username" class="form-control mb-3" placeholder="اسم المستخدم" required>
                    <input type="password" name="password" class="form-control mb-3" placeholder="كلمة المرور" required>
                    <button type="submit" name="register" class="btn btn-primary btn-block">تسجيل</button>
                    <a href="login.php" class="btn btn-link btn-block">لديك حساب؟ تسجيل دخول</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>