<!-- QUANR LÝ SẢN PHẨM PHÂN QUYỀN MEMBER -->
<?php
require './php/db.php'; // Kết nối database

$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý sản phẩm</title>
    <link rel="stylesheet" href="/BANHANG/asset/css/cart.css">
</head>
<body>
    <h2>Danh sách sản phẩm</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên sản phẩm</th>
                <th>Giá</th>
                <th>Danh mục</th>
                <th>Hình ảnh</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['product_id']; ?></td>
                <td><?php echo $row['product_name']; ?></td>
                <td><?php echo number_format($row['product_price'], 0, ',', '.'); ?>đ</td>
                <td><?php echo $row['category']; ?></td>
                <td><img src="<?php echo $row['image']; ?>" width="50"></td>
                <td>
                    <a href="edit_product.php?id=<?php echo $row['product_id']; ?>">
                        <button>Sửa</button>
                    </a>
                    <a href="delete_product.php?id=<?php echo $row['product_id']; ?>" onclick="return confirm('Xóa sản phẩm này?')">
                        <button>Xóa</button>
                    </a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <a href="index.php">
        <button id="homeButton">Quay lại trang chủ</button>
    </a>
</body>
</html>
