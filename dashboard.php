<?php
session_start();
include 'config.php';

// Kiểm tra đăng nhập
if (!isset($_SESSION['admin_id'])) {
    header("Location: " . BASE_URL . "login.php");
    exit();
}

// Xử lý thông báo
$message = '';
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}

// Lấy danh sách sinh viên
$sql = "SELECT * FROM students ORDER BY id DESC";
$result = $conn->query($sql);
$students = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $students[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách sinh viên</title>
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
            transition: background 0.3s;
        }
        
        .navbar a:hover {
            background: rgba(255, 255, 255, 0.3);
        }
        
        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        
        .header h2 {
            font-size: 28px;
        }
        
        .btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: transform 0.2s;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        
        .btn-success {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        }
        
        .btn-warning {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            padding: 8px 15px;
            font-size: 14px;
        }
        
        .btn-danger {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            padding: 8px 15px;
            font-size: 14px;
        }
        
        .btn-info {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 8px 15px;
            font-size: 14px;
        }
        
        .search-box {
            margin-bottom: 20px;
        }
        
        .search-box input {
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 300px;
            font-size: 14px;
        }
        
        table {
            width: 100%;
            background: white;
            border-collapse: collapse;
            border-radius: 5px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        th {
            background: #f8f9fa;
            padding: 15px;
            text-align: left;
            font-weight: 600;
            border-bottom: 2px solid #ddd;
        }
        
        td {
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
        }
        
        tr:hover {
            background: #f9f9f9;
        }
        
        .actions {
            display: flex;
            gap: 10px;
        }
        
        .empty-message {
            text-align: center;
            padding: 40px;
            background: white;
            border-radius: 5px;
            color: #999;
        }
        
        .success-message {
            background-color: #d4edda;
            color: #155724;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
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
        <?php if ($message): ?>
            <div class="success-message"><?php echo $message; ?></div>
        <?php endif; ?>
        
        <div class="header">
            <h2>Danh sách Sinh viên</h2>
            <a href="<?php echo BASE_URL; ?>add_student.php" class="btn btn-success">+ Thêm sinh viên</a>
        </div>
        
        <div class="search-box">
            <input type="text" id="searchInput" placeholder="Tìm kiếm theo tên hoặc MSSV...">
        </div>
        
        <?php if (count($students) > 0): ?>
            <table id="studentsTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>MSSV</th>
                        <th>Họ tên</th>
                        <th>Email</th>
                        <th>Số điện thoại</th>
                        <th>Lớp</th>
                        <th>Năm nhập học</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($students as $student): ?>
                        <tr>
                            <td><?php echo $student['id']; ?></td>
                            <td><?php echo $student['student_id']; ?></td>
                            <td><?php echo $student['fullname']; ?></td>
                            <td><?php echo $student['email']; ?></td>
                            <td><?php echo $student['phone']; ?></td>
                            <td><?php echo $student['class']; ?></td>
                            <td><?php echo $student['year']; ?></td>
                            <td>
                                <div class="actions">
                                    <a href="<?php echo BASE_URL; ?>view_student.php?id=<?php echo $student['id']; ?>" class="btn btn-info">Xem</a>
                                    <a href="<?php echo BASE_URL; ?>edit_student.php?id=<?php echo $student['id']; ?>" class="btn btn-warning">Sửa</a>
                                    <a href="<?php echo BASE_URL; ?>delete_student.php?id=<?php echo $student['id']; ?>" class="btn btn-danger" onclick="return confirm('Bạn chắc chắn muốn xóa?')">Xóa</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="empty-message">
                <p>Chưa có sinh viên nào. <a href="<?php echo BASE_URL; ?>add_student.php">Thêm sinh viên mới</a></p>
            </div>
        <?php endif; ?>
    </div>
    
    <script>
        document.getElementById('searchInput').addEventListener('keyup', function() {
            const searchText = this.value.toLowerCase();
            const table = document.getElementById('studentsTable');
            if (!table) return;
            
            const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
            
            for (let row of rows) {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchText) ? '' : 'none';
            }
        });
    </script>
</body>
</html>
