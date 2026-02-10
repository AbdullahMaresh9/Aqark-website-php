<?php
// detalis.php
include('include/connected.php');
include('include/file/header.php');

// التحقق من وجود الـ ID في الرابط
if(isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // جلب بيانات العقار المحدد
    $stmt = $conn->prepare("SELECT * FROM properties WHERE id = ?");
    $stmt->execute([$id]);
    $property = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<div class="container property-details-page">
    <?php if($property): 
         // معالجة الصورة
         $imgSrc = $property['image'];
         if (!filter_var($imgSrc, FILTER_VALIDATE_URL) && strpos($imgSrc, 'imag/') === false) {
             $imgSrc = "imag/" . $imgSrc;
         }
    ?>
        <div class="details-container">
            <div class="details-image">
                <img src="<?php echo $imgSrc; ?>" alt="<?php echo $property['type']; ?>" onerror="this.src='imag/logo.png'">
            </div>

            <div class="details-info-box">
                <h1 class="details-title"><?php echo $property['type']; ?> في <?php echo $property['location']; ?></h1>
                <p class="details-price-tag"><?php echo number_format($property['price']); ?> $</p>
                
                <div class="meta-info">
                    <span><i class="fas fa-map-marker-alt"></i> <?php echo $property['location']; ?></span>
                    <span><i class="fas fa-calendar-alt"></i> <?php echo date('Y-m-d', strtotime($property['created_at'])); ?></span>
                </div>
                
                <hr>
                
                <h3>تفاصيل العقار:</h3>
                <p class="details-text">
                    <?php echo nl2br($property['details']); ?>
                </p>

                <div class="action-buttons">
                    <a href="https://wa.me/9677138533849?text=مرحباً، أستفسر عن العقار رقم <?php echo $property['id']; ?>" target="_blank" class="btn whatsapp-btn">
                        <i class="fab fa-whatsapp"></i> تواصل واتساب
                    </a>
                    <a href="index.php" class="btn secondary-btn">عودة للقائمة</a>
                </div>
            </div>
        </div>

    <?php else: ?>
        <div class="error-msg" style="text-align:center; padding: 50px;">
            <h2>عذراً، العقار غير موجود أو تم حذفه.</h2>
            <a href="index.php" class="btn primary-btn">العودة للرئيسية</a>
        </div>
    <?php endif; ?>
</div>

<?php 
include('include/file/footer.php'); 
?>