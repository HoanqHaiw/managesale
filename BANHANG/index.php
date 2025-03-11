<!-- TRANG CHỦ -->
<?php
session_start();
include "./php/db.php";

$sql = "SELECT * FROM products"; // Lấy tất cả sản phẩm
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOME</title>
    <link rel="stylesheet" href="./asset/css/base.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:wght@200&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">   
    <link rel="stylesheet" href="./asset/css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css"
        integrity="sha512-NhSC1YmyruXifcj/KFRWoC561YpHpc5Jtzgvbuzx5VozKpWvQ+4nXhPdFgmx8xqexRcpAglTj9sIBWINXa8x5w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div class="app">
    <?php include '../include/header.php'; ?>
        <div class="app__container">
            <div class="grid">
                <div class="grid__row app__content"> <!--la dong -->
                    <div class="grid__column-2"><!--la cot nam trong  dong -->
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
                                    <a href="/BANHANG/category.php" class="category-item__link">Mỹ Phẩm</a>
                                </li>
                                <li class="category-item">
                                    <a href="/BANHANG/category.php" class="category-item__link">Kem Dưỡng Da</a>
                                </li>
                                <li class="category-item">
                                    <a href="/BANHANG/category.php" class="category-item__link">Son Môi</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <div class="grid__column-10">
                        <div class="home-filter">
<!--  -->
<span class="home-filter__label">
    <?php 
        if (isset($_SESSION["role"]) && $_SESSION["role"] == "admin") {
            echo "Quản Lý Hệ Thống";
        } else {
            echo "Sắp Xếp Theo";
        }
    ?>
</span>

<?php if (isset($_SESSION["role"]) && $_SESSION["role"] == "admin"): ?>
    <!-- Hiển thị menu cho admin -->
    <button class="home-filter__btn btn btn--primary" onclick="location.href='manage_products.php'">Quản Lý Sản Phẩm</button>
    <button class="home-filter__btn btn btn--primary" onclick="location.href='admin_orders.php'">Quản Lý Đơn Hàng</button>
    <button class="home-filter__btn btn btn--primary" onclick="location.href='manage_users.php'">Quản Lý Người Dùng</button>
    <button class="home-filter__btn btn btn--primary" onclick="location.href='push.php'">Quản Lý Thêm Sản Phẩm</button>
<?php else: ?>
    <!-- Hiển thị menu cho khách -->
    <button class="home-filter__btn btn btn--primary">Phổ Biến</button>
    <button class="home-filter__btn btn btn--primary">Mới Nhất</button>
    <button class="home-filter__btn btn btn--primary">Bán Chạy</button>
    <div class="select-input">
        <span class="select-input__label">Giá</span>
        <ul class="select-input__list">
            <li class="select-input__item">
                <a href="#" class="select-input__link">Giá: Thấp Đến Cao</a>
            </li>
            <li class="select-input__item">
                <a href="#" class="select-input__link">Giá: Cao Đến Thấp</a>
            </li>
        </ul>
        <i class="select-input__icon fa-solid fa-arrow-down"></i>
    </div>
<?php endif; ?>

                            <div class="home-filter__page">
                                <span class="home-filter__page-num">
                                    <span class="home-filter__page-current">1</span>/9
                                </span>
                            <div class="home-filter__page-control">
                                <a href="" class="home-filter__page-btn home-filter__page-btn--disabled">
                                    <i class="home-filter__page-icon fa-solid fa-arrow-left"></i>
                                </a>
                                <a href="" class="home-filter__page-btn">
                                    <i class="home-filter__page-icon fa-solid fa-arrow-right"></i>
                                </a>
                            </div>
                            </div>
                        </div>

                        <div class="home-product">
                            <div class="grid__row">
                            <?php while ($row = $result->fetch_assoc()) { ?>
    <div class="grid__column-2-4">
    <a class="home-product-item" href="product.php?id=<?php echo htmlspecialchars($row['product_id']); ?>" data-id="<?php echo $row['product_id']; ?>">
            <div class="home-product-item__img" style="background-image: url('<?php echo $row['image']; ?>');">
                <h4 class="home-product-item__name"><?php echo $row['product_name']; ?></h4>
                <div class="home-product-item__price"> 
                    <span class="home-product-item__price-current"><?php echo number_format($row['product_price'], 0, ',', '.'); ?>đ</span>
                </div>
            </div>    
        </a>
    </div>
<?php } ?>
                            </div>
                            <?php $conn->close(); ?>
                        </div>
                        <ui class="pagination home-product__pagination">
                           <li class="pagination-item">
                            <a href="" class="pagination-item__link">
                                <i class="pagination-item__icon fa-solid fa-arrow-left"></i>
                            </a>
                           </li>

                           <li class="pagination-item pagination-item--active">
                            <a href="" class="pagination-item__link">1</a>
                           </li>
                           <li class="pagination-item">
                            <a href="" class="pagination-item__link">2</a>
                           </li>
                           <li class="pagination-item">
                            <a href="" class="pagination-item__link">3</a>
                           </li>
                           <li class="pagination-item">
                            <a href="" class="pagination-item__link">4</a>
                           </li>
                           <li class="pagination-item">
                            <a href="" class="pagination-item__link">5</a>
                           </li>
                           <li class="pagination-item">
                            <a href="" class="pagination-item__link">6</a>
                           </li><li class="pagination-item">
                            <a href="" class="pagination-item__link">...</a>
                           </li>
                           <li class="pagination-item">
                            <a href="" class="pagination-item__link">9</a>
                           </li>
                           <li class="pagination-item">
                            <a href="" class="pagination-item__link">
                                <i class="pagination-item__icon fa-solid fa-arrow-right"></i>
                            </a>
                           </li> 
                        </ui>
                    </div>
                </div>
            </div>
        </div>
    <?php include '../include/footer.php'; ?>
    </div>
    <script src="/BANHANG/JS/index.js"></script>
</body>

</html>