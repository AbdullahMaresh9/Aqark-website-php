<?php
// partenrs.php
session_start();
include('include/connected.php');
include('include/file/header.php');
?>

<div class="container" style="padding: 50px 0;">
    <h2 class="section-title">وكلاؤنا المعتمدون</h2>
    <p style="text-align: center; margin-bottom: 40px; color: #777;">نخبة من أفضل وكلاء العقارات المستعدين لخدمتكم</p>

    <div class="properties-grid" style="grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));">
        <?php
        // جلب المستخدمين الذين نوعهم "وكيل" فقط
        $stmt = $conn->prepare("SELECT * FROM users WHERE user_type = 'وكيل'");
        $stmt->execute();
        
        if($stmt->rowCount() > 0) {
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        ?>
            <div class="property-card" style="text-align: center; padding: 30px;">
                <div style="width: 100px; height: 100px; background: #f0f0f0; border-radius: 50%; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; font-size: 40px; color: var(--secondary-color);">
                    <i class="fas fa-user-tie"></i>
                </div>
                
                <h3 style="color: var(--primary-color); margin-bottom: 10px;">
                    <?php echo $row['first_name'] . ' ' . $row['last_name']; ?>
                </h3>
                
                <p style="color: #777; margin-bottom: 5px;">
                    <i class="fas fa-envelope"></i> <?php echo $row['email']; ?>
                </p>
                <p style="color: #777; margin-bottom: 20px;">
                    <i class="fas fa-phone"></i> <?php echo $row['phone']; ?>
                </p>

                <a href="https://wa.me/<?php echo $row['phone']; ?>" class="btn whatsapp-btn" style="width: 100%; display: inline-block;">
                    تواصل مباشرة
                </a>
            </div>
        <?php 
            }
        } else {
            echo "<p style='text-align:center; width:100%;'>لا يوجد وكلاء مسجلين حالياً.</p>";
        }
        ?>
    </div>
</div>

<?php include('include/file/footer.php'); ?>