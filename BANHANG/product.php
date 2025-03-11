<!-- TRANG CHUR ĐƠN HANGF -->
<?php
session_start();
include './php/db.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("❌ Không có ID nào được truyền! Vui lòng kiểm tra lại link.");
} else {
    echo "✅ ID sản phẩm: " . $_GET['id']; // Debug xem ID có nhận được không
}

$product_id = intval($_GET['id']);

$stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $product = $result->fetch_assoc();
    echo "<pre>"; print_r($product); echo "</pre>"; // Debug dữ liệu nhận được
} else {
    die("❌ Sản phẩm không tồn tại.");
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
                        <div class="quantity_form">
                            <label for="quantity" style="font-size: 1.6rem;">Số Lượng:</label>
                            <input type="number" id="quantity" name="quantity" min="1" value="1" class="product__quantity">
                        </div>
                        <div class="product__buttons">
                            <?php if (!isset($_SESSION["role"]) || $_SESSION["role"] != "admin"): ?>
                                <button id="buyNow"
                                        class="btn btn--buy"
                                        data-id="<?php echo $product['product_id']; ?>"
                                        data-name="<?php echo htmlspecialchars($product['product_name']); ?>"
                                        data-price="<?php echo $product['product_price']; ?>">
                                        Mua Ngay
                                </button>
                                <button id="addToCart"
                                        class="btn btn--add-cart"
                                        data-id="<?php echo $product['product_id']; ?>"
                                        data-name="<?php echo htmlspecialchars($product['product_name']); ?>"
                                        data-price="<?php echo $product['product_price']; ?>">
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