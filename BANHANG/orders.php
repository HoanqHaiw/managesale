<!-- XEM THOÔNG TIN ĐƠN HÀNG PHÂN QUQUYENF MEMBER -->
<?php
session_start();
require './php/db.php';

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Bạn cần đăng nhập để xem đơn hàng!'); window.location.href='login.php';</script>";
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM orders WHERE user_id = ? ORDER BY order_date DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đơn hàng của tôi</title>
    <link rel="stylesheet" href="/BANHANG/asset/css/cart.css">
</head>
<body>
    <h2>Danh sách đơn hàng</h2>
    <table border="1">
        <tr>
            <th>Mã ĐH</th>
            <th>Ngày đặt</th>
            <th>Tổng tiền</th>
            <th>Trạng thái</th>
            <th>Hành động</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['order_id']; ?></td>
            <td><?php echo $row['order_date']; ?></td>
            <td><?php echo number_format($row['total_amount'], 2); ?> VNĐ</td>
            <td><?php echo ucfirst($row['order_status']); ?></td>
            <td><a href="order_detail.php?order_id=<?php echo $row['order_id']; ?>">Xem</a></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
