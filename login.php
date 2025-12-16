<?php
session_start();
include 'config.php';

if (isset($_SESSION['login_error'])) {
    $login_error = $_SESSION['login_error'];
    unset($_SESSION['login_error']);
} else {
    $login_error = '';
}

if (isset($_SESSION['signup_success'])) {
    $signup_success = $_SESSION['signup_success'];
    unset($_SESSION['signup_success']);
} else {
    $signup_success = '';
}

// Nếu đã đăng nhập, chuyển đến dashboard
if (isset($_SESSION['admin_id'])) {
    header("Location: " . BASE_URL . "dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - Quản lý Sinh viên</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .login-container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
        }
        
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
            font-size: 28px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 500;
        }
        
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            transition: border-color 0.3s;
        }
        
        input[type="text"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        button {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s;
        }
        
        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        
        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 20px;
            border: 1px solid #f5c6cb;
        }
        
        .info-text {
            text-align: center;
            color: #777;
            font-size: 12px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Đăng nhập</h1>
        
        <?php if ($login_error): ?>
            <div class="error-message"><?php echo $login_error; ?></div>
        <?php endif; ?>
        
        <?php if ($signup_success): ?>
            <div style="background-color: #d4edda; color: #155724; padding: 12px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #c3e6cb;">
                <?php echo $signup_success; ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="<?php echo BASE_URL; ?>process_login.php">
            <div class="form-group">
                <label for="username">Tên đăng nhập:</label>
                <input type="text" id="username" name="username" required>
            </div>
            
            <div class="form-group">
                <label for="password">Mật khẩu:</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit">Đăng nhập</button>
        </form>
        
        <div class="info-text">
            <p><strong>Tài khoản demo:</strong></p>
            <p>Username: admin</p>
            <p>Password: 123456</p>
        </div>
        
        <div style="text-align: center; margin-top: 20px; color: #666;">
            <p>Chưa có tài khoản? <a href="<?php echo BASE_URL; ?>signup.php" style="color: #667eea; text-decoration: none; font-weight: 600;">Đăng ký ngay</a></p>
        </div>
    </div>
</body>
</html>
