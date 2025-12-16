<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Kiểm tra username không để trống
    if (empty($username)) {
        $_SESSION['signup_error'] = "Tên đăng nhập không được để trống!";
        header("Location: " . BASE_URL . "signup.php");
        exit();
    }
    
    // Kiểm tra độ dài username
    if (strlen($username) < 3 || strlen($username) > 50) {
        $_SESSION['signup_error'] = "Tên đăng nhập phải từ 3 đến 50 ký tự!";
        header("Location: " . BASE_URL . "signup.php");
        exit();
    }
    
    // Kiểm tra password không để trống
    if (empty($password)) {
        $_SESSION['signup_error'] = "Mật khẩu không được để trống!";
        header("Location: " . BASE_URL . "signup.php");
        exit();
    }
    
    // Kiểm tra độ dài password
    if (strlen($password) < 6) {
        $_SESSION['signup_error'] = "Mật khẩu phải tối thiểu 6 ký tự!";
        header("Location: " . BASE_URL . "signup.php");
        exit();
    }
    
    // Kiểm tra password match
    if ($password !== $confirm_password) {
        $_SESSION['signup_error'] = "Mật khẩu không khớp!";
        header("Location: " . BASE_URL . "signup.php");
        exit();
    }
    
    // Kiểm tra username đã tồn tại chưa
    $check_sql = "SELECT id FROM admin WHERE username = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("s", $username);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    
    if ($check_result->num_rows > 0) {
        $_SESSION['signup_error'] = "Tên đăng nhập đã tồn tại!";
        header("Location: " . BASE_URL . "signup.php");
        exit();
    }
    
    // Mã hóa mật khẩu
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Thêm tài khoản mới
    $insert_sql = "INSERT INTO admin (username, password) VALUES (?, ?)";
    $insert_stmt = $conn->prepare($insert_sql);
    $insert_stmt->bind_param("ss", $username, $hashed_password);
    
    if ($insert_stmt->execute()) {
        $_SESSION['signup_success'] = "Đăng ký thành công! Vui lòng đăng nhập.";
        header("Location: " . BASE_URL . "login.php");
        exit();
    } else {
        $_SESSION['signup_error'] = "Lỗi khi đăng ký: " . $conn->error;
        header("Location: " . BASE_URL . "signup.php");
        exit();
    }
} else {
    header("Location: " . BASE_URL . "signup.php");
    exit();
}
?>
