<?php
session_start();
include './php/db.php';

// Kiểm tra đăng nhập
if (!isset($_SESSION['user_id'])) {
    echo "❌ Bạn cần đăng nhập.";
    exit;
}

// Kiểm tra dữ liệu gửi lên
if (!isset($_POST['product_id'], $_POST['size'], $_POST['quantity'])) {
    echo "❌ Thiếu thông tin sản phẩm.";
    exit;
}

$product_id = intval($_POST['product_id']);
$size = trim($_POST['size']);
$quantity = intval($_POST['quantity']);
$user_id = $_SESSION['user_id'];

// Kiểm tra số lượng tồn kho
$stockStmt = $conn->prepare("SELECT quantity_in_stock FROM stock WHERE product_id = ? AND size = ?");
$stockStmt->bind_param("is", $product_id, $size);
$stockStmt->execute();
$stockResult = $stockStmt->get_result();

if ($stockResult->num_rows == 0) {
    echo "❌ Size hoặc sản phẩm không tồn tại.";
    exit;
}

$stock = $stockResult->fetch_assoc();
if ($quantity > $stock['quantity_in_stock']) {
    echo "❌ Số lượng mua vượt quá tồn kho.";
    exit;
}

// Kiểm tra nếu sản phẩm + size đã có trong giỏ thì cập nhật số lượng
$checkStmt = $conn->prepare("SELECT cart_id, quantity FROM cart WHERE user_id = ? AND product_id = ? AND size = ?");
$checkStmt->bind_param("iis", $user_id, $product_id, $size);
$checkStmt->execute();
$checkResult = $checkStmt->get_result();

if ($checkResult->num_rows > 0) {
    $row = $checkResult->fetch_assoc();
    $newQuantity = $row['quantity'] + $quantity;

    $updateStmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE cart_id = ?");
    $updateStmt->bind_param("ii", $newQuantity, $row['cart_id']);
    $updateStmt->execute();
} else {
    $insertStmt = $conn->prepare("INSERT INTO cart (user_id, product_id, size, quantity) VALUES (?, ?, ?, ?)");
    $insertStmt->bind_param("iisi", $user_id, $product_id, $size, $quantity);
    $insertStmt->execute();
}

echo "✅ Thêm vào giỏ hàng thành công.";
?>
