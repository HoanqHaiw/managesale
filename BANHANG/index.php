<!-- TRANG CHỦ -->
<?php
session_start();
include "./php/db.php";

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

$total_sql = "SELECT COUNT(*) AS total FROM products";
$total_result = $conn->query($total_sql);
$total_row = $total_result->fetch_assoc();
$total_products = $total_row['total'];
$total_pages = ceil($total_products / $limit);

$sql = "SELECT * FROM products LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOME</title>
    <link rel="stylesheet" href="./asset/css/base.css">
    <link rel="stylesheet" href="./asset/css/main.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300..800&family=Poppins:wght@200&family=Roboto:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
                            <li class="category-item category-item--active">
                                <a href="/BANHANG/index.php" class="category-item__link">Trang Chủ</a>
                            </li>
                            <li class="category-item">
                                <a href="/BANHANG/category.php" class="category-item__link">Quần</a>
                            </li>
                            <li class="category-item">
                                <a href="/BANHANG/category.php" class="category-item__link">Áo Đông</a>
                            </li>
                            <li class="category-item">
                                <a href="/BANHANG/category.php" class="category-item__link">Áo</a>
                            </li>
                        </ul>
<?php if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'): ?>
    <h3 class="category__heading">
        <i class="fa-solid fa-address-card"></i>
        About Us
    </h3>
    <ul class="category-list">
        <li class="category-item">
            <a href="/BANHANG/about_us.php" class="category-item__link">Về Chúng Tôi</a>
        </li>
        <li class="category-item">
            <a href="/BANHANG/contact.php" class="category-item__link">Liên Hệ</a>
        </li>
    </ul>
<?php endif; ?>

                    </nav>
                </div>

                <div class="grid__column-10">
                    <div class="home-filter">
                        <span class="home-filter__label">
                            <?php echo (isset($_SESSION["role"]) && $_SESSION["role"] === "admin") ? "Quản Lý Hệ Thống" : "Sắp Xếp Theo"; ?>
                        </span>

                        <?php if (isset($_SESSION["role"]) && $_SESSION["role"] === "admin"): ?>
                            <button class="home-filter__btn btn btn--primary" onclick="location.href='manage_products.php'">Quản Lý Sản Phẩm</button>
                            <button class="home-filter__btn btn btn--primary" onclick="location.href='admin_orders.php'">Quản Lý Đơn Hàng</button>
                            <button class="home-filter__btn btn btn--primary" onclick="location.href='manage_users.php'">Quản Lý Người Dùng</button>
                            <button class="home-filter__btn btn btn--primary" onclick="location.href='push.php'">Thêm Sản Phẩm</button>
                            <button class="home-filter__btn btn btn--primary" onclick="location.href='statistics.php'">Báo Cáo Thống Kê</button>
                            <button class="home-filter__btn btn btn--primary" onclick="location.href='view_stock.php'">Quản Lý Kho Hàng</button>
                        <?php else: ?>
                            <button class="home-filter__btn btn btn--primary">Phổ Biến</button>
                            <button class="home-filter__btn btn btn--primary">Mới Nhất</button>
                            <button class="home-filter__btn btn btn--primary">Bán Chạy</button>
                            <div class="select-input">
                                <span class="select-input__label">Giá</span>
                                <ul class="select-input__list">
                                    <li class="select-input__item"><a href="#" class="select-input__link">Giá: Thấp Đến Cao</a></li>
                                    <li class="select-input__item"><a href="#" class="select-input__link">Giá: Cao Đến Thấp</a></li>
                                </ul>
                                <i class="select-input__icon fa-solid fa-arrow-down"></i>
                            </div>
                        <?php endif; ?>

                        <div class="home-filter__page">
                            <span class="home-filter__page-num">
                                <span class="home-filter__page-current"><?php echo $page; ?></span>/<?php echo $total_pages; ?>
                            </span>
                            <div class="home-filter__page-control">
                                <?php if ($page > 1): ?>
                                    <a href="?page=<?php echo $page-1; ?>" class="home-filter__page-btn">
                                        <i class="home-filter__page-icon fa-solid fa-arrow-left"></i>
                                    </a>
                                <?php else: ?>
                                    <span class="home-filter__page-btn home-filter__page-btn--disabled">
                                        <i class="home-filter__page-icon fa-solid fa-arrow-left"></i>
                                    </span>
                                <?php endif; ?>

                                <?php if ($page < $total_pages): ?>
                                    <a href="?page=<?php echo $page+1; ?>" class="home-filter__page-btn">
                                        <i class="home-filter__page-icon fa-solid fa-arrow-right"></i>
                                    </a>
                                <?php else: ?>
                                    <span class="home-filter__page-btn home-filter__page-btn--disabled">
                                        <i class="home-filter__page-icon fa-solid fa-arrow-right"></i>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="home-product">
                        <div class="grid__row">
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <div class="grid__column-2-4">
                                    <a class="home-product-item" href="product.php?id=<?php echo htmlspecialchars($row['product_id']); ?>" data-id="<?php echo $row['product_id']; ?>">
                                        <div class="home-product-item__img" style="background-image: url('<?php echo htmlspecialchars($row['image']); ?>');"></div>
                                        <h4 class="home-product-item__name"><?php echo htmlspecialchars($row['product_name']); ?></h4>
                                        <div class="home-product-item__price">
                                            <span class="home-product-item__price-current"><?php echo number_format($row['product_price'], 0, ',', '.'); ?>đ</span>
                                        </div>
                                    </a>
                                </div>
                            <?php endwhile; ?>
                        </div>
                        <?php $conn->close(); ?>
                    </div>

                    <ul class="pagination home-product__pagination">
                        <?php if ($page > 1): ?>
                            <li class="pagination-item">
                                <a href="?page=<?php echo $page-1; ?>" class="pagination-item__link">
                                    <i class="pagination-item__icon fas fa-chevron-left"></i>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <li class="pagination-item <?php echo ($i == $page) ? 'pagination-item--active' : ''; ?>">
                                <a href="?page=<?php echo $i; ?>" class="pagination-item__link"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>

                        <?php if ($page < $total_pages): ?>
                            <li class="pagination-item">
                                <a href="?page=<?php echo $page+1; ?>" class="pagination-item__link">
                                    <i class="pagination-item__icon fas fa-chevron-right"></i>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>

                </div>
            </div>
        </div>
    </div>

    <?php include '../include/footer.php'; ?>
</div>

<script src="/BANHANG/JS/index.js"></script>
</body>
</html>
