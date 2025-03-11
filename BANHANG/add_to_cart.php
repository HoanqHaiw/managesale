<?php
session_start();
header("Content-Type: application/json");

// Nhận dữ liệu JSON từ JavaScript
$data = json_decode(file_get_contents("php://input"), true);

if (!$data || !isset($data['id'], $data['name'], $data['price'], $data['quantity'])) {
    echo json_encode(["message" => "Dữ liệu không hợp lệ"]);
    exit;
}

// Nếu session giỏ hàng chưa tồn tại, khởi tạo
if (!isset($_SESSION["cart"])) {
    $_SESSION["cart"] = [];
}

// Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
$found = false;
foreach ($_SESSION["cart"] as &$item) {
    if ($item["id"] == $data["id"]) {
        $item["quantity"] += $data["quantity"];
        $found = true;
        break;
    }
}

// Nếu chưa có, thêm mới sản phẩm
if (!$found) {
    $_SESSION["cart"][] = [
        "id" => $data["id"],
        "name" => $data["name"],
        "price" => $data["price"],
        "quantity" => $data["quantity"]
    ];
}

echo json_encode(["message" => "🛒 Thêm vào giỏ hàng thành công!"]);
