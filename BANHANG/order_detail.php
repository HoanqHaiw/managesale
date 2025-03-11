<!-- XEM CHI TIẾT ĐƠN HÀNG PHÂN QUYỀN MEMBER -->
<?php
session_start();
require './php/db.php';

if (!isset($_GET['order_id'])) {
    echo "<script>alert('Không tìm thấy đơn hàng!'); window.location.href='orders.php';</script>";
    exit();
}

$order_id = intval($_GET['order_id']);
$sql = "SELECT * FROM orderdetails od 
        JOIN products p ON od.product_id = p.product_id 
        WHERE od.order_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chi tiết đơn hàng</title>
    <link rel="stylesheet" href="/BANHANG/asset/css/cart.css">
</head>
<body>
    <h2>Chi tiết đơn hàng</h2>
    <table border="1">
        <tr>
            <th>Sản phẩm</th>
            <th>Số lượng</th>
            <th>Giá</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['product_name']; ?></td>
            <td><?php echo $row['quantity']; ?></td>
            <td><?php echo number_format($row['price'], 2); ?> VNĐ</td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
