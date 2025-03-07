<?php
session_start();
include "./php/db.php";

$category = isset($_GET['category']) ? $_GET['category'] : '';

// Lấy sản phẩm theo danh mục được chọn
$sql = "SELECT * FROM products WHERE category = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $category);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh Mục - <?php echo htmlspecialchars($category); ?></title>
    <link rel="stylesheet" href="./asset/css/base.css">
    <link rel="stylesheet" href="./asset/css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <div class="app">
        <?php include '../include/header.php'; ?>
        <div class="app__container">
            <div class="grid">
                <div class="grid__row app__content">
                    <div class="grid__column-2">
                        <nav class="category">
                            <h3 class="category__heading">
                                <i class="category__heading-icon fa-solid fa-list"></i>
                                Danh Mục
                            </h3>
                            <ul class="category-list">
                                <li class="category-item">
                                    <a href="category.php?category=Mỹ Phẩm" class="category-item__link">Mỹ Phẩm</a>
                                </li>
                                <li class="category-item">
                                    <a href="category.php?category=Kem Dưỡng Da" class="category-item__link">Kem Dưỡng Da</a>
                                </li>
                                <li class="category-item">
                                    <a href="category.php?category=Son Môi" class="category-item__link">Son Môi</a>
                                </li>
                            </ul>
                        </nav>
                    </div>

                    <div class="grid__column-10">
                        <h2 class="category-title">Danh Mục: <?php echo htmlspecialchars($category); ?></h2>
                        <div class="home-product">
                            <div class="grid__row">
                                <?php while ($row = $result->fetch_assoc()) { ?>
                                    <div class="grid__column-2-4">
                                        <a class="home-product-item" href="product.php?id=<?php echo $row['product_id']; ?>">
                                            <div class="home-product-item__img" style="background-image: url('<?php echo $row['image']; ?>');"></div>
                                            <h4 class="home-product-item__name"><?php echo $row['product_name']; ?></h4>
                                            <div class="home-product-item__price"> 
                                                <span class="home-product-item__price-current"><?php echo number_format($row['product_price'], 0, ',', '.'); ?>đ</span>
                                            </div>
                                        </a>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include '../include/footer.php'; ?>
    </div>
</body>

</html>
