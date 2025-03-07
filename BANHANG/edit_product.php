<?php
session_start();
require './php/db.php';

// Kiểm tra quyền admin
if (!isset($_SESSION["role"]) || $_SESSION["role"] != "admin") {
    header("Location: index.php");
    exit();
}

// Kiểm tra ID sản phẩm
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Lỗi: ID sản phẩm không tồn tại!");
}

$product_id = intval($_GET['id']);

// Lấy thông tin sản phẩm từ database
$sql = "SELECT * FROM products WHERE product_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    die("Sản phẩm không tồn tại hoặc đã bị xóa!");
}

// Xử lý cập nhật sản phẩm
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $image = $_POST['image'];

    // Cập nhật sản phẩm
    $sql = "UPDATE products SET product_name = ?, product_price = ?, category = ?, image = ? WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdssi", $name, $price, $category, $image, $product_id);

    if ($stmt->execute()) {
        echo "<script>alert('Cập nhật sản phẩm thành công!'); window.location.href='manage_products.php';</script>";
    } else {
        echo "<script>alert('Lỗi khi cập nhật sản phẩm!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa sản phẩm</title>
    <link rel="stylesheet" href="/BANHANG/asset/css/cart.css">
</head>
<body>
    <h2>Sửa sản phẩm</h2>
    <form action="edit_product.php?id=<?php echo $product_id; ?>" method="post">
        <label for="name">Tên sản phẩm:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($product['product_name']); ?>" required>

        <label for="price">Giá sản phẩm:</label>
        <input type="number" id="price" name="price" step="0.01" value="<?php echo htmlspecialchars($product['product_price']); ?>" required>

        <label for="category">Danh mục:</label>
        <input type="text" id="category" name="category" value="<?php echo htmlspecialchars($product['category']); ?>" required>

        <label for="image">Hình ảnh (URL):</label>
        <input type="text" id="image" name="image" value="<?php echo htmlspecialchars($product['image']); ?>" required>

        <button type="submit">Lưu thay đổi</button>
        <a href="index.php">
        <button id="homeButton">Quay lại </button>
        </a>
    </form>
</body>
</html>
