<?php
session_start();
include './php/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['fullname'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $user_id = $_SESSION['user_id'];

    // 1. Tính tổng tiền từ cart
    $cart_sql = "SELECT cart.product_id, cart.size, cart.quantity, products.product_price 
                FROM cart 
                INNER JOIN products ON cart.product_id = products.product_id 
                WHERE cart.user_id = ?";
    $cart_stmt = $conn->prepare($cart_sql);
    $cart_stmt->bind_param("i", $user_id);
    $cart_stmt->execute();
    $cart_result = $cart_stmt->get_result();

    if ($cart_result->num_rows == 0) {
        die("❌ Giỏ hàng của bạn đang trống.");
    }

    $total_price = 0;
    $cart_items = [];

    while ($item = $cart_result->fetch_assoc()) {
        $cart_items[] = $item;
        $total_price += $item['product_price'] * $item['quantity'];
    }

    // 2. Thêm đơn hàng vào bảng orders
    $order_stmt = $conn->prepare("INSERT INTO orders (user_id, fullname, address, phone, total_amount, order_status) 
                                  VALUES (?, ?, ?, ?, ?, 'pending')");
    $order_stmt->bind_param("isssi", $user_id, $fullname, $address, $phone, $total_price);

    if (!$order_stmt->execute()) {
        die("❌ Lỗi khi thêm đơn hàng: " . $order_stmt->error);
    }

    $order_id = $order_stmt->insert_id;

    // 3. Thêm từng sản phẩm vào orderdetails
    $detail_stmt = $conn->prepare("INSERT INTO orderdetails (order_id, product_id, quantity, price) 
                                   VALUES (?, ?, ?, ?)");

    foreach ($cart_items as $item) {
        $product_id = $item['product_id'];
        $quantity = $item['quantity'];
        $price = $item['product_price'];
        $detail_stmt->bind_param("iiii", $order_id, $product_id, $quantity, $price);

        if (!$detail_stmt->execute()) {
            die("❌ Lỗi thêm chi tiết đơn hàng: " . $detail_stmt->error);
        }

        // 4. Trừ hàng trong kho
        $update_stock_stmt = $conn->prepare("UPDATE stock SET quantity_in_stock = quantity_in_stock - ? WHERE product_id = ?");
        $update_stock_stmt->bind_param("ii", $quantity, $product_id);
        $update_stock_stmt->execute();
    }

    // 5. Xóa giỏ hàng
    $clear_cart_stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
    $clear_cart_stmt->bind_param("i", $user_id);
    $clear_cart_stmt->execute();

    echo "✅ Đặt hàng thành công!";
    echo '<a href="index.php"><button>🏠 Quay về trang chủ</button></a>';
} else {
    die("❌ Dữ liệu không hợp lệ.");
}
?>
