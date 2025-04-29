<?php
session_start();

// xoá sản phẩm khỏi giỏ hàng
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET["action"]) && $_GET["action"] == "remove") {
    $data = json_decode(file_get_contents("php://input"), true);
    $_SESSION['cart'] = array_filter($_SESSION['cart'], function($item) use ($data) {
        return $item["product_id"] != $data["item_id"];
    });

    echo json_encode(["message" => "Sản phẩm đã được xóa!"]);
    exit;
}

// Khởi tạo giỏ hàng nếu chưa có
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Hàm tìm sản phẩm trong giỏ hàng
function findCartItem($productId) {
    foreach ($_SESSION['cart'] as $index => $item) {
        if ($item['product_id'] == $productId) {
            return $index;
        }
    }
    return -1;
}

// Xử lý các action
if (isset($_GET['action'])) {
    $action = $_GET['action'];

    switch ($action) {
        case 'add':
            $data = json_decode(file_get_contents('php://input'), true);
            if ($data) {
                $index = findCartItem($data['product_id']);
                if ($index !== -1) {
                    // Nếu sản phẩm đã có, cập nhật số lượng
                    $_SESSION['cart'][$index]['quantity'] += $data['quantity'];
                    $_SESSION['cart'][$index]['total_price'] = $_SESSION['cart'][$index]['quantity'] * $_SESSION['cart'][$index]['product_price'];
                } else {
                    // Thêm mới sản phẩm
                    $_SESSION['cart'][] = [
                        'product_id'   => $data['product_id'],
                        'product_name' => $data['product_name'],
                        'product_price'=> $data['product_price'],
                        'quantity'     => $data['quantity'],
                        'total_price'  => $data['product_price'] * $data['quantity'],
                    ];
                }
                echo json_encode(['message' => 'Đã thêm vào giỏ hàng!']);
            }
            exit;

        case 'view':
            header('Content-Type: application/json');
            echo json_encode($_SESSION['cart']);
            exit;

        case 'remove':
            $data = json_decode(file_get_contents('php://input'), true);
            if ($data) {
                $index = findCartItem($data['item_id']);
                if ($index !== -1) {
                    array_splice($_SESSION['cart'], $index, 1);
                }
            }
            echo json_encode(['message' => 'Đã xóa sản phẩm khỏi giỏ hàng']);
            exit;

        case 'buy_now':
            // Tùy chỉnh nếu cần xử lý riêng cho mua ngay
            break;

        default:
            echo json_encode(['message' => 'Action không hợp lệ']);
            exit;
    }
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