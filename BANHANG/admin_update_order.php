<!-- Xem danh sách đơn hàng.
Xác nhận đơn hàng (Chuyển pending → processing).
Hoàn tất đơn hàng (Chuyển processing → completed).
Hủy đơn hàng nếu cần (canceled).
Xem chi tiết đơn hàng -->
<?php
session_start();
require './php/db.php';

// Kiểm tra quyền Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Bạn không có quyền truy cập!'); window.location.href='index.php';</script>";
    exit();
}

// Kiểm tra nếu có order_id và status được truyền vào
if (!isset($_GET['order_id']) || !isset($_GET['status'])) {
    echo "<script>alert('Dữ liệu không hợp lệ!'); window.location.href='admin_orders.php';</script>";
    exit();
}

$order_id = intval($_GET['order_id']);
$status = $_GET['status']; // ✅ Lấy đúng giá trị status từ URL

// Danh sách trạng thái hợp lệ
$valid_status = ['pending', 'processing', 'completed', 'cancelled'];
if (!in_array($status, $valid_status)) {
    echo "<script>alert('Trạng thái không hợp lệ!'); window.location.href='admin_orders.php';</script>";
    exit();
}

// Cập nhật trạng thái đơn hàng (sửa 'status' thành 'order_status')
$sql = "UPDATE orders SET order_status = ? WHERE order_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $status, $order_id);
$stmt->execute();

echo "<script>alert('Cập nhật thành công!'); window.location.href='admin_orders.php';</script>";
?>
