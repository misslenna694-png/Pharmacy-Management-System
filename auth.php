<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


if (!isset($_SESSION['user_id']) && isset($_COOKIE['user_username'])) {
    include 'db.php'; // لربط قاعدة البيانات
    $username = mysqli_real_escape_string($conn, $_COOKIE['user_username']);
    
    // نبحث عن المستخدم في قاعدة البيانات بناءً على الاسم المحفوظ في الـ Cookie
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        // نعيد إحياء الجلسة (Session) تلقائياً
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
    }
}
?>