<?php
// my_properties.php
session_start();
include('include/connected.php');
include('include/file/header.php');

// 1. التحقق من الصلاحية (وكيل فقط)
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'وكيل') {
    echo "<script>alert('عذراً، هذه الصفحة خاصة بالوكلاء فقط.'); window.location.href='index.php';</script>";
    exit();
}

$user_id = $_SESSION['user_id'];

// 2. كود حذف العقار (مع التأكد أنه يملكه)
if (isset($_GET['delete_id'])) {
    $del_id = $_GET['delete_id'];
    
    // جلب العقار للتأكد من الملكية + حذف الصورة
    $checkObj = $conn->prepare("SELECT image FROM properties WHERE id = ? AND user_id = ?");
    $checkObj->execute([$del_id, $user_id]);
    $prop = $checkObj->fetch(PDO::FETCH_ASSOC);

    if ($prop) {
        // الحذف من القاعدة
        $del = $conn->prepare("DELETE FROM properties WHERE id = ?");
        $del->execute([$del_id]);

        // حذف الصورة من السيرفر
        $imgSrc = $prop['image'];
        if (!filter_var($imgSrc, FILTER_VALIDATE_URL) && file_exists($imgSrc)) {
            unlink($imgSrc);
        }

        echo "<script>alert('تم حذف العقار بنجاح'); window.location.href='my_properties.php';</script>";
    } else {
        echo "<script>alert('حدث خطأ! ربما لا تملك هذا العقار.');</script>";
    }
}
?>

<div class="container" style="padding: 50px 0; min-height: 60vh;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h2 class="section-title" style="margin: 0; text-align: right;">عقاراتي المعروضة</h2>
        <a href="add_property.php" class="btn primary-btn"><i class="fas fa-plus"></i> إضافة عقار جديد</a>
    </div>

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; background: white; box-shadow: 0 0 10px rgba(0,0,0,0.1); border-radius: 8px; overflow: hidden;">
            <thead>
                <tr style="background: var(--primary-color); color: white;">
                    <th style="padding: 15px;">الصورة</th>
                    <th style="padding: 15px;">النوع</th>
                    <th style="padding: 15px;">السعر</th>
                    <th style="padding: 15px;">الموقع</th>
                    <th style="padding: 15px;">تاريخ الإضافة</th>
                    <th style="padding: 15px;">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // جلب عقارات الوكيل الحالي فقط
                $stmt = $conn->prepare("SELECT * FROM properties WHERE user_id = ? ORDER BY id DESC");
                $stmt->execute([$user_id]);

                if ($stmt->rowCount() > 0) {
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $imgSrc = $row['image'];
                        if (!filter_var($imgSrc, FILTER_VALIDATE_URL) && strpos($imgSrc, 'imag/') === false) {
                            $imgSrc = "imag/" . $imgSrc;
                        }
                ?>
                    <tr style="border-bottom: 1px solid #eee; text-align: center;">
                        <td style="padding: 10px;">
                            <img src="<?php echo $imgSrc; ?>" style="width: 60px; height: 60px; object-fit: cover; border-radius: 5px; margin: 0 auto;">
                        </td>
                        <td style="padding: 10px;"><?php echo $row['type']; ?></td>
                        <td style="padding: 10px; color: var(--secondary-color); font-weight: bold;"><?php echo number_format($row['price']); ?> $</td>
                        <td style="padding: 10px;"><?php echo $row['location']; ?></td>
                        <td style="padding: 10px; color: #777; font-size: 0.9rem;"><?php echo date('Y-m-d', strtotime($row['created_at'])); ?></td>
                        <td style="padding: 10px;">
                            <a href="edit_property.php?id=<?php echo $row['id']; ?>" class="btn" style="background: #3498db; color: white; padding: 5px 10px; font-size: 0.9rem; margin-left: 5px;">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="my_properties.php?delete_id=<?php echo $row['id']; ?>" onclick="return confirm('هل أنت متأكد من حذف هذا العقار؟')" class="btn" style="background: #e74c3c; color: white; padding: 5px 10px; font-size: 0.9rem;">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php 
                    }
                } else {
                    echo "<tr><td colspan='6' style='padding: 30px; text-align: center;'>لم تقم بإضافة أي عقارات بعد.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php include('include/file/footer.php'); ?>