<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4" style="direction: rtl;">
    <div class="container">
        <a class="navbar-brand" href="<?php echo ($_SESSION['role'] == 'admin') ? 'dashboard.php' : 'shop.php'; ?>">🏥 نظام الصيدلية</a>
        
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo ($_SESSION['role'] == 'admin') ? 'dashboard.php' : 'shop.php'; ?>">الرئيسية</a>
                </li>

                <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
                    <li class="nav-item"><a class="nav-link" href="medicines.php">إدارة الأدوية</a></li>
                    <li class="nav-item"><a class="nav-link" href="sales.php">المبيعات</a></li>
                    <li class="nav-item"><a class="nav-link" href="reports.php">التقارير المالية</a></li>
                    <li class="nav-item"><a class="nav-link" href="register.php">إضافة مستخدم</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="shop.php">شاشة البيع</a></li>
                <?php endif; ?>
            </ul>

            <ul class="navbar-nav align-items-center">
                <li class="nav-item">
                    <span class="nav-link text-white font-weight-bold" style="font-size: 1.2rem; margin-left: 20px;">
                        👋 أهلاً، <?php echo htmlspecialchars($_SESSION['username'] ?? 'زائر'); ?>
                    </span>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn btn-danger btn-sm text-white px-3" href="logout.php">خروج</a>
                </li>
            </ul>
        </div>
    </div>
</nav>