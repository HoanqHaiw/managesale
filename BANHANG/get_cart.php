<!-- LẤY SẢN PHẨM -->
<?php
session_start();
header("Content-Type: application/json");

// Nếu giỏ hàng rỗng, trả về mảng rỗng
if (!isset($_SESSION["cart"]) || empty($_SESSION["cart"])) {
    echo json_encode([]);
    exit;
}

echo json_encode($_SESSION["cart"]);
