<?php
session_start();
echo "<pre>";
print_r($_SESSION);
echo "</pre>";
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ Hàng</title>
    <link rel="stylesheet" href="/BANHANG/asset/css/cart.css">
</head>
<body>
    <h1>Giỏ Hàng Của Bạn</h1>
    <table>
        <thead>
            <tr>
                <th>Tên sản phẩm</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Tổng</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody id="cartItems"></tbody>
    </table>
    <p>Tổng tiền: <span id="totalPrice">0</span></p>
    
    <!-- <p><strong>Tổng tiền: <span id="totalPriceStrong">0</span> VND</strong></p> -->


    <!-- Form nhập thông tin thanh toán -->
    <h2>Thông Tin Thanh Toán</h2>
    <form id="paymentForm">
        <label for="fullname">Họ và tên:</label>
        <input type="text" id="fullname" required><br><br>

        <label for="address">Địa chỉ:</label>
        <input type="text" id="address" required><br><br>

        <label for="phone">Số điện thoại:</label>
        <input type="text" id="phone" required><br><br>

        <button type="submit">Thanh Toán</button>
    </form>

    <br>
    <!-- Nút quay lại trang chủ -->
    <button id="homeButton">Quay lại trang chủ</button>
    <script src="/BANHANG/JS/cart.js"></script>
</body>
</html>
