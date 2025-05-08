<?php
session_start();
include './php/db.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("❌ Không có ID nào được truyền! Vui lòng kiểm tra lại link.");
} else {
    echo "✅ ID sản phẩm: " . $_GET['id']; // Debug xem ID có nhận được không
}

$product_id = intval($_GET['id']);

// Kiểm tra kết nối và câu truy vấn
$stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
if ($stmt === false) {
    die("❌ Lỗi khi chuẩn bị câu truy vấn: " . $conn->error);
}

$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $product = $result->fetch_assoc();
    echo "<pre>"; print_r($product); echo "</pre>"; // Debug dữ liệu nhận được
} else {
    die("❌ Sản phẩm không tồn tại.");
}

// Lấy số lượng tồn kho từ bảng stock
$stockStmt = $conn->prepare("SELECT quantity_in_stock FROM stock WHERE product_id = ?");
if ($stockStmt === false) {
    die("❌ Lỗi khi chuẩn bị câu truy vấn stock: " . $conn->error);
}

$stockStmt->bind_param("i", $product_id);
$stockStmt->execute();
$stockResult = $stockStmt->get_result();
$stock = $stockResult->fetch_assoc();
$quantity_in_stock = $stock ? $stock['quantity_in_stock'] : 0;

// Lấy danh sách size có sẵn cho sản phẩm này
$sizeStmt = $conn->prepare("SELECT DISTINCT size FROM stock WHERE product_id = ?");
if ($sizeStmt === false) {
    die("❌ Lỗi khi chuẩn bị câu truy vấn size: " . $conn->error);
}

$sizeStmt->bind_param("i", $product_id);
$sizeStmt->execute();
$sizeResult = $sizeStmt->get_result();
$sizes = [];
while ($row = $sizeResult->fetch_assoc()) {
    $sizes[] = $row['size'];
}
?>


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PRODUCT</title>
    <link rel="stylesheet" href="./asset/css/base.css">
    <link rel="stylesheet" href="./asset/css/page1.css">
    <link rel="stylesheet" href="./asset/css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <div class="app">
        <?php include '../include/header.php'; ?>
        <div class="app__container">
            <div class="product">
                <div class="product__container">
                    <div class="product__image">
                        <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="Sản phẩm" class="product-img">
                    </div>
                    <div class="product__details">
                        <h2 class="product__title"><?php echo htmlspecialchars($product['product_name']); ?></h2>
                        <p class="product__price">Giá: <span id="productPrice">
                            <?php echo number_format($product['product_price'], 0, ',', '.'); ?> VNĐ</span>
                        </p>

                        <!-- Hiển thị số lượng còn lại -->
                        <div class="product__stock">
                            <p>Số lượng còn hàng: <strong><?php echo $quantity_in_stock; ?></strong></p>
                        </div>

                        <div class="quantity_form">
                            <label for="quantity" style="font-size: 1.6rem;">Số Lượng:</label>
                            <input type="number" id="quantity" name="quantity" min="1" value="1" max="<?php echo $quantity_in_stock; ?>" class="product__quantity">
                        </div>

                        <!-- Dropdown chọn size -->
                        <div class="product__size">
                            <label for="size" style="font-size: 1.6rem;">Chọn Size:</label>
                            <select id="size" name="size" class="product__size-dropdown">
                                <option value="">Chọn Size</option>
                                <?php foreach ($sizes as $size): ?>
                                    <option value="<?php echo $size; ?>"><?php echo $size; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="product__buttons">
                            <?php if (!isset($_SESSION["role"]) || $_SESSION["role"] != "admin"): ?>
                                <?php if (isset($_SESSION["role"]) && $_SESSION["role"] == "member"): ?>
                                    <!-- Nếu đã đăng nhập, cho phép mua ngay -->
                                    <button id="buyNow"
                                            class="btn btn--buy"
                                            data-id="<?php echo $product['product_id']; ?>"
                                            data-name="<?php echo htmlspecialchars($product['product_name']); ?>"
                                            data-price="<?php echo $product['product_price']; ?>"
                                            data-stock="<?php echo $quantity_in_stock; ?>">
                                        Mua Ngay
                                    </button>
                                <?php else: ?>
                                    <!-- Nếu chưa đăng nhập, hiển thị thông báo yêu cầu đăng nhập -->
                                    <button class="btn btn--buy" onclick="requireLogin()">
                                        Mua Ngay
                                    </button>
                                <?php endif; ?>

                                <button id="addToCart"
                                        class="btn btn--add-cart"
                                        data-id="<?php echo $product['product_id']; ?>"
                                        data-name="<?php echo htmlspecialchars($product['product_name']); ?>"
                                        data-price="<?php echo $product['product_price']; ?>"
                                        data-stock="<?php echo $quantity_in_stock; ?>">
                                    <i class="fa-solid fa-cart-shopping"></i> Thêm vào Giỏ Hàng
                                </button>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>
            </div>
            <?php include '../include/footer.php'; ?>
        </div>
    </div>
    <script>
        const isLoggedIn = <?php echo json_encode(isset($_SESSION['role'])); ?>;
    </script>
    <script src="/BANHANG/JS/product.js"></script>
</body>
