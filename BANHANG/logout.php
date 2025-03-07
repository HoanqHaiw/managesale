<?php
session_start(); // Bắt đầu phiên làm việc

// Hủy tất cả session
session_unset();
session_destroy();

// Chuyển hướng về trang đăng nhập
header("Location: index.php");
exit();
?>
