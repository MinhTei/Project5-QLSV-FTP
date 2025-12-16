<?php
// Script tạo database cho LOCAL (WAMP) và PRODUCTION (Infinityfree)

$is_production = isset($_GET['prod']);

if ($is_production) {
    // PRODUCTION - Infinityfree
    $servername = "sql310.infinityfree.com";
    $username = "if0_40696768";
    $password = "qohTKq2Nd8vT";
    $dbname = "if0_40696768_qlsv_db";
    $env_name = "PRODUCTION (Infinityfree)";
} else {
    // LOCAL - WAMP
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "if0_40696768_qlsv_db";
    $env_name = "LOCAL (WAMP)";
}

echo "<h2>🚀 Tạo Database - $env_name</h2>";
echo "<p>Kết nối tới: <strong>$servername</strong></p>";
echo "<hr>";

// Kết nối MySQL (không có database)
$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
    echo "<p style='color: red;'><strong>❌ Lỗi kết nối:</strong> " . $conn->connect_error . "</p>";
    echo "<p>Kiểm tra:</p>";
    echo "<ul>";
    echo "<li>Server: $servername</li>";
    echo "<li>Username: $username</li>";
    if ($is_production) {
        echo "<li>Có kết nối internet không?</li>";
        echo "<li>Credentials Infinityfree có đúng không?</li>";
    } else {
        echo "<li>WAMP MySQL đang chạy không?</li>";
    }
    echo "</ul>";
    exit();
}

echo "<p>✅ Kết nối MySQL thành công</p>";

// Tạo database
$sql = "CREATE DATABASE IF NOT EXISTS $dbname CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
if ($conn->query($sql) === FALSE) {
    echo "<p style='color: red;'><strong>❌ Lỗi tạo database:</strong> " . $conn->error . "</p>";
} else {
    echo "<p>✅ Database <strong>$dbname</strong> created/exists</p>";
}

// Chọn database
$conn->select_db($dbname);

// Tạo bảng admin
$admin_sql = "CREATE TABLE IF NOT EXISTS admin (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

if ($conn->query($admin_sql) === FALSE) {
    echo "<p style='color: red;'><strong>❌ Lỗi tạo bảng admin:</strong> " . $conn->error . "</p>";
} else {
    echo "<p>✅ Bảng <strong>admin</strong> created/exists</p>";
}

// Tạo bảng students
$students_sql = "CREATE TABLE IF NOT EXISTS students (
    id INT PRIMARY KEY AUTO_INCREMENT,
    student_id VARCHAR(50) UNIQUE NOT NULL,
    fullname VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    phone VARCHAR(20),
    class VARCHAR(50),
    year INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

if ($conn->query($students_sql) === FALSE) {
    echo "<p style='color: red;'><strong>❌ Lỗi tạo bảng students:</strong> " . $conn->error . "</p>";
} else {
    echo "<p>✅ Bảng <strong>students</strong> created/exists</p>";
}

// Thêm tài khoản admin mặc định
$check_admin = "SELECT * FROM admin WHERE username = 'admin'";
$result = $conn->query($check_admin);

if ($result->num_rows == 0) {
    $hashed_password = password_hash("123456", PASSWORD_DEFAULT);
    $insert_admin = "INSERT INTO admin (username, password) VALUES ('admin', ?)";
    $stmt = $conn->prepare($insert_admin);
    $stmt->bind_param("s", $hashed_password);
    
    if ($stmt->execute()) {
        echo "<p>✅ Tài khoản admin được tạo (username: admin, password: 123456)</p>";
    } else {
        echo "<p style='color: red;'><strong>❌ Lỗi tạo tài khoản admin:</strong> " . $conn->error . "</p>";
    }
} else {
    echo "<p>ℹ️ Tài khoản admin đã tồn tại</p>";
}

// Thêm dữ liệu mẫu
$check_students = "SELECT COUNT(*) as count FROM students";
$result = $conn->query($check_students);
$row = $result->fetch_assoc();

if ($row['count'] == 0) {
    $sample_students = [
        ['SV001', 'Nguyễn Văn A', 'nguyenvana@email.com', '0987654321', 'K19-CNTT-01', 2019],
        ['SV002', 'Trần Thị B', 'tranthib@email.com', '0987654322', 'K19-CNTT-01', 2019],
        ['SV003', 'Lê Minh C', 'leminhc@email.com', '0987654323', 'K19-CNTT-02', 2019],
        ['SV004', 'Phạm Quỳnh D', 'phamquynhd@email.com', '0987654324', 'K19-CNTT-02', 2019],
        ['SV005', 'Hoàng Anh E', 'hoanganhe@email.com', '0987654325', 'K19-CNTT-03', 2019],
        ['SV006', 'Vũ Thu F', 'vuthuf@email.com', '0987654326', 'K20-CNTT-01', 2020],
        ['SV007', 'Đặng Minh G', 'dangminhg@email.com', '0987654327', 'K20-CNTT-01', 2020],
        ['SV008', 'Bùi Thúy H', 'buithuyh@email.com', '0987654328', 'K20-CNTT-02', 2020],
        ['SV009', 'Tô Hữu I', 'tohuui@email.com', '0987654329', 'K20-CNTT-02', 2020],
        ['SV010', 'Nông Văn J', 'nongvanj@email.com', '0987654330', 'K21-CNTT-01', 2021],
    ];
    
    $insert_student_sql = "INSERT INTO students (student_id, fullname, email, phone, class, year) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insert_student_sql);
    
    $count = 0;
    foreach ($sample_students as $student) {
        $stmt->bind_param("sssssi", $student[0], $student[1], $student[2], $student[3], $student[4], $student[5]);
        if ($stmt->execute()) {
            $count++;
        }
    }
    
    echo "<p>✅ Dữ liệu mẫu được thêm vào ($count sinh viên)</p>";
} else {
    echo "<p>ℹ️ Dữ liệu sinh viên đã tồn tại (" . $row['count'] . " sinh viên)</p>";
}

echo "<hr>";
echo "<h3>✅ Setup thành công!</h3>";
echo "<p>Bạn có thể truy cập: <a href='../login.php'>http://localhost/qlsv_ftp_project/login.php</a></p>";
echo "<p><strong>Tài khoản:</strong></p>";
echo "<ul>";
echo "<li>Username: <strong>admin</strong></li>";
echo "<li>Password: <strong>123456</strong></li>";
echo "</ul>";

echo "<hr>";
echo "<p><strong>Liên kết:</strong></p>";
if ($is_production) {
    echo "<a href='setup.php'>← Setup LOCAL (WAMP)</a>";
} else {
    echo "<a href='setup.php?prod=1'>Setup PRODUCTION (Infinityfree) →</a>";
}

$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Database Setup</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        h2, h3 {
            color: #333;
        }
        p, li {
            color: #666;
            line-height: 1.6;
        }
        a {
            color: #667eea;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        hr {
            border: none;
            border-top: 2px solid #ddd;
            margin: 20px 0;
        }
        ul {
            margin-left: 20px;
        }
    </style>
</head>
<body>
</body>
</html>
