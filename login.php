<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);

        if (password_verify($password, $user['password']) || $password == $user['password']) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            if (isset($_POST['remember_me'])) {
                setcookie("user_username", $username, time() + (86400 * 30), "/");
            }

            if ($user['role'] == 'admin') {
                header("Location: dashboard.php");
            } else {
                header("Location: shop.php");
            }
            exit();
        } else {
            $error = "كلمة المرور غير صحيحة";
        }
    } else {
        $error = "اسم المستخدم غير موجود";
    }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>تسجيل الدخول</title>
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(180deg, #4e73df 10%, #224abe 100%); height: 100vh; display: flex; align-items: center; justify-content: center; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; }
        .login-container { width: 100%; max-width: 450px; padding: 15px; }
        .card { border: none; border-radius: 15px; box-shadow: 0 1rem 3rem rgba(0,0,0,.175) !important; background: #fff; padding: 35px; text-align: center; }
        .form-control { border-radius: 10px; padding: 20px; text-align: center !important; font-size: 16px; margin-bottom: 15px; }
        .btn-login { border-radius: 10px; padding: 10px; font-size: 16px; font-weight: bold; background-color: #4e73df; border: none; color: white; width: 100%; cursor: pointer; }
        .btn-login:hover { background-color: #2e59d9; }
        .title { color: #333; font-size: 24px; margin-bottom: 25px; font-weight: 700; }
        .alert-danger { background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 10px; margin-bottom: 15px; font-size: 14px; }
        .remember-me { margin-bottom: 15px; text-align: right; font-size: 14px; color: #555; }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="card">
            <div class="title">تسجيل الدخول للنظام 💊</div>
            <?php if (!empty($error)): ?>
                <div class="alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            <form method="POST">
                <input type="text" name="username" class="form-control" placeholder="اسم المستخدم" value="<?php echo isset($_COOKIE['user_username']) ? $_COOKIE['user_username'] : ''; ?>" required>
                <input type="password" name="password" class="form-control" placeholder="كلمة المرور" required>
                <div class="remember-me">
                    <input type="checkbox" name="remember_me" id="remember">
                    <label for="remember">تذكرني</label>
                </div>
                <button type="submit" class="btn-login">دخول</button>
            </form>
        </div>
    </div>
</body>
</html>