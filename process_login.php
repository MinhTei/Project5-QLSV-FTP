<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Truy vấn database kiểm tra admin
    $sql = "SELECT * FROM admin WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Kiểm tra mật khẩu
        if (password_verify($password, $row['password'])) {
            $_SESSION['admin_id'] = $row['id'];
            $_SESSION['admin_name'] = $row['username'];
            header("Location: " . BASE_URL . "dashboard.php");
            exit();
        } else {
            $_SESSION['login_error'] = "Mật khẩu không đúng!";
            header("Location: " . BASE_URL . "login.php");
            exit();
        }
    } else {
        $_SESSION['login_error'] = "Tên đăng nhập không tồn tại!";
        header("Location: " . BASE_URL . "login.php");
        exit();
    }
}
?>
