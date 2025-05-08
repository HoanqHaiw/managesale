<?php
session_start();
// Kết nối database
include './php/db.php';

// Xử lý tìm kiếm
if (isset($_GET['keyword'])) {
    $keyword = trim($_GET['keyword']); // Xóa khoảng trắng đầu cuối

    if ($keyword === '') {
        echo "<p>Vui lòng nhập từ khóa tìm kiếm.</p>";
    } else {
        // Chuẩn bị câu lệnh SQL
        $keyword = $conn->real_escape_string($keyword);
        $sql = "SELECT p.*, s.quantity_in_stock 
                FROM products p 
                LEFT JOIN stock s ON p.product_id = s.product_id 
                WHERE p.product_name LIKE '%$keyword%'";
        $result = $conn->query($sql);

        echo "<div class='search-container'>";
        // Thêm nút trở về trang chủ
        echo "<a href='index.php' class='back-to-home'><i class='fas fa-arrow-left'></i> Trở về trang chủ</a>";
        
        echo "<h2>Kết quả tìm kiếm cho: <em>" . htmlspecialchars($keyword) . "</em></h2>";

        if ($result && $result->num_rows > 0) {
            echo "<div class='product-list'>";
            while($row = $result->fetch_assoc()) {
                // Tạo link đến trang sản phẩm với product_id
                $product_link = "product.php?id=" . $row['product_id'];
                
                echo "<div class='product-item'>";
                echo "<a href='" . htmlspecialchars($product_link) . "' class='product-link'>";
                echo "<div class='product-image'>";
                echo "<img src='" . htmlspecialchars($row['image']) . "' alt='Hình sản phẩm'>";
                echo "</div>";
                echo "<div class='product-info'>";
                echo "<h3>" . htmlspecialchars($row['product_name']) . "</h3>";
                echo "<p class='product-price'>" . number_format($row['product_price'], 0, ',', '.') . " VNĐ</p>";
                echo "<p class='product-stock'>Số lượng: " . $row['quantity_in_stock'] . "</p>";
                echo "</div>";
                echo "</a>";
                echo "</div>";
            }
            echo "</div>";
        } else {
            echo "<p>Không tìm thấy sản phẩm nào phù hợp.</p>";
        }
        echo "</div>";
    }
} else {
    echo "<p>Vui lòng nhập từ khóa tìm kiếm.</p>";
}
?>

<!-- Thêm Font Awesome cho icon -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<style>
.search-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.back-to-home {
    display: inline-block;
    margin-bottom: 20px;
    padding: 10px 15px;
    background-color: #3498db;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s;
}

.back-to-home:hover {
    background-color: #2980b9;
}

.back-to-home i {
    margin-right: 5px;
}

.product-list {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 20px;
    padding: 20px;
}

.product-item {
    border: 1px solid #e1e1e1;
    border-radius: 8px;
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.product-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.product-link {
    text-decoration: none;
    color: inherit;
    display: block;
}

.product-image img {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.product-info {
    padding: 15px;
}

.product-price {
    color: #e74c3c;
    font-weight: bold;
    font-size: 1.1rem;
    margin: 10px 0;
}

.product-stock {
    color: #27ae60;
    font-size: 0.9rem;
}
</style>