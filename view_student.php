<?php
session_start();
include 'config.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: " . BASE_URL . "login.php");
    exit();
}

$error = '';
$student = null;

if (!isset($_GET['id'])) {
    header("Location: " . BASE_URL . "dashboard.php");
    exit();
}

$id = $_GET['id'];

// Lấy thông tin sinh viên
$sql = "SELECT * FROM students WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    header("Location: " . BASE_URL . "dashboard.php");
    exit();
}

$student = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết sinh viên - <?php echo $student['fullname']; ?></title>
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
            max-width: 900px;
            margin: 30px auto;
            padding: 0 20px;
        }
        
        .back-button {
            display: inline-block;
            margin-bottom: 20px;
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s;
        }
        
        .back-button:hover {
            color: #764ba2;
        }
        
        .detail-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .student-name {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 10px;
        }
        
        .student-id {
            font-size: 18px;
            opacity: 0.9;
            letter-spacing: 1px;
        }
        
        .card-body {
            padding: 40px;
        }
        
        .info-section {
            margin-bottom: 40px;
            padding-bottom: 30px;
            border-bottom: 2px solid #f0f0f0;
        }
        
        .info-section:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        
        .section-title {
            font-size: 18px;
            font-weight: 600;
            color: #667eea;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }
        
        .info-item {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #667eea;
        }
        
        .info-label {
            font-size: 12px;
            color: #999;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
        }
        
        .info-value {
            font-size: 16px;
            color: #333;
            font-weight: 500;
        }
        
        .action-buttons {
            display: flex;
            gap: 15px;
            margin-top: 40px;
            justify-content: center;
        }
        
        .btn {
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: transform 0.2s;
            display: inline-block;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        
        .btn-success {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            color: white;
        }
        
        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(17, 153, 142, 0.4);
        }
        
        .btn-danger {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            color: white;
        }
        
        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(250, 112, 154, 0.4);
        }
        
        .empty-value {
            color: #999;
            font-style: italic;
        }
        
        .status-badge {
            display: inline-block;
            background: #d4edda;
            color: #155724;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        
        @media (max-width: 768px) {
            .card-header {
                padding: 20px;
            }
            
            .student-name {
                font-size: 24px;
            }
            
            .card-body {
                padding: 20px;
            }
            
            .info-grid {
                grid-template-columns: 1fr;
            }
            
            .action-buttons {
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
                text-align: center;
            }
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
        <a href="<?php echo BASE_URL; ?>dashboard.php" class="back-button">← Quay lại danh sách</a>
        
        <div class="detail-card">
            <div class="card-header">
                <div class="student-name"><?php echo htmlspecialchars($student['fullname']); ?></div>
                <div class="student-id">MSSV: <?php echo htmlspecialchars($student['student_id']); ?></div>
            </div>
            
            <div class="card-body">
                <!-- Thông tin cá nhân -->
                <div class="info-section">
                    <div class="section-title">👤 Thông tin cá nhân</div>
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">Mã số sinh viên</div>
                            <div class="info-value"><?php echo htmlspecialchars($student['student_id']); ?></div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Họ tên</div>
                            <div class="info-value"><?php echo htmlspecialchars($student['fullname']); ?></div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Trạng thái</div>
                            <div class="info-value">
                                <span class="status-badge">✓ Hoạt động</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Thông tin liên hệ -->
                <div class="info-section">
                    <div class="section-title">📧 Thông tin liên hệ</div>
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">Email</div>
                            <div class="info-value">
                                <?php echo $student['email'] ? htmlspecialchars($student['email']) : '<span class="empty-value">Chưa cập nhật</span>'; ?>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Số điện thoại</div>
                            <div class="info-value">
                                <?php echo $student['phone'] ? htmlspecialchars($student['phone']) : '<span class="empty-value">Chưa cập nhật</span>'; ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Thông tin học tập -->
                <div class="info-section">
                    <div class="section-title">🎓 Thông tin học tập</div>
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">Lớp</div>
                            <div class="info-value"><?php echo htmlspecialchars($student['class']); ?></div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Năm nhập học</div>
                            <div class="info-value"><?php echo htmlspecialchars($student['year']); ?></div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Khóa học</div>
                            <div class="info-value">K<?php echo substr($student['year'], 2); ?></div>
                        </div>
                    </div>
                </div>
                
                <!-- Thông tin hệ thống -->
                <div class="info-section">
                    <div class="section-title">⏰ Thông tin hệ thống</div>
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">Ngày tạo</div>
                            <div class="info-value"><?php echo date('d/m/Y H:i', strtotime($student['created_at'])); ?></div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Cập nhật lần cuối</div>
                            <div class="info-value"><?php echo date('d/m/Y H:i', strtotime($student['updated_at'])); ?></div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">ID hệ thống</div>
                            <div class="info-value">#<?php echo $student['id']; ?></div>
                        </div>
                    </div>
                </div>
                
                <!-- Nút hành động -->
                <div class="action-buttons">
                    <a href="<?php echo BASE_URL; ?>edit_student.php?id=<?php echo $student['id']; ?>" class="btn btn-success">
                        ✏️ Chỉnh sửa
                    </a>
                    <a href="<?php echo BASE_URL; ?>dashboard.php" class="btn btn-primary">
                        📋 Danh sách
                    </a>
                    <a href="<?php echo BASE_URL; ?>delete_student.php?id=<?php echo $student['id']; ?>" class="btn btn-danger" onclick="return confirm('Bạn chắc chắn muốn xóa sinh viên này?')">
                        🗑️ Xóa
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
