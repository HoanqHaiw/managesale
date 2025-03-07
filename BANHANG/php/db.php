<?php
$servername = "localhost";  // Hoặc IP của máy chủ CSDL
$username = "root";         // Tài khoản MySQL
$password = "";             // Mật khẩu MySQL (để trống nếu dùng XAMPP)
$database = "myphamstore";   // Tên CSDL của bạn

// Kết nối MySQL
$conn = new mysqli($servername, $username, $password, $database);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die(" Kết nối thất bại: " . $conn->connect_error);
} else {
    echo "";
}

// Đặt mã hóa UTF-8 để tránh lỗi tiếng Việt
$conn->set_charset("utf8");
?>
