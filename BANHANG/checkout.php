<?php
session_start();
include './php/db.php';

// Kiểm tra đăng nhập
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Lấy giỏ hàng của user
$sql = "
    SELECT 
        cart.cart_id,
        products.product_name,
        products.product_price,
        cart.size,
        cart.quantity
    FROM cart
    INNER JOIN products ON cart.product_id = products.product_id
    WHERE cart.user_id = ?
";

$stmt = $conn->prepare($sql);

// Kiểm tra lỗi prepare
if (!$stmt) {
    die('Lỗi prepare SQL: ' . $conn->error);
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thanh toán</title>
    <link rel="stylesheet" href="/BANHANG/asset/css/cart.css"> 
</head>
<body>
    <h1>🛒 Xác nhận đơn hàng</h1>

    <?php if ($result->num_rows > 0): ?>
    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>Tên sản phẩm</th>
                <th>Size</th>
                <th>Số lượng</th>
                <th>Giá tiền</th>
                <th>Thành tiền</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $total = 0;
            while ($row = $result->fetch_assoc()):
                $subtotal = $row['product_price'] * $row['quantity'];
                $total += $subtotal;
            ?>
            <tr>
                <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                <td><?php echo htmlspecialchars($row['size']); ?></td>
                <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                <td><?php echo number_format($row['product_price'], 0, ',', '.') . '₫'; ?></td>
                <td><?php echo number_format($subtotal, 0, ',', '.') . '₫'; ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <h3>Tổng tiền cần thanh toán: <?php echo number_format($total, 0, ',', '.') . '₫'; ?></h3>

    <form method="post" action="process_checkout.php">
        <h2>Thông tin nhận hàng</h2>
        <label>Họ và tên:</label><br>
        <input type="text" name="fullname" required><br><br>

        <label>Địa chỉ:</label><br>
        <input type="text" name="address" required><br><br>

        <label>Số điện thoại:</label><br>
        <input type="text" name="phone" required><br><br>

        <button type="submit">✅ Xác nhận đặt hàng</button>
    </form>

    <br>
    <a href="cart.php"><button>🔙 Quay lại giỏ hàng</button></a>

    <?php else: ?>
    <p>❌ Không có sản phẩm nào để thanh toán.</p>
    <a href="index.php"><button>Quay lại mua sắm</button></a>
    <?php endif; ?>

</body>
</html>
