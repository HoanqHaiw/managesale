<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Xử lý thêm sản phẩm vào giỏ hàng
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"), true);

    if ($data["action"] == "add") {
        $productId = $data["product_id"];
        $productName = $data["product_name"];
        $productPrice = $data["product_price"];
        $quantity = intval($data["quantity"]);

        $found = false;
        foreach ($_SESSION['cart'] as &$item) {
            if ($item["product_id"] == $productId) {
                $item["quantity"] += $quantity;
                $item["total_price"] = $item["product_price"] * $item["quantity"];
                $found = true;
                break;
            }
        }

        if (!$found) {
            $_SESSION['cart'][] = [
                "product_id" => $productId,
                "product_name" => $productName,
                "product_price" => $productPrice,
                "quantity" => $quantity,
                "total_price" => $productPrice * $quantity
            ];
        }

        echo json_encode(["message" => "Sản phẩm đã được thêm vào giỏ hàng!"]);
        exit;
    }
}

// Xem giỏ hàng
if (isset($_GET["action"]) && $_GET["action"] == "view") {
    echo json_encode($_SESSION['cart']);
    exit;
}

// Xóa sản phẩm khỏi giỏ hàng
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET["action"]) && $_GET["action"] == "remove") {
    $data = json_decode(file_get_contents("php://input"), true);
    $_SESSION['cart'] = array_filter($_SESSION['cart'], function($item) use ($data) {
        return $item["product_id"] != $data["item_id"];
    });

    echo json_encode(["message" => "Sản phẩm đã được xóa!"]);
    exit;
}
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

    <button id="checkoutButton">Thanh toán</button>
    <br>
    <!-- Nút quay lại trang chủ -->
    <button id="homeButton">Quay lại trang chủ</button>
    <script src="/BANHANG/JS/cart.js"></script>
</body>
</html>