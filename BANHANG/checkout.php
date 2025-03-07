<?php
session_start();
require './php/db.php';

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Bạn cần đăng nhập để đặt hàng!'); window.location.href='login.php';</script>";
    exit();
}

$user_id = $_SESSION['user_id'];
$cart = $_SESSION['cart']; // Giỏ hàng lưu trong session
$total_price = 0;

foreach ($cart as $item) {
    $total_price += $item['price'] * $item['quantity'];
}

// Thêm đơn hàng vào bảng orders
$sql = "INSERT INTO orders (user_id, total_price) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("id", $user_id, $total_price);
$stmt->execute();
$order_id = $stmt->insert_id;

// Thêm chi tiết đơn hàng
foreach ($cart as $item) {
    $sql_detail = "INSERT INTO order_details (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql_detail);
    $stmt->bind_param("iiid", $order_id, $item['product_id'], $item['quantity'], $item['price']);
    $stmt->execute();
}

// Xóa giỏ hàng sau khi đặt hàng thành công
unset($_SESSION['cart']);

echo "<script>alert('Đặt hàng thành công!'); window.location.href='orders.php';</script>";
?>

<!-- Lấy thông tin giỏ hàng từ session.
Tạo đơn hàng mới trong orders.
Lưu chi tiết từng sản phẩm vào order_details.
Xóa giỏ hàng sau khi đặt hàng thành công. -->