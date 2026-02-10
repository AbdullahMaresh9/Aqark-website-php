<?php
// admin/properties.php
session_start();
include('include/connected.php');
include('include/file/header.php');
?>
<main>
    <section class="properties-listing">
        <div class="container">
            <h2 class="section-title">كافـة العقارات المضافة</h2>
            
            <div class="properties-grid">
                <?php
                // جلب العقارات من قاعدة البيانات
                $stmt = $conn->prepare("SELECT * FROM properties ORDER BY id DESC LIMIT 9");
                $stmt->execute();
                
                // التحقق من وجود عقارات
                if($stmt->rowCount() > 0) {
                    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        // معالجة مسار الصورة
                        $imgSrc = $row['image'];
                        if (!filter_var($imgSrc, FILTER_VALIDATE_URL) && strpos($imgSrc, 'imag/') === false) {
                            $imgSrc = "imag/" . $imgSrc;
                        }
                ?>
                    <div class="property-card">
                        <div class="card-image-wrapper">
                            <img src="<?php echo $imgSrc; ?>" alt="<?php echo $row['type']; ?>" onerror="this.src='imag/logo.png'">
                            <span class="card-price"><?php echo number_format($row['price']); ?> $</span>
                        </div>
                        <div class="property-info">
                            <h3><?php echo $row['type']; ?></h3>
                            <p class="location"><i class="fas fa-map-marker-alt"></i> <?php echo $row['location']; ?></p>
                            
                            <div class="property-actions">
                                <a href="detalis.php?id=<?php echo $row['id']; ?>" class="btn primary-btn">التفاصيل</a>
                            </div>
                        </div>
                    </div>
                    <?php 
                    } // نهاية الـ while
                } else {
                    echo "<p style='text-align:center; width:100%;'>لا توجد عقارات معروضة حالياً.</p>";
                }
                ?>
            </div>
        </div>
    </section>
</main>
<?php 
include('include/file/footer.php'); // الفوتر المشترك
?>