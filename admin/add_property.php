<?php
// admin/add_property.php
session_start();
include('../include/connected.php');

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'مدير') {
    header("Location: admin.php");
    exit();
}

$msg = "";

if (isset($_POST['add_btn'])) {
    $type = $_POST['type'];
    $price = $_POST['price'];
    $location = $_POST['location'];
    $details = $_POST['details'];
    $user_id = $_SESSION['user_id'];
    
    // معالجة الصورة
    $imagePath = "";
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $fileName = time() . "_" . $_FILES['image']['name'];
        // نرفع الصورة إلى مجلد imag الموجود في الجذر (خارج admin)
        $targetDir = "../imag/";
        $targetFile = $targetDir . $fileName;
        
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            // نخزن المسار النسبي في قاعدة البيانات
            $imagePath = "imag/" . $fileName;
        }
    } else {
        // صورة افتراضية أو رابط خارجي إذا أدخله المستخدم (يمكن تطويره)
        $imagePath = "imag/property-1.jpg"; 
    }

    $stmt = $conn->prepare("INSERT INTO properties (user_id, type, price, location, details, image) VALUES (?, ?, ?, ?, ?, ?)");
    if ($stmt->execute([$user_id, $type, $price, $location, $details, $imagePath])) {
        echo "<script>alert('تم إضافة العقار بنجاح'); window.location.href='properties.php';</script>";
    } else {
        $msg = "حدث خطأ أثناء الإضافة";
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إضافة عقار</title>
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
            <li><a href="adminpanel.php"><i class="fas fa-tachometer-alt"></i> الرئيسية</a></li>
            <li><a href="properties.php"><i class="fas fa-building"></i> إدارة العقارات</a></li>
            <li><a href="add_property.php" class="active"><i class="fas fa-plus-circle"></i> إضافة عقار</a></li>
            <li><a href="../index.php" target="_blank"><i class="fas fa-globe"></i> عرض الموقع</a></li>
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> خروج</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="form-box">
            <h2 style="text-align: center; margin-bottom: 20px;">إضافة عقار جديد</h2>
            <?php if($msg) echo "<p style='color:red;text-align:center'>$msg</p>"; ?>
            
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label>نوع العقار</label>
                    <select name="type" class="form-control" required>
                        <option value="شقة">شقة</option>
                        <option value="فيلا">فيلا</option>
                        <option value="أرض">أرض</option>
                        <option value="مكتب">مكتب</option>
                        <option value="منزل">منزل</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>السعر ($)</label>
                    <input type="number" name="price" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>الموقع</label>
                    <input type="text" name="location" class="form-control" placeholder="مثال: صنعاء، حدة" required>
                </div>

                <div class="form-group">
                    <label>تفاصيل العقار</label>
                    <textarea name="details" class="form-control" required></textarea>
                </div>

                <div class="form-group">
                    <label>صورة العقار</label>
                    <input type="file" name="image" class="form-control" accept="image/*" required>
                </div>

                <button type="submit" name="add_btn" class="btn btn-primary" style="width: 100%;">نشر العقار</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>