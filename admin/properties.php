<?php
// admin/properties.php
session_start();
include('../include/connected.php');
include('../include/file/header.php');


if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'مدير') {
    header("Location: admin.php");
    exit();
}

// كود الحذف
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    // حذف الصورة من المجلد أولاً (اختياري، للتحسين)
    $stmtImg = $conn->prepare("SELECT image FROM properties WHERE id = ?");
    $stmtImg->execute([$id]);
    $imgRow = $stmtImg->fetch(PDO::FETCH_ASSOC);
    
    // الحذف من القاعدة
    $stmt = $conn->prepare("DELETE FROM properties WHERE id = ?");
    if ($stmt->execute([$id])) {
        // إذا نجح الحذف، نحاول حذف الملف إذا كان محلياً
        if ($imgRow && !filter_var($imgRow['image'], FILTER_VALIDATE_URL)) {
             $filePath = "../" . $imgRow['image'];
             if(file_exists($filePath)) unlink($filePath);
        }
        header("Location: properties.php");
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إدارة العقارات</title>
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
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2>كافة العقارات</h2>
            <a href="add_property.php" class="btn btn-primary"><i class="fas fa-plus"></i> إضافة جديد</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>الصورة</th>
                    <th>النوع</th>
                    <th>السعر</th>
                    <th>الموقع</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $stmt = $conn->query("SELECT * FROM properties ORDER BY id DESC");
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    // معالجة عرض الصورة
                    $imgSrc = $row['image'];
                    // إذا لم تكن رابط خارجي ولا يوجد بها imag/ نضيفه
                    if (!filter_var($imgSrc, FILTER_VALIDATE_URL) && strpos($imgSrc, 'imag/') === false) {
                        $imgSrc = "imag/" . $imgSrc;
                    }
                    // المسار للعرض (نحتاج ../ إذا كانت الصورة في imag خارج admin)
                    // لكن في المتصفح بالنسبة للصفحة الحالية
                    $displayImg = (filter_var($imgSrc, FILTER_VALIDATE_URL)) ? $imgSrc : "../" . $imgSrc;
                ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><img src="<?php echo $displayImg; ?>" width="60" height="60" style="object-fit: cover; border-radius: 5px;"></td>
                    <td><?php echo $row['type']; ?></td>
                    <td><?php echo number_format($row['price']); ?> $</td>
                    <td><?php echo $row['location']; ?></td>
                    <td>
                        <a href="edit_property.php?id=<?php echo $row['id']; ?>" class="btn btn-success"><i class="fas fa-edit"></i></a>
                        <a href="properties.php?delete_id=<?php echo $row['id']; ?>" onclick="return confirm('هل أنت متأكد من الحذف؟')" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
<?php 
include('..include/file/footer.php'); // الفوتر المشترك
?>