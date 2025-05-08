<?php
session_start();
include './php/db.php';

// Kiểm tra nếu thông tin thanh toán có được gửi lên
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['fullname'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $product_id = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']);
    $size = $_POST['size'];
    $total_price = floatval($_POST['total_price']);

    // Insert thông tin vào bảng orders
    $stmt = $conn->prepare("INSERT INTO orders (user_id, fullname, address, phone, total_amount, order_status) 
                            VALUES (?, ?, ?, ?, ?, 'pending')");

    if ($stmt === false) {
        die("❌ Lỗi khi chuẩn bị câu truy vấn: " . $conn->error);
    }

    $stmt->bind_param("isssi", $_SESSION['user_id'], $fullname, $address, $phone, $total_price);
    
    if (!$stmt->execute()) {
        die("❌ Lỗi khi thực thi câu truy vấn: " . $stmt->error);
    }
    
    // Lấy order_id mới tạo
    $order_id = $stmt->insert_id;

    // Thêm chi tiết đơn hàng vào bảng orderdetails
    $orderDetailsStmt = $conn->prepare("INSERT INTO orderdetails (order_id, product_id, quantity, price) 
                                        VALUES (?, ?, ?, ?)");

    if ($orderDetailsStmt === false) {
        die("❌ Lỗi khi chuẩn bị câu truy vấn orderdetails: " . $conn->error);
    }

    $orderDetailsStmt->bind_param("iiii", $order_id, $product_id, $quantity, $total_price);

    if (!$orderDetailsStmt->execute()) {
        die("❌ Lỗi khi thực thi câu truy vấn orderdetails: " . $orderDetailsStmt->error);
    }

    // Cập nhật lại số lượng tồn kho
    $stockStmt = $conn->prepare("UPDATE stock SET quantity_in_stock = quantity_in_stock - ? WHERE product_id = ?");
    if ($stockStmt === false) {
        die("❌ Lỗi khi chuẩn bị câu truy vấn stock: " . $conn->error);
    }

    $stockStmt->bind_param("ii", $quantity, $product_id);
    
    if (!$stockStmt->execute()) {
        die("❌ Lỗi khi thực thi câu truy vấn stock: " . $stockStmt->error);
    }

    echo "✅ Đặt hàng thành công! Chúng tôi sẽ liên hệ với bạn sớm.";
} else {
    die("❌ Dữ liệu không hợp lệ.");
}
?>
