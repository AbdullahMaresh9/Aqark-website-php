<?php
// admin/admin.php
session_start();
include('../include/connected.php');

// إذا كان مسجلاً للدخول بالفعل كمدير، حوله للوحة التحكم
if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'مدير') {
    header("Location: adminpanel.php");
    exit();
}

$error = "";

if (isset($_POST['login_btn'])) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $error = "الرجاء إدخال البريد الإلكتروني وكلمة المرور";
    } else {
        // البحث عن المستخدم
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // التحقق من كلمة المرور ومن الصلاحية
        if ($user && password_verify($password, $user['password'])) {
            if ($user['user_type'] === 'مدير') {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['first_name'] = $user['first_name'];
                $_SESSION['user_type'] = 'مدير';
                
                header("Location: adminpanel.php");
                exit();
            } else {
                $error = "عذراً، هذا الحساب ليس حساب مدير.";
            }
        } else {
            $error = "البريد الإلكتروني أو كلمة المرور غير صحيحة.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>دخول المدير - عقارك</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-form">
            <h2>لوحة تحكم عقارك</h2>
            <?php if($error): ?>
                <div style="color: red; margin-bottom: 15px; background: #ffe6e6; padding: 10px; border-radius: 5px;">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
            <form method="POST" action="">
                <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="البريد الإلكتروني" required>
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="كلمة المرور" required>
                </div>
                <button type="submit" name="login_btn" class="btn btn-primary" style="width: 100%;">تسجيل الدخول</button>
            </form>
            <br>
            <a href="../index.php" style="color: #3498db; font-size: 14px;">العودة للموقع الرئيسي</a>
        </div>
    </div>
</body>
</html>