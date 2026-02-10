<?php
// admin/edit_property.php
session_start();
include('../include/connected.php');

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'مدير') {
    header("Location: admin.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: properties.php");
    exit();
}

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM properties WHERE id = ?");
$stmt->execute([$id]);
$prop = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$prop) {
    echo "العقار غير موجود";
    exit();
}

if (isset($_POST['update_btn'])) {
    $type = $_POST['type'];
    $price = $_POST['price'];
    $location = $_POST['location'];
    $details = $_POST['details'];
    
    // تحديث الصورة إذا تم رفع واحدة جديدة
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $fileName = time() . "_" . $_FILES['image']['name'];
        $targetDir = "../imag/";
        $targetFile = $targetDir . $fileName;
        
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            $imagePath = "imag/" . $fileName;
            $sql = "UPDATE properties SET type=?, price=?, location=?, details=?, image=? WHERE id=?";
            $stmtUp = $conn->prepare($sql);
            $stmtUp->execute([$type, $price, $location, $details, $imagePath, $id]);
        }
    } else {
        // تحديث بدون الصورة
        $sql = "UPDATE properties SET type=?, price=?, location=?, details=? WHERE id=?";
        $stmtUp = $conn->prepare($sql);
        $stmtUp->execute([$type, $price, $location, $details, $id]);
    }

    echo "<script>alert('تم التحديث بنجاح'); window.location.href='properties.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تعديل العقار</title>
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
            <li><a href="properties.php" class="active"><i class="fas fa-building"></i> إدارة العقارات</a></li>
            <li><a href="add_property.php"><i class="fas fa-plus-circle"></i> إضافة عقار</a></li>
            <li><a href="../index.php" target="_blank"><i class="fas fa-globe"></i> عرض الموقع</a></li>
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> خروج</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="form-box">
            <h2 style="text-align: center; margin-bottom: 20px;">تعديل العقار رقم <?php echo $prop['id']; ?></h2>
            
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label>نوع العقار</label>
                    <select name="type" class="form-control">
                        <option value="شقة" <?php if($prop['type']=='شقة') echo 'selected'; ?>>شقة</option>
                        <option value="فيلا" <?php if($prop['type']=='فيلا') echo 'selected'; ?>>فيلا</option>
                        <option value="أرض" <?php if($prop['type']=='أرض') echo 'selected'; ?>>أرض</option>
                        <option value="مكتب" <?php if($prop['type']=='مكتب') echo 'selected'; ?>>مكتب</option>
                        <option value="منزل" <?php if($prop['type']=='منزل') echo 'selected'; ?>>منزل</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>السعر ($)</label>
                    <input type="number" name="price" class="form-control" value="<?php echo $prop['price']; ?>" required>
                </div>

                <div class="form-group">
                    <label>الموقع</label>
                    <input type="text" name="location" class="form-control" value="<?php echo $prop['location']; ?>" required>
                </div>

                <div class="form-group">
                    <label>التفاصيل</label>
                    <textarea name="details" class="form-control" required><?php echo $prop['details']; ?></textarea>
                </div>

                <div class="form-group">
                    <label>الصورة الحالية</label><br>
                    <?php 
                        $showImg = (filter_var($prop['image'], FILTER_VALIDATE_URL)) ? $prop['image'] : "../" . $prop['image'];
                    ?>
                    <img src="<?php echo $showImg; ?>" width="100" style="border-radius: 5px;">
                </div>

                <div class="form-group">
                    <label>تغيير الصورة (اختياري)</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                </div>

                <button type="submit" name="update_btn" class="btn btn-success" style="width: 100%;">حفظ التعديلات</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>