<?php
session_start();
header('Content-Type: application/json');

// Kiểm tra session có tồn tại không
$response = [
    "isLoggedIn" => isset($_SESSION["user_id"]),
    "user_id" => $_SESSION["user_id"] ?? "Chưa đăng nhập",
    "role" => $_SESSION["role"] ?? "Không có vai trò"
];

echo json_encode($response);
?>
