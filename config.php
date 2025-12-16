<?php
// Cấu hình base URL
define('BASE_URL', 'http://localhost/qlsv_ftp_project/');

// Detect môi trường (LOCAL hoặc PRODUCTION)
$is_local = (strpos($_SERVER['HTTP_HOST'], 'localhost') !== false || 
             strpos($_SERVER['HTTP_HOST'], '127.0.0.1') !== false);

// Cấu hình database dựa trên môi trường
if ($is_local) {
    // Cấu hình LOCAL (WAMP)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "if0_40696768_qlsv_db";
} else {
    // Cấu hình PRODUCTION (Infinityfree)
    $servername = "sql310.infinityfree.com";
    $username = "if0_40696768";
    $password = "qohTKq2Nd8vT";
    $dbname = "if0_40696768_qlsv_db";
}

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối database thất bại: " . $conn->connect_error);
}

// Thiết lập charset
$conn->set_charset("utf8");
?>
