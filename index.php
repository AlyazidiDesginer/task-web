<?php
require 'authentication.php'; // admin authentication check 

// auth check
if(isset($_SESSION['admin_id'])){
  $user_id = $_SESSION['admin_id'];
  $user_name = $_SESSION['admin_name'];
  $security_key = $_SESSION['security_key'];
  if ($user_id != NULL && $security_key != NULL) {
    header('Location: task-list.php');
  }
}

$message = ''; // متغير لتخزين رسالة الخطأ

if(isset($_POST['login_btn'])){
 $message = $obj_admin->admin_login_check($_POST);
}

?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول</title>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Tajawal', sans-serif;
        }

        body {
            background: #000;
            position: relative;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            direction: rtl;
            padding: 20px;
        }

        body::before {
            content: "";
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0.5;
            width: 100%;
            height: 100%;
            background: url("images/hero-img.jpg");
            background-position: center;
            z-index: -1;
        }

        nav {
            position: fixed;
            padding: 25px 60px;
            z-index: 1;
        }

        nav a img {
            width: 100px;
            height: 100px;
        }

        .form-wrapper {
            border-radius: 4px;
            padding: 40px;
            width: 100%;
            max-width: 450px;
            background: rgba(0, 0, 0, .75);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            z-index: 2;
        }

        .form-wrapper h2 {
            color: #fff;
            font-size: 2rem;
            text-align: center;
        }

        .form-wrapper form {
            margin: 25px 0;
        }

        .form-control {
            height: 50px;
            position: relative;
            margin-bottom: 16px;
        }

        .form-control input {
            height: 100%;
            width: 100%;
            background: #333;
            border: none;
            outline: none;
            border-radius: 4px;
            color: #fff;
            font-size: 1rem;
            padding: 0 20px;
            text-align: right;
        }

        .form-control input:is(:focus, :valid) {
            background: #444;
            padding: 16px 20px 0;
        }

        .form-control label {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 1rem;
            pointer-events: none;
            color: #8c8c8c;
            transition: all 0.1s ease;
        }

        .form-control input:is(:focus, :valid)~label {
            font-size: 0.75rem;
            transform: translateY(-130%);
        }

        form button {
            width: 100%;
            padding: 16px 0;
            font-size: 1rem;
            background: #e50914;
            color: #fff;
            font-weight: 500;
            border-radius: 4px;
            border: none;
            outline: none;
            margin: 25px 0 10px;
            cursor: pointer;
            transition: 0.1s ease;
        }

        form button:hover {
            background: #c40812;
        }

        .form-wrapper a {
            text-decoration: none;
        }

        .form-wrapper a:hover {
            text-decoration: underline;
        }

        .form-wrapper :where(label, p, small, a) {
            color: #b3b3b3;
        }

        form .form-help {
            display: flex;
            justify-content: space-between;
        }

        form .remember-me {
            display: flex;
        }

        form .remember-me input {
            margin-left: 5px;
            accent-color: #b3b3b3;
        }

        form .form-help :where(label, a) {
            font-size: 0.9rem;
        }

        .form-wrapper p a {
            color: #fff;
        }

        .form-wrapper small {
            display: block;
            margin-top: 15px;
            color: #b3b3b3;
            text-align: center;
        }

        .form-wrapper small a {
            color: #0071eb;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #f5c6cb;
            border-radius: 4px;
            text-align: center;
        }

        @media (max-width: 740px) {
            body::before {
                display: none;
            }

            nav, .form-wrapper {
                padding: 20px;
            }

            nav a img {
                width: 80px;
                height: 80px;
            }

            .form-wrapper {
                width: 100%;
            }

            .form-wrapper form {
                margin: 25px 0 40px;
            }
        }
    </style>
</head>
<body>
<nav>
    <!-- شعار الموقع -->
</nav>

<div class="form-wrapper">
    <h2>نظام إدارة المهام </h2>
    <form action="" method="POST">
        <div class="form-control">
            <input type="text" name="username" required>
            <label>اسم المستخدم</label>
        </div>
        <div class="form-control">
            <input type="password" name="admin_password" required>
            <label>كلمة المرور</label>
        </div>
        <button type="submit" name="login_btn">تسجيل الدخول</button>
        <?php if (!empty($message)): ?>
            <div id="error-message" class="error"><?php echo $message; ?></div>
        <?php endif; ?>
    </form>
    <div class="test-credentials">
        <h3>تجربة تسجيل الدخول</h3>
        <p>
            اسم المستخدم: <span id="test-username">admin</span>
            <button onclick="copyToClipboard('test-username')">نسخ اسم المستخدم</button>
        </p>
        <p>
            كلمة المرور: <span id="test-password">mohammed</span>
            <button onclick="copyToClipboard('test-password')">نسخ كلمة المرور</button>
        </p>
    </div>
</div>

<script>
    function copyToClipboard(id) {
        var text = document.getElementById(id).innerText;
        var textarea = document.createElement("textarea");
        textarea.value = text;
        document.body.appendChild(textarea);
        textarea.select();
        document.execCommand("copy");
        document.body.removeChild(textarea);
        alert("تم نسخ " + text + " إلى الحافظة");
    }
</script>

<style>
    .test-credentials {
        margin-top: 20px;
    }

    .test-credentials h3 {
        margin-bottom: 10px;
    }

    .test-credentials p {
        margin-bottom: 10px;
    }

    .test-credentials button {
        margin-left: 10px;
    }
</style>



<?php include("include/footer.php"); ?>

<script>
    window.onload = function() {
        setTimeout(function() {
            var errorMessage = document.getElementById('error-message');
            if (errorMessage) {
                errorMessage.style.display = 'none';
            }
        }, 3000); // إخفاء الرسالة بعد 3 ثواني
    }
</script>

</body>
</html>
