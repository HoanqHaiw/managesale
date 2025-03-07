<?php
include "../php/db.php"; // Kết nối database

$fullname = "Admin";
$email = "admin@gmail.com";
$phone = "0123456789";
$password = "admin123"; // Mật khẩu gốc
$hashed_password = password_hash($password, PASSWORD_DEFAULT); // Hash mật khẩu

$sql = "INSERT INTO users (fullname, phone, email, password, role) VALUES (?, ?, ?, ?, 'admin')";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $fullname, $phone, $email, $hashed_password);

if ($stmt->execute()) {
    echo "Thêm tài khoản admin thành công!";
} else {
    echo "Lỗi: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
