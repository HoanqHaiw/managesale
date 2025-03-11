<!-- TRANG THANH TOÁN PHÂN QUYỀN MEMBER -->
<?php
session_start();
include './php/db.php';

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit;
}

$cartItems = $_SESSION['cart'];
$totalPrice = array_sum(array_column($cartItems, 'total_price'));

// Xử lý khi người dùng nhấn nút Thanh Toán
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['fullname'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $userId = $_SESSION['user_id'] ?? null;

    // Thêm đơn hàng vào bảng `orders`
    $stmt = $conn->prepare("INSERT INTO orders (user_id, fullname, address, phone, total_amount, order_status) VALUES (?, ?, ?, ?, ?, 'pending')");
    $stmt->bind_param("isssd", $userId, $fullname, $address, $phone, $totalPrice);
    $stmt->execute();
    $orderId = $stmt->insert_id;
    $stmt->close();

    // Thêm sản phẩm vào bảng `orderdetails`
    $stmt = $conn->prepare("INSERT INTO orderdetails (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
    foreach ($cartItems as $item) {
        $stmt->bind_param("iiid", $orderId, $item['product_id'], $item['quantity'], $item['product_price']);
        $stmt->execute();
    }
    $stmt->close();

    // Xóa giỏ hàng
    unset($_SESSION['cart']);

    // Chuyển hướng đến trang thành công
    header("Location: success.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh Toán</title>
    <link rel="stylesheet" href="/BANHANG/asset/css/cart.css">
</head>
<body>

    <h1>Thanh Toán</h1>
    
    <h2>Thông Tin Đơn Hàng</h2>
    <table>
        <thead>
            <tr>
                <th>Tên sản phẩm</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Tổng</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cartItems as $item) : ?>
            <tr>
                <td><?= htmlspecialchars($item['product_name']) ?></td>
                <td><?= number_format($item['product_price'], 0, ',', '.') ?> VND</td>
                <td><?= $item['quantity'] ?></td>
                <td><?= number_format($item['total_price'], 0, ',', '.') ?> VND</td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <p><strong>Tổng tiền: <?= number_format($totalPrice, 0, ',', '.') ?> VND</strong></p>

    <h2>Thông Tin Khách Hàng</h2>
    <form method="POST">
        <label>Họ và tên:</label>
        <input type="text" name="fullname" required>

        <label>Địa chỉ:</label>
        <input type="text" name="address" required>

        <label>Số điện thoại:</label>
        <input type="text" name="phone" required>

        <button type="submit">Xác Nhận Thanh Toán</button>
    </form>
    <button class="homeButton" onclick="window.location.href='index.php'">Trở Về Trang Chủ</button>

</body>
</html>
