<!-- XEM DANH SÁCH SẢN PHẨM VÀ ĐIỀU CHỈNH TRẠNG THÁI SẢN PHẨM -->

<?php
session_start();
require './php/db.php';

// Kiểm tra quyền Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Bạn không có quyền truy cập!'); window.location.href='index.php';</script>";
    exit();
}

// Lấy danh sách đơn hàng, sắp xếp theo thời gian đặt hàng mới nhất
$sql = "SELECT * FROM orders ORDER BY order_date DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý đơn hàng</title>
    <link rel="stylesheet" href="./asset/css/cart.css"> <!-- Kiểm tra đường dẫn file CSS -->
</head>
<body>
    <h2>Danh sách đơn hàng</h2>
    <table border="1">
        <tr>
            <th>Mã ĐH</th>
            <th>Người đặt</th>
            <th>Ngày đặt</th>
            <th>Tổng tiền</th>
            <th>Trạng thái</th>
            <th>Hành động</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['order_id']; ?></td>
            <td><?php echo $row['user_id']; ?></td>
            <td><?php echo $row['order_date']; ?></td>
            <td><?php echo number_format($row['total_amount'], 0, ',', '.'); ?> VNĐ</td>
            <td><?php echo ucfirst($row['order_status']); ?></td>
            <td>
                <?php if ($row['order_status'] == 'pending'): ?>
                    <a href="admin_update_order.php?order_id=<?php echo $row['order_id']; ?>&status=processing">Xác nhận</a> |
                    <a href="admin_update_order.php?order_id=<?php echo $row['order_id']; ?>&status=cancelled">Hủy</a>
                <?php elseif ($row['order_status'] == 'processing'): ?>
                    <a href="admin_update_order.php?order_id=<?php echo $row['order_id']; ?>&status=completed">Hoàn tất</a>
                <?php endif; ?>
                <a href="order_detail.php?order_id=<?php echo $row['order_id']; ?>">Xem</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    <a href="index.php" class="btn--home">Trở về trang chủ</a>
</body>
</html>
