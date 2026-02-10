<?php
// admin/adminpanel.php
session_start();
include('../include/connected.php');

// حماية الصفحة
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'مدير') {
    header("Location: admin.php");
    exit();
}

// جلب الإحصائيات
$usersCount = $conn->query("SELECT COUNT(*) FROM users")->fetchColumn();
$agentsCount = $conn->query("SELECT COUNT(*) FROM users WHERE user_type = 'وكيل'")->fetchColumn();
$propsCount = $conn->query("SELECT COUNT(*) FROM properties")->fetchColumn();
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>لوحة التحكم</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

<div class="dashboard-container">
    <div class="sidebar">
        <div class="sidebar-header">
            <h3><i class="fas fa-user-shield"></i> المدير</h3>
        </div>
        <ul>
            <li><a href="adminpanel.php" class="active"><i class="fas fa-tachometer-alt"></i> الرئيسية</a></li>
            <li><a href="properties.php"><i class="fas fa-building"></i> إدارة العقارات</a></li>
            <li><a href="add_property.php"><i class="fas fa-plus-circle"></i> إضافة عقار</a></li>
            <li><a href="../index.php" target="_blank"><i class="fas fa-globe"></i> عرض الموقع</a></li>
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> خروج</a></li>
        </ul>
    </div>

    <div class="main-content">
        <h2 style="margin-bottom: 20px; color: #2c3e50;">أهلاً بك، <?php echo $_SESSION["first_name"] ;?> </h2>
        
        <div class="stats-grid">
            <div class="stat-card">
                <div>
                    <h3><?php echo $usersCount; ?></h3>
                    <p>إجمالي المستخدمين</p>
                </div>
                <i class="fas fa-users" style="color: #3498db;"></i>
            </div>
            
            <div class="stat-card">
                <div>
                    <h3><?php echo $agentsCount; ?></h3>
                    <p>عدد الوكلاء</p>
                </div>
                <i class="fas fa-user-tie" style="color: #27ae60;"></i>
            </div>

            <div class="stat-card">
                <div>
                    <h3><?php echo $propsCount; ?></h3>
                    <p>العقارات المعروضة</p>
                </div>
                <i class="fas fa-home" style="color: #fe4a02;"></i>
            </div>
        </div>

        <div class="form-box" style="text-align: center; max-width: 100%;">
            <h3>روابط سريعة</h3>
            <br>
            <a href="add_property.php" class="btn btn-primary">إضافة عقار جديد</a>
            <a href="properties.php" class="btn btn-info">عرض العقارات</a>
        </div>
    </div>
</div>

</body>
</html>