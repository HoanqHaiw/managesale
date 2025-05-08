<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'member') {
    die("❌ Bạn chưa đăng nhập thành viên.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = intval($_POST['product_id']);
    $product_name = trim($_POST['product_name']);
    $product_price = floatval($_POST['product_price']);
    $quantity = intval($_POST['quantity']);
    $size = trim($_POST['size']);

    if ($product_id <= 0 || $quantity <= 0 || empty($size)) {
        die("❌ Dữ liệu không hợp lệ.");
    }

    // Lưu sản phẩm cần thanh toán vào session (riêng)
    $_SESSION['buy_now'] = [
        'product_id' => $product_id,
        'product_name' => $product_name,
        'product_price' => $product_price,
        'quantity' => $quantity,
        'size' => $size
    ];

    echo "✅ Mua ngay thành công!";
    // Sau đó frontend tự động chuyển sang trang thanh toán
} else {
    die("❌ Yêu cầu không hợp lệ.");
}
?>
