<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký - Quản lý Sinh viên</title>
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
        
        .signup-container {
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
        
        .success-message {
            background-color: #d4edda;
            color: #155724;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
        }
        
        .login-link {
            text-align: center;
            margin-top: 20px;
            color: #666;
        }
        
        .login-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s;
        }
        
        .login-link a:hover {
            color: #764ba2;
        }
        
        .password-requirements {
            background: #f0f0f0;
            padding: 12px;
            border-radius: 5px;
            margin-top: 15px;
            font-size: 12px;
            color: #666;
        }
        
        .password-requirements ul {
            margin-left: 20px;
            margin-top: 8px;
        }
        
        .password-requirements li {
            margin-bottom: 4px;
        }
    </style>
</head>
<body>
    <div class="signup-container">
        <h1>Đăng ký</h1>
        
        <?php
        session_start();
        include 'config.php';
        
        $error = '';
        $success = '';
        
        // Nếu đã đăng nhập, chuyển đến dashboard
        if (isset($_SESSION['admin_id'])) {
            header("Location: " . BASE_URL . "dashboard.php");
            exit();
        }
        
        if (isset($_SESSION['signup_error'])) {
            $error = $_SESSION['signup_error'];
            unset($_SESSION['signup_error']);
        }
        
        if (isset($_SESSION['signup_success'])) {
            $success = $_SESSION['signup_success'];
            unset($_SESSION['signup_success']);
        }
        
        if ($error) {
            echo '<div class="error-message">' . $error . '</div>';
        }
        
        if ($success) {
            echo '<div class="success-message">' . $success . '</div>';
        }
        ?>
        
        <form method="POST" action="<?php echo BASE_URL; ?>process_signup.php">
            <div class="form-group">
                <label for="username">Tên đăng nhập:</label>
                <input type="text" id="username" name="username" required minlength="3" maxlength="50" placeholder="Tối thiểu 3 ký tự">
            </div>
            
            <div class="form-group">
                <label for="password">Mật khẩu:</label>
                <input type="password" id="password" name="password" required minlength="6" placeholder="Tối thiểu 6 ký tự">
            </div>
            
            <div class="form-group">
                <label for="confirm_password">Xác nhận mật khẩu:</label>
                <input type="password" id="confirm_password" name="confirm_password" required minlength="6" placeholder="Nhập lại mật khẩu">
            </div>
            
            <button type="submit">Đăng ký</button>
        </form>
        
        <div class="password-requirements">
            <strong>Yêu cầu mật khẩu:</strong>
            <ul>
                <li>Tối thiểu 6 ký tự</li>
                <li>Có thể chứa chữ, số, ký tự đặc biệt</li>
            </ul>
        </div>
        
        <div class="login-link">
            <p>Đã có tài khoản? <a href="<?php echo BASE_URL; ?>login.php">Đăng nhập</a></p>
        </div>
    </div>
</body>
</html>
