<?php
session_start();
include 'config.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: " . BASE_URL . "login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: " . BASE_URL . "dashboard.php");
    exit();
}

$id = $_GET['id'];

// Xóa sinh viên
$sql = "DELETE FROM students WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    $_SESSION['message'] = "Xóa sinh viên thành công!";
} else {
    $_SESSION['message'] = "Lỗi khi xóa sinh viên!";
}

header("Location: " . BASE_URL . "dashboard.php");
exit();
?>
