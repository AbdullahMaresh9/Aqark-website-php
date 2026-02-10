<?php
// contact.php
session_start();
include('include/connected.php');
include('include/file/header.php');

$msg = "";
if(isset($_POST['send_msg'])) {
    // هنا يمكنك إضافة كود لإدخال الرسالة في قاعدة البيانات إذا كان لديك جدول messages
    // حالياً سنظهر رسالة نجاح فقط
    $msg = "شكراً لتواصلك معنا! تم إرسال رسالتك بنجاح وسيتم الرد عليك قريباً.";
}
?>

<div class="container" style="padding: 50px 0;">
    <div style="display: flex; flex-wrap: wrap; gap: 40px;">
        
        <div style="flex: 1; min-width: 300px;">
            <h2 class="section-title" style="text-align: right;">معلومات التواصل</h2>
            <p style="line-height: 1.8; color: #555; margin-bottom: 30px;">
                نحن هنا لمساعدتك في العثور على عقارك المثالي. لا تتردد في التواصل معنا عبر القنوات التالية أو زيارة مكتبنا.
            </p>
            
            <div style="margin-bottom: 20px;">
                <h4 style="color: var(--primary-color);"><i class="fas fa-map-marker-alt" style="color: var(--secondary-color); margin-left: 10px;"></i> العنوان</h4>
                <p style="margin-right: 30px;">تعز، الجمهورية اليمنية، شارع جمال</p>
            </div>

            <div style="margin-bottom: 20px;">
                <h4 style="color: var(--primary-color);"><i class="fas fa-phone" style="color: var(--secondary-color); margin-left: 10px;"></i> الهاتف</h4>
                <p style="margin-right: 30px;">+967 713 853 3849</p>
            </div>

            <div style="margin-bottom: 20px;">
                <h4 style="color: var(--primary-color);"><i class="fas fa-envelope" style="color: var(--secondary-color); margin-left: 10px;"></i> البريد الإلكتروني</h4>
                <p style="margin-right: 30px;">info@aqarak.com</p>
            </div>
        </div>

        <div style="flex: 1; min-width: 300px; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 15px rgba(0,0,0,0.1);">
            <h3 style="margin-bottom: 20px; color: var(--primary-color);">أرسل لنا رسالة</h3>
            
            <?php if($msg): ?>
                <div style="background: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 20px;">
                    <?php echo $msg; ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <div style="margin-bottom: 15px;">
                    <label>الاسم الكامل</label>
                    <input type="text" name="name" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                </div>
                <div style="margin-bottom: 15px;">
                    <label>البريد الإلكتروني</label>
                    <input type="email" name="email" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                </div>
                <div style="margin-bottom: 15px;">
                    <label>الرسالة</label>
                    <textarea name="message" rows="5" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;"></textarea>
                </div>
                <button type="submit" name="send_msg" class="btn primary-btn" style="width: 100%;">إرسال الرسالة</button>
            </form>
        </div>

    </div>
</div>

<?php include('include/file/footer.php'); ?>