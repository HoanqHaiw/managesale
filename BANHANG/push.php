<!-- THÊM SẢN PHẨM PHÂN QUYỀN ADMIN -->
<?php
require './php/db.php'; // Gọi file kết nối database

// Xử lý form thêm sản phẩm
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $category = $_POST['category']; // Lấy giá trị category
    $image = $_POST['image']; // Lấy đường dẫn ảnh sản phẩm

    $sql = "INSERT INTO Products (product_name, product_price, category, image) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdss", $name, $price, $category, $image);
    $stmt->execute();
    $stmt->close();
}

// Lấy danh sách sản phẩm
$sql = "SELECT * FROM Products ORDER BY product_id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sản phẩm</title>
    <link rel="stylesheet" href="/BANHANG/asset/css/push.css">
</head>
<body>

    <h2>Thêm sản phẩm</h2>
    <form action="" method="post">
        <label for="name">Tên sản phẩm:</label>
        <input type="text" id="name" name="name" required>

        <label for="price">Giá sản phẩm:</label>
        <input type="number" id="price" name="price" step="0.01" required>

        <label for="category">Danh mục:</label>
        <input type="text" id="category" name="category" required>

        <label for="image">Hình ảnh (URL):</label>
        <input type="text" id="image" name="image" required>

        <button type="submit" class="btn--buy">Thêm sản phẩm</button>
        <!-- Nút trở về trang chủ -->
        <a href="index.php" class="btn--home">Trở về trang chủ</a>

    </form>

    <h2>Danh sách sản phẩm</h2>
<div class="product__list">
    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="product__container">
            <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="Sản phẩm" class="product__image">
            <h3 class="product__title"><?php echo htmlspecialchars($row['product_name']); ?></h3>
            <p class="product__price"><?php echo number_format($row['product_price'], 2) . " VNĐ"; ?></p>
        </div>
    <?php endwhile; ?>
</div>


    <?php $conn->close(); // Đóng kết nối ?>
</body>
</html>
