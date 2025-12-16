<?php
session_start();
include 'config.php';

// Nếu đã đăng nhập, chuyển đến dashboard
if (isset($_SESSION['admin_id'])) {
    header("Location: " . BASE_URL . "dashboard.php");
    exit();
}

// Nếu chưa đăng nhập, chuyển đến trang login
header("Location: " . BASE_URL . "login.php");
exit();
?>
