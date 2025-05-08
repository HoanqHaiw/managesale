<?php
session_start();
include './php/db.php';

function getMonthlyStats($month, $year) {
    global $conn;

    // Báo cáo doanh thu theo tháng
    $revenueQuery = "
        SELECT SUM(total_amount) AS total_revenue
        FROM orders
        WHERE YEAR(order_date) = $year AND MONTH(order_date) = $month
    ";
    $revenueResult = mysqli_query($conn, $revenueQuery);
    if (!$revenueResult) {
        die("Lỗi truy vấn doanh thu: " . mysqli_error($conn));
    }
    $revenue = mysqli_fetch_assoc($revenueResult)['total_revenue'] ?? 0;

    // Báo cáo số lượng đơn hàng theo tháng
    $ordersQuery = "
        SELECT COUNT(order_id) AS total_orders
        FROM orders
        WHERE YEAR(order_date) = $year AND MONTH(order_date) = $month
    ";
    $ordersResult = mysqli_query($conn, $ordersQuery);
    if (!$ordersResult) {
        die("Lỗi truy vấn số lượng đơn hàng: " . mysqli_error($conn));
    }
    $ordersCount = mysqli_fetch_assoc($ordersResult)['total_orders'] ?? 0;

    // Báo cáo sản phẩm bán chạy trong tháng
    $productsQuery = "
        SELECT p.product_name, SUM(od.quantity) AS total_quantity_sold
        FROM orderdetails od
        JOIN products p ON od.product_id = p.product_id
        JOIN orders o ON od.order_id = o.order_id
        WHERE YEAR(o.order_date) = $year AND MONTH(o.order_date) = $month
        GROUP BY p.product_name
        ORDER BY total_quantity_sold DESC
        LIMIT 10
    ";
    $productsResult = mysqli_query($conn, $productsQuery);
    if (!$productsResult) {
        die("Lỗi truy vấn sản phẩm bán chạy: " . mysqli_error($conn));
    }
    $products = [];
    while ($row = mysqli_fetch_assoc($productsResult)) {
        $products[] = $row;
    }

    return [
        'total_revenue' => $revenue,
        'total_orders' => $ordersCount,
        'top_products' => $products
    ];
}

// Xử lý ngày tháng
$month = isset($_GET['month']) ? $_GET['month'] : date('m'); // Mặc định là tháng hiện tại
$year = isset($_GET['year']) ? $_GET['year'] : date('Y');   // Mặc định là năm hiện tại

$stats = getMonthlyStats($month, $year);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Báo Cáo Thống Kê Tháng</title>
    <link rel="stylesheet" href="/BANHANG/asset/css/cart.css">
</head>
<body>
    <h1>Báo Cáo Thống Kê - Tháng <?php echo $month; ?>, Năm <?php echo $year; ?></h1>

    <h2>Doanh Thu: <?php echo number_format($stats['total_revenue'], 0, ',', '.'); ?> VNĐ</h2>
    <h2>Số Lượng Đơn Hàng: <?php echo $stats['total_orders']; ?> đơn</h2>

    <h3>Sản Phẩm Bán Chạy Nhất</h3>
    <table>
        <thead>
            <tr>
                <th>Tên Sản Phẩm</th>
                <th>Số Lượng Bán</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($stats['top_products'])): ?>
                <tr>
                    <td colspan="2">Không có dữ liệu sản phẩm bán chạy.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($stats['top_products'] as $product): ?>
                    <tr>
                        <td><?php echo $product['product_name']; ?></td>
                        <td><?php echo $product['total_quantity_sold']; ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <br>
    <button onclick="window.location.href='index.php'">Quay lại trang chủ</button>
</body>
</html>
