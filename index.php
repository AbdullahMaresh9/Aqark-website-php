<?php
// index.php
session_start();
include('include/connected.php'); // ملف الاتصال
include('include/file/header.php'); // الهيدر المشترك
?>

<main>
    <section class="hero-section" style="background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('imag/real-stste.jpg') no-repeat center center/cover;">
        <div class="container">
            <div class="hero-content">
                <h1>اكتشف عقارك القادم</h1>
                <p>ابحث في قائمة واسعة من العقارات المعروضة للبيع والإيجار.</p>
            </div>
        </div>
    </section>

    <section class="properties-listing">
        <div class="container">
            <h2 class="section-title">أحدث العقارات المضافة</h2>
            
            <div class="properties-grid">
                <?php
                // جلب العقارات من قاعدة البيانات
                $stmt = $conn->prepare("SELECT * FROM properties ORDER BY id DESC LIMIT 9");
                $stmt->execute();
                $counter=0; 

                // التحقق من وجود عقارات
                if($stmt->rowCount() > 0) {
                    while($row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
                        if($counter>=3 ) break;
                        $counter++;
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