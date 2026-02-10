<?php
// register.php
session_start();
include('include/connected.php');
include('include/file/header.php');
$msg = "";

if(isset($_POST['register_btn'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $user_type = $_POST['user_type']; // زائر أو وكيل

    // التحقق من أن البريد غير مستخدم مسبقاً
    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->execute([$email]);

    if($check->rowCount() > 0) {
        $msg = "البريد الإلكتروني مسجل مسبقاً!";
    } else {
        // تشفير كلمة المرور
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $insert = $conn->prepare("INSERT INTO users (first_name, last_name, email, phone, password, user_type) VALUES (?, ?, ?, ?, ?, ?)");
        
        if($insert->execute([$first_name, $last_name, $email, $phone, $hashed_password, $user_type])) {
            echo "<script>alert('تم إنشاء الحساب بنجاح! يمكنك تسجيل الدخول الآن.'); window.location.href='login.php';</script>";
        } else {
            $msg = "حدث خطأ أثناء التسجيل، حاول مرة أخرى.";
        }
    }
}


?>

<div class="container" style="padding: 60px 0; display: flex; justify-content: center;">
    <div style="background: white; padding: 40px; border-radius: 10px; box-shadow: 0 5px 20px rgba(0,0,0,0.1); width: 100%; max-width: 500px;">
        <h2 style="text-align: center; color: var(--primary-color); margin-bottom: 30px;">إنشاء حساب جديد</h2>
        
        <?php if($msg != ""): ?>
            <div style="background: #ffecec; color: red; padding: 10px; border-radius: 5px; margin-bottom: 20px; text-align: center;">
                <?php echo $msg; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div style="display: flex; gap: 15px; margin-bottom: 20px;">
                <div style="flex: 1;">
                    <label>الاسم الأول</label>
                    <input type="text" name="first_name" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                </div>
                <div style="flex: 1;">
                    <label>الاسم الأخير</label>
                    <input type="text" name="last_name" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <label>البريد الإلكتروني</label>
                <input type="email" name="email" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
            </div>

            <div style="margin-bottom: 20px;">
                <label>رقم الهاتف</label>
                <input type="text" name="phone" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
            </div>

            <div style="margin-bottom: 20px;">
                <label>كلمة المرور</label>
                <input type="password" name="password" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
            </div>

            <div style="margin-bottom: 30px;">
                <label style="font-weight: bold; color: var(--secondary-color);">نوع الحساب</label>
                <select name="user_type" style="width: 100%; padding: 12px; border: 2px solid var(--secondary-color); border-radius: 5px; background: #fff;">
                    <option value="زائر">زائر (للتصفح والحجز فقط)</option>
                    <option value="وكيل">وكيل عقاري (إضافة وإدارة العقارات)</option>
                </select>
            </div>

            <button type="submit" name="register_btn" class="btn primary-btn" style="width: 100%; font-size: 16px;">تسجيل</button>
        </form>

        <p style="text-align: center; margin-top: 20px;">
            لديك حساب بالفعل؟ <a href="login.php" style="color: var(--secondary-color); font-weight: bold;">سجل دخولك</a>
        </p>
    </div>
</div>

<?php include('include/file/footer.php'); ?>