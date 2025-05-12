<?php
include "./php/db.php";
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Về Chúng Tôi - Thương hiệu Quần Áo</title>
    <link rel="stylesheet" href="/BANHANG/asset/css/about.css">
</head>
<body>

<!-- Header -->
<header>
    <a href="index.php">Trang Chủ</a>
    <a href="about_us.php" class="active">Về Chúng Tôi</a>
    <a href="contact.php">Liên Hệ</a>
</header>

<!-- Main -->
<main>

    <!-- Slide -->
    <div class="slider">
        <div class="slides">
            <img src="/BANHANG/asset/img/image4.png" alt="Slide 1">
            <img src="/BANHANG/asset/img/image2.png" alt="Slide 2">
            <img src="/BANHANG/asset/img/image1.png" alt="Slide 3">
        </div>
    </div>

    <!-- Text Giới Thiệu -->
    <div class="about-text">
        <h2>Chào mừng đến với thương hiệu của chúng tôi</h2>
        <div class="slider-text">
                <p>Justin Hoàng là thương hiệu thời trang mang tinh thần trẻ trung, năng động và đầy cá tính. Chúng tôi chuyên cung cấp các sản phẩm quần áo được thiết kế tỉ mỉ, cập nhật xu hướng mới nhất, phù hợp với nhiều phong cách từ thanh lịch, năng động đến cá tính mạnh mẽ. Với phương châm "Chất lượng làm nên thương hiệu", Justin Hoàng cam kết mang đến cho khách hàng những trải nghiệm tốt nhất về sản phẩm và dịch vụ. Mỗi bộ sưu tập là sự kết hợp hài hòa giữa xu hướng toàn cầu và cá tính riêng biệt của người Việt trẻ.
Hãy cùng Justin Hoàng tự tin khẳng định phong cách của chính bạn!</p>
</div>
    </div>



    <!-- 3 ảnh sản phẩm -->
    <div class="about-gallery">
        <img src="/BANHANG/asset/img/image.png" alt="Sản phẩm 2">
    </div>

    <!-- Tiêu đề sản phẩm -->
    <div class="product-section-title">
        <h3>Sản Phẩm Nổi Bật</h3>
    </div>

    <!-- Danh sách sản phẩm -->
<div class="products">
    <?php
    $sql = "SELECT * FROM products LIMIT 5";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="product-item">';
            $image_url = $row['image']; // Đường dẫn URL ảnh từ cơ sở dữ liệu
            echo '<a href="product.php?id=' . urlencode($row['product_id']) . '">';
            echo '<img src="' . htmlspecialchars($image_url) . '" alt="' . htmlspecialchars($row['product_name']) . '">';
            echo '</a>';
            echo '<p class="product-name">' . htmlspecialchars($row['product_name']) . '</p>'; // Hiển thị tên sản phẩm
            echo '</div>';
        }
    } else {
        echo '<p>Chưa có sản phẩm nào.</p>';
    }
    ?>
</div>




</main>

<!-- Footer -->
<footer>
    &copy; 2025 Thương hiệu Quần Áo Justin Hoang- All rights reserved
</footer>

</body>
</html>
