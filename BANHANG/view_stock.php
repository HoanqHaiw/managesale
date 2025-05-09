<?php
// Kết nối database
$conn = new mysqli('localhost', 'root', '', 'myphamstore');
if ($conn->connect_error) {
    die('Kết nối thất bại: ' . $conn->connect_error);
}

// Truy vấn dữ liệu stock + products
$sql = "SELECT stock.stock_id, products.product_name, stock.size, stock.quantity_in_stock
        FROM stock
        INNER JOIN products ON stock.product_id = products.product_id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Kho Hàng</title>
    <link rel="stylesheet" href="/BANHANG/asset/css/cart.css"> 
</head>
<body>
    <h2>Danh sách Kho hàng</h2>
    <table border="1" cellpadding="10">
        <tr>
            <th>Tên sản phẩm</th>
            <th>Size</th>
            <th>Số lượng tồn</th>
            <th>Hành động</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <form action="update_stock.php" method="POST">
                <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                <td><?php echo htmlspecialchars($row['size']); ?></td>
                <td>
                    <input type="number" name="quantity_in_stock" value="<?php echo $row['quantity_in_stock']; ?>" min="0">
                </td>
                <td>
                    <input type="hidden" name="stock_id" value="<?php echo $row['stock_id']; ?>">
                    <button type="submit">Cập nhật</button>
                </td>
            </form>
        </tr>
        <?php } ?>
    </table>
    <a href="index.php"><button>Quay lại trang chủ</button></a>
</body>
</html>

<?php $conn->close(); ?>
