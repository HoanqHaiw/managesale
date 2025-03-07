<?php
session_start();
require './php/db.php';

if (!isset($_SESSION['admin']) || $_SESSION['admin'] != 1) {
    echo "<script>alert('Bạn không có quyền truy cập!'); window.location.href='index.php';</script>";
    exit();
}

if (!isset($_GET['order_id']) || !isset($_GET['status'])) {
    echo "<script>alert('Dữ liệu không hợp lệ!'); window.location.href='admin_orders.php';</script>";
    exit();
}

$order_id = intval($_GET['order_id']);
$status = $_GET['status'];

$valid_status = ['pending', 'processing', 'completed', 'canceled'];
if (!in_array($status, $valid_status)) {
    echo "<script>alert('Trạng thái không hợp lệ!'); window.location.href='admin_orders.php';</script>";
    exit();
}

// Cập nhật trạng thái đơn hàng
$sql = "UPDATE orders SET status = ? WHERE order_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $status, $order_id);
$stmt->execute();

echo "<script>alert('Cập nhật thành công!'); window.location.href='admin_orders.php';</script>";
?>



<!-- Xem danh sách đơn hàng.
Xác nhận đơn hàng (Chuyển pending → processing).
Hoàn tất đơn hàng (Chuyển processing → completed).
Hủy đơn hàng nếu cần (canceled).
Xem chi tiết đơn hàng -->