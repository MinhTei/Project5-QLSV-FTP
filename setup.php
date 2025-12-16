<?php
// Script tạo database và tables
$servername = "localhost";
$username = "root";
$password = "";

// Kết nối MySQL (không có database)
$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
    die("Kết nối database thất bại: " . $conn->connect_error);
}

// Tạo database
$sql = "CREATE DATABASE IF NOT EXISTS student_management";
if ($conn->query($sql) === FALSE) {
    echo "Lỗi tạo database: " . $conn->error;
} else {
    echo "Database created hoặc đã tồn tại<br>";
}

// Chọn database
$conn->select_db("student_management");

// Tạo bảng admin
$admin_sql = "CREATE TABLE IF NOT EXISTS admin (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($admin_sql) === FALSE) {
    echo "Lỗi tạo bảng admin: " . $conn->error;
} else {
    echo "Bảng admin created hoặc đã tồn tại<br>";
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
)";

if ($conn->query($students_sql) === FALSE) {
    echo "Lỗi tạo bảng students: " . $conn->error;
} else {
    echo "Bảng students created hoặc đã tồn tại<br>";
}

// Thêm tài khoản admin mặc định (nếu chưa có)
$check_admin = "SELECT * FROM admin WHERE username = 'admin'";
$result = $conn->query($check_admin);

if ($result->num_rows == 0) {
    // Mật khẩu: 123456 (đã hash bằng password_hash)
    $hashed_password = password_hash("123456", PASSWORD_DEFAULT);
    $insert_admin = "INSERT INTO admin (username, password) VALUES ('admin', ?)";
    $stmt = $conn->prepare($insert_admin);
    $stmt->bind_param("s", $hashed_password);
    
    if ($stmt->execute()) {
        echo "Tài khoản admin mặc định được tạo (username: admin, password: 123456)<br>";
    } else {
        echo "Lỗi tạo tài khoản admin: " . $conn->error;
    }
}

echo "<br><strong>✅ Cập nhật database thành công!</strong><br>";
echo "Bạn có thể truy cập: <a href='login.php'>http://localhost/qlsv_ftp_project/login.php</a>";

$conn->close();
?>
