<?php
// login.php
session_start();
include('include/connected.php');
include('include/file/header.php');

// إذا كان المستخدم مسجل دخول مسبقاً، نوجهه حسب نوعه
if(isset($_SESSION['user_id'])) {
    if($_SESSION['user_type'] == 'مدير') {
        header("Location: admin/adminpanel.php");
    } else {
        header("Location: index.php");
    }
    exit();
}

$error = "";

if(isset($_POST['login_btn'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

if (empty($email) || empty($password)) {
    $error = "الرجاء إدخال البريد الإلكتروني وكلمة المرور";
} else {
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if($user && password_verify($password, $user['password'])) {
        // تسجيل بيانات الجلسة
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_type'] = $user['user_type'];
        $_SESSION['first_name'] = $user['first_name'];

        // التوجيه حسب الصلاحية
        if($user['user_type'] == 'مدير') {
            header("Location: admin/adminpanel.php"); // صفحة المدير
        } else {
            header("Location: index.php"); // صفحة الموقع
        }
        exit();
    } else {
        $error = "البريد الإلكتروني أو كلمة المرور غير صحيحة";
    }
}
}


?>

<div class="container" style="padding: 60px 0; min-height: 60vh; display: flex; justify-content: center; align-items: center;">
    <div style="background: white; padding: 40px; border-radius: 10px; box-shadow: 0 5px 20px rgba(0,0,0,0.1); width: 100%; max-width: 400px;">
        <h2 style="text-align: center; color: var(--primary-color); margin-bottom: 30px;">تسجيل الدخول</h2>
        
        <?php if($error != ""): ?>
            <div style="background: #ffecec; color: red; padding: 10px; border-radius: 5px; margin-bottom: 20px; text-align: center;">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px;">البريد الإلكتروني</label>
                <input type="email" name="email" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px;">
            </div>
            
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px;">كلمة المرور</label>
                <input type="password" name="password" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px;">
            </div>

            <button type="submit" name="login_btn" class="btn primary-btn" style="width: 100%; font-size: 16px;">دخول</button>
        </form>

        <p style="text-align: center; margin-top: 20px;">
            ليس لديك حساب؟ <a href="register.php" style="color: var(--secondary-color); font-weight: bold;">أنشئ حساب جديد</a>
        </p>
    </div>
</div>

<?php include('include/file/footer.php'); ?>