<?php
session_start();
include 'config.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: " . BASE_URL . "login.php");
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['student_id'];
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $class = $_POST['class'];
    $year = $_POST['year'];
    
    // Kiểm tra MSSV đã tồn tại chưa
    $check_sql = "SELECT id FROM students WHERE student_id = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("s", $student_id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    
    if ($check_result->num_rows > 0) {
        $error = "MSSV đã tồn tại trong hệ thống!";
    } else {
        // Thêm sinh viên mới
        $sql = "INSERT INTO students (student_id, fullname, email, phone, class, year) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", $student_id, $fullname, $email, $phone, $class, $year);
        
        if ($stmt->execute()) {
            $_SESSION['message'] = "Thêm sinh viên thành công!";
            header("Location: " . BASE_URL . "dashboard.php");
            exit();
        } else {
            $error = "Lỗi khi thêm sinh viên: " . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm sinh viên</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
            color: #333;
        }
        
        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .navbar h1 {
            font-size: 24px;
        }
        
        .navbar .user-info {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .navbar a {
            color: white;
            text-decoration: none;
            background: rgba(255, 255, 255, 0.2);
            padding: 8px 15px;
            border-radius: 5px;
        }
        
        .container {
            max-width: 600px;
            margin: 30px auto;
            padding: 0 20px;
        }
        
        .form-card {
            background: white;
            padding: 30px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .form-card h2 {
            margin-bottom: 25px;
            color: #667eea;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }
        
        input[type="text"],
        input[type="email"],
        input[type="tel"],
        input[type="number"],
        select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            font-family: inherit;
        }
        
        input:focus,
        select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        .button-group {
            display: flex;
            gap: 10px;
            margin-top: 30px;
        }
        
        button, .btn {
            flex: 1;
            padding: 12px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s;
        }
        
        .btn-submit {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            color: white;
        }
        
        .btn-submit:hover {
            transform: translateY(-2px);
        }
        
        .btn-cancel {
            background: #ddd;
            color: #333;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        
        .btn-cancel:hover {
            background: #ccc;
        }
        
        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 20px;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    
    <div class="navbar">
        <h1>📚 Quản lý Sinh viên</h1>
        <div class="user-info">
            <span>Chào, <?php echo $_SESSION['admin_name']; ?></span>
            <a href="<?php echo BASE_URL; ?>logout.php">Đăng xuất</a>
        </div>
    </div>
    
    <div class="container">
        <div class="form-card">
            <h2>Thêm Sinh viên Mới</h2>
            
            <?php if ($error): ?>
                <div class="error-message"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="form-group">
                    <label for="student_id">MSSV *</label>
                    <input type="text" id="student_id" name="student_id" required>
                </div>
                
                <div class="form-group">
                    <label for="fullname">Họ tên *</label>
                    <input type="text" id="fullname" name="fullname" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email">
                </div>
                
                <div class="form-group">
                    <label for="phone">Số điện thoại</label>
                    <input type="tel" id="phone" name="phone">
                </div>
                
                <div class="form-group">
                    <label for="class">Lớp *</label>
                    <input type="text" id="class" name="class" required>
                </div>
                
                <div class="form-group">
                    <label for="year">Năm nhập học *</label>
                    <input type="number" id="year" name="year" min="2000" max="2100" required>
                </div>
                
                <div class="button-group">
                    <button type="submit" class="btn-submit">Thêm sinh viên</button>
                    <a href="<?php echo BASE_URL; ?>dashboard.php" class="btn btn-cancel">Hủy</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
