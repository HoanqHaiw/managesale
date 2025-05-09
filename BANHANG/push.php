<?php
require './php/db.php'; // Kết nối database

// Xử lý khi ấn nút submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $price = (float)$_POST['price'];
    $category = trim($_POST['category']);
    $image = trim($_POST['image']);

    $size_s = (int)$_POST['size_s'];
    $size_m = (int)$_POST['size_m'];
    $size_l = (int)$_POST['size_l'];
    $size_xl = (int)$_POST['size_xl'];

    // Thêm vào bảng products trước
    $sql = "INSERT INTO myphamstore.products (product_name, product_price, category, image) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sdss", $name, $price, $category, $image);
        $stmt->execute();

        // Lấy id sản phẩm vừa insert
        $product_id = $stmt->insert_id;
        $stmt->close();

        // Thêm vào bảng stock từng size
        $sizes = [
            ['S', $size_s],
            ['M', $size_m],
            ['L', $size_l],
            ['XL', $size_xl]
        ];

        foreach ($sizes as $size) {
            $sqlStock = "INSERT INTO myphamstore.stock (product_id, size, quantity_in_stock) VALUES (?, ?, ?)";
            $stmtStock = $conn->prepare($sqlStock);
            if ($stmtStock) {
                $stmtStock->bind_param("isi", $product_id, $size[0], $size[1]);
                $stmtStock->execute();
                $stmtStock->close();
            }
        }

        header("Location: push.php");
        exit();
    } else {
        echo "Lỗi thêm sản phẩm: " . $conn->error;
    }
}

// Lấy danh sách sản phẩm và số lượng tồn kho từng size
$sql = "SELECT p.*, 
            (SELECT quantity_in_stock FROM myphamstore.stock WHERE product_id = p.product_id AND size = 'S' LIMIT 1) AS size_s,
            (SELECT quantity_in_stock FROM myphamstore.stock WHERE product_id = p.product_id AND size = 'M' LIMIT 1) AS size_m,
            (SELECT quantity_in_stock FROM myphamstore.stock WHERE product_id = p.product_id AND size = 'L' LIMIT 1) AS size_l,
            (SELECT quantity_in_stock FROM myphamstore.stock WHERE product_id = p.product_id AND size = 'XL' LIMIT 1) AS size_xl
        FROM myphamstore.products p
        ORDER BY p.product_id DESC";
$result = $conn->query($sql);
if (!$result) {
    die("SQL Error: " . $conn->error);
}

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

<form action="" method="POST">
    <label for="name">Tên sản phẩm:</label>
    <input type="text" id="name" name="name" required>

    <label for="price">Giá sản phẩm:</label>
    <input type="number" id="price" name="price" step="0.01" required>

    <label for="category">Danh mục:</label>
    <input type="text" id="category" name="category" required>

    <label for="image">Hình ảnh (URL):</label>
    <input type="text" id="image" name="image" required>

    <label for="size_s">Số lượng Size S:</label>
    <input type="number" id="size_s" name="size_s" min="0" required>

    <label for="size_m">Số lượng Size M:</label>
    <input type="number" id="size_m" name="size_m" min="0" required>

    <label for="size_l">Số lượng Size L:</label>
    <input type="number" id="size_l" name="size_l" min="0" required>

    <label for="size_xl">Số lượng Size XL:</label>
    <input type="number" id="size_xl" name="size_xl" min="0" required>

    <button type="submit" class="btn--buy">Thêm sản phẩm</button>
    <a href="index.php" class="btn--home">Trở về trang chủ</a>
</form>

<h2>Danh sách sản phẩm</h2>

<div class="product__list">
    <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="product__container">
                <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="Sản phẩm" class="product__image">
                <h3 class="product__title"><?php echo htmlspecialchars($row['product_name']); ?></h3>
                <p class="product__price"><?php echo number_format($row['product_price'], 0, ',', '.') . " VNĐ"; ?></p>
                <div class="product__sizes">
                    <p>Size S: <?php echo (int)$row['size_s']; ?> cái</p>
                    <p>Size M: <?php echo (int)$row['size_m']; ?> cái</p>
                    <p>Size L: <?php echo (int)$row['size_l']; ?> cái</p>
                    <p>Size XL: <?php echo (int)$row['size_xl']; ?> cái</p>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>Chưa có sản phẩm nào.</p>
    <?php endif; ?>
</div>

<?php $conn->close(); ?>
</body>
</html>
