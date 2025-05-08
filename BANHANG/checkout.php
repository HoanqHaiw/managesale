<?php
session_start();
include './php/db.php';

// Kiểm tra nếu thông tin sản phẩm có được truyền qua GET
if (!isset($_GET['id']) || !isset($_GET['quantity']) || !isset($_GET['size'])) {
    die("❌ Không có thông tin sản phẩm.");
}

$product_id = intval($_GET['id']);
$quantity = intval($_GET['quantity']);
$size = $_GET['size'];

// Lấy thông tin sản phẩm từ cơ sở dữ liệu
$stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $product = $result->fetch_assoc();
} else {
    die("❌ Sản phẩm không tồn tại.");
}

// Lấy số lượng tồn kho từ bảng stock
$stockStmt = $conn->prepare("SELECT quantity_in_stock FROM stock WHERE product_id = ?");
$stockStmt->bind_param("i", $product_id);
$stockStmt->execute();
$stockResult = $stockStmt->get_result();
$stock = $stockResult->fetch_assoc();
$quantity_in_stock = $stock ? $stock['quantity_in_stock'] : 0;

// Kiểm tra xem số lượng có hợp lệ không
if ($quantity > $quantity_in_stock) {
    die("❌ Số lượng yêu cầu vượt quá số lượng tồn kho.");
}
?>


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="./asset/css/base.css">
    <link rel="stylesheet" href="./asset/css/main.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300..800&family=Poppins:wght@200&family=Roboto:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div class="app">
        <?php include '../include/header.php'; ?>
        <div class="app__container">
            <div class="checkout">
                <h2>Thông Tin Đơn Hàng</h2>
                <div class="checkout__details">
                    <p><strong>Sản phẩm:</strong> <?php echo htmlspecialchars($product['product_name']); ?></p>
                    <p><strong>Size:</strong> <?php echo htmlspecialchars($size); ?></p>
                    <p><strong>Số lượng:</strong> <?php echo htmlspecialchars($quantity); ?></p>
                    <p><strong>Giá:</strong> <?php echo number_format($product['product_price'], 0, ',', '.'); ?> VNĐ</p>
                    <p><strong>Tổng cộng:</strong> <?php echo number_format($product['product_price'] * $quantity, 0, ',', '.'); ?> VNĐ</p>
                </div>

                <!-- Form thanh toán -->
                <div class="checkout__form">
                    <form action="process_checkout.php" method="POST">
                        <label for="fullname">Họ và tên:</label>
                        <input type="text" id="fullname" name="fullname" required>

                        <label for="address">Địa chỉ:</label>
                        <input type="text" id="address" name="address" required>

                        <label for="phone">Số điện thoại:</label>
                        <input type="text" id="phone" name="phone" required>

                        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                        <input type="hidden" name="quantity" value="<?php echo $quantity; ?>">
                        <input type="hidden" name="size" value="<?php echo $size; ?>">
                        <input type="hidden" name="total_price" value="<?php echo $product['product_price'] * $quantity; ?>">

                        <button type="submit" class="btn btn--checkout">Xác Nhận Thanh Toán</button>
                    </form>
                </div>
            </div>
        </div>
        <?php include '../include/footer.php'; ?>
    </div>
</body>
