
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".home-product-item").forEach(item => {
        item.addEventListener("click", function (event) {
            event.preventDefault();
            
            let productId = this.getAttribute("data-id"); // Lấy ID sản phẩm
            if (!productId) {
                alert("❌ Không có ID sản phẩm!");
                return;
            }
            
            window.location.href = `product.php?id=${productId}`;
        });
    });

    // Xử lý khi bấm nút "Mua Ngay"
    document.getElementById("buyNowBtn")?.addEventListener("click", function () {
        let productId = document.getElementById("productId")?.value; // ID sản phẩm
        if (!productId) {
            alert("❌ Không có ID sản phẩm!");
            return;
        }
        window.location.href = `cart.php?id=${productId}`;
    });

    // Xử lý khi bấm nút "Thêm vào Giỏ Hàng"
    document.getElementById("addToCartBtn")?.addEventListener("click", function () {
        let productId = document.getElementById("productId")?.value;
        if (!productId) {
            alert("❌ Không có ID sản phẩm!");
            return;
        }

        let cart = JSON.parse(localStorage.getItem("cart")) || [];
        let product = {
            id: productId,
            name: document.getElementById("productName")?.innerText || "",
            price: document.getElementById("productPrice")?.innerText || "",
            image: document.getElementById("productImage")?.src || ""
        };

        // Kiểm tra nếu sản phẩm đã tồn tại trong giỏ hàng
        let existingProduct = cart.find(item => item.id === productId);
        if (existingProduct) {
            existingProduct.quantity += 1;
        } else {
            product.quantity = 1;
            cart.push(product);
        }

        localStorage.setItem("cart", JSON.stringify(cart));
        alert("🛒 Giỏ hàng thành công!");
    });
    // Xử lý khi bấm nút "Xem Giỏ Hàng"
    document.querySelector(".header__cart-view-cart").addEventListener("click", function () {
        window.location.href = "cart.php";
    });
});


