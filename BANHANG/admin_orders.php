<?php
session_start();
require './php/db.php';

// Kiểm tra quyền Admin
if (!isset($_SESSION['admin']) || $_SESSION['admin'] != 1) {
    echo "<script>alert('Bạn không có quyền truy cập!'); window.location.href='index.php';</script>";
    exit();
}

$sql = "SELECT * FROM orders ORDER BY order_date DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý đơn hàng</title>
    <link rel="stylesheet" href="/BANHANG/asset/css/cart.css">
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
            <td><?php echo number_format($row['total_price'], 2); ?> VNĐ</td>
            <td><?php echo ucfirst($row['status']); ?></td>
            <td>
                <?php if ($row['status'] == 'pending'): ?>
                    <a href="admin_update_order.php?order_id=<?php echo $row['order_id']; ?>&status=processing">Xác nhận</a> |
                    <a href="admin_update_order.php?order_id=<?php echo $row['order_id']; ?>&status=canceled">Hủy</a>
                <?php elseif ($row['status'] == 'processing'): ?>
                    <a href="admin_update_order.php?order_id=<?php echo $row['order_id']; ?>&status=completed">Hoàn tất</a>
                <?php endif; ?>
                <a href="order_detail.php?order_id=<?php echo $row['order_id']; ?>">Xem</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>

<!-- PHÂN QUYỀN ADMIN -->
