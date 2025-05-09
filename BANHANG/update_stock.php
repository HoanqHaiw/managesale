<?php
// Kết nối database
$conn = new mysqli('localhost', 'root', '', 'myphamstore');
if ($conn->connect_error) {
    die('Kết nối thất bại: ' . $conn->connect_error);
}

// Nhận dữ liệu từ form
$stock_id = intval($_POST['stock_id']);
$quantity_in_stock = intval($_POST['quantity_in_stock']);

// Update số lượng mới
$sql = "UPDATE stock SET quantity_in_stock = ? WHERE stock_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ii', $quantity_in_stock, $stock_id);

if ($stmt->execute()) {
    echo "<script>alert('Cập nhật thành công!'); window.location.href = 'view_stock.php';</script>";
} else {
    echo "Có lỗi xảy ra: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
