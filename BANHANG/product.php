<?php
session_start();
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PRODUCT</title>
    <link rel="stylesheet" href="./asset/css/base.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="./asset/css/page1.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:wght@200&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./asset/css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css"
        integrity="sha512-NhSC1YmyruXifcj/KFRWoC561YpHpc5Jtzgvbuzx5VozKpWvQ+4nXhPdFgmx8xqexRcpAglTj9sIBWINXa8x5w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div class="app">
        <?php include '../include/header.php'; ?>
        <div class="app__container">
            <div class="product">
                <div class="product__container">
                    <div class="product__image">
                        <img src="<?php echo $product['image']; ?>" alt="Sản phẩm" class="product-img">
                    </div>
                    <div class="product__details">
                        <h2 class="product__title"><?php echo $product['name']; ?></h2>
                        <div class="home-product-item__action">
                            <p class="product__code">Mã Sản Phẩm: 123456</p>
                            <span class="home-product-item__rating">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                            </span>
                            <span class="home-product-item__sold">88 đã bán</span>
                        </div>
                        <p class="product__price">Giá: <span id="productPrice"><?php echo $product['priceCurrent']; ?></span> VNĐ</p>
                        <div class="quantity_form">
                            <label for="quantity" style="font-size: 1.6rem;">Số Lượng:</label>
                            <input type="number" id="quantity" name="quantity" min="1" value="1" class="product__quantity">
                        </div>
                        <div class="product__buttons">
                            <?php if (!isset($_SESSION["role"]) || $_SESSION["role"] != "admin"): ?>
                                <button id="buyNow"
                                        class="btn btn--buy"
                                        data-id="123456"
                                        data-name="<?php echo $product['name']; ?>"
                                        data-price="<?php echo $product['priceCurrent']; ?>">
                                        Mua Ngay
                                </button>
                                <button id="addToCart"
                                        class="btn btn--add-cart"
                                        data-id="123456"
                                        data-name="<?php echo $product['name']; ?>"
                                        data-price="<?php echo $product['priceCurrent']; ?>">
                                    <i class="fa-solid fa-cart-shopping"></i> Thêm vào Giỏ Hàng
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php include '../include/footer.php'; ?>
        </div>
    </div>
    <script>
        const isLoggedIn = <?php echo json_encode($isLoggedIn); ?>;
    </script>
    <script src="/BANHANG/JS/product.js"></script>
</body>
