document.addEventListener("DOMContentLoaded", function () {
    // Kiểm tra người dùng đã đăng nhập hay chưa
    const isLoggedIn = localStorage.getItem("isLoggedIn") === "true"; // Giả định có giá trị true/false

    const product = JSON.parse(localStorage.getItem("selectedProduct"));

    if (product) {
        const productImg = document.querySelector(".product-img");
        const productTitle = document.querySelector(".product__title");
        const productPrice = document.querySelector(".product__price");

        if (productImg) productImg.src = product.image;
        if (productTitle) productTitle.innerText = product.name;
        
        let priceText = product.priceCurrent ? product.priceCurrent.replace(/[^\d]/g, '') : '';  
        let price = priceText ? parseFloat(priceText) : 0;  

        if (price === 0) {
            alert("Lỗi: Giá sản phẩm không hợp lệ!");
            return;
        }

        if (productPrice) productPrice.innerText = "Giá: " + price.toLocaleString() + " VND";
    }

    // Thêm vào giỏ hàng
    const addToCartButton = document.getElementById("addToCart");
    if (addToCartButton) {
        addToCartButton.addEventListener("click", function (event) {
            if (!isLoggedIn) {
                event.preventDefault();
                alert('Bạn cần đăng nhập để thêm vào giỏ hàng.');
                window.location.href = './Register/Login.php'; 
                return;
            }

            const cart = JSON.parse(localStorage.getItem("cart")) || [];
            const quantityInput = document.querySelector(".product__quantity");
            let quantity = quantityInput ? parseInt(quantityInput.value) : 0;
            
            if (isNaN(quantity) || quantity <= 0) {
                alert("Vui lòng nhập số lượng hợp lệ!");
                return;
            }
            
            const cartItem = { ...product, quantity };
        
            // Kiểm tra sản phẩm đã tồn tại chưa
            const existingItem = cart.find(item => item.name === cartItem.name);
            if (existingItem) {
                existingItem.quantity += quantity;
            } else {
                cart.push(cartItem);
            }
            
            localStorage.setItem("cart", JSON.stringify(cart));
            updateCartCount(); 
            alert("Sản phẩm đã được thêm vào giỏ hàng!");
        });
    }

    // Xử lý khi bấm vào "Mua Ngay"
    const buyNowButton = document.getElementById("buyNow");
    if (buyNowButton) {
        buyNowButton.addEventListener("click", function (event) {
            if (!isLoggedIn) {
                event.preventDefault();
                alert('Bạn cần đăng nhập để mua hàng.');
                window.location.href = './Register/Login.php'; 
                return;
            }

            if (!product) {
                alert("Lỗi: Không tìm thấy thông tin sản phẩm!");
                return;
            }

            const quantityInput = document.querySelector(".product__quantity");
            let quantity = quantityInput ? parseInt(quantityInput.value) : 0;
            if (isNaN(quantity) || quantity <= 0) {
                alert("Vui lòng nhập số lượng hợp lệ!");
                return;
            }

            // Xóa giỏ hàng cũ và thêm sản phẩm mới
            const cart = [{ ...product, quantity }];
            localStorage.setItem("cart", JSON.stringify(cart));

            // Chuyển hướng đến giỏ hàng
            window.location.href = "cart.php";
        });
    } else {
        console.error("❌ Không tìm thấy nút Mua Ngay (buyNow)");
    }
});

// Cập nhật số sản phẩm trong giỏ hàng
function updateCartCount() {
    const cart = JSON.parse(localStorage.getItem("cart")) || [];
    let totalQuantity = cart.reduce((sum, item) => sum + item.quantity, 0);

    const cartNotice = document.querySelector(".header__cart-no-notice");
    if (cartNotice) {
        cartNotice.innerText = totalQuantity;
        cartNotice.style.display = totalQuantity > 0 ? "block" : "none";
    }
}

// Xử lý khi bấm vào giỏ hàng
document.addEventListener("DOMContentLoaded", function () {
    updateCartCount();

    const cartButton = document.querySelector(".header__cart-view-cart");
    if (cartButton) {
        cartButton.addEventListener("click", function () {
            window.location.href = "cart.php";
        });
    }
});
// sửa sản phẩm
document.getElementById("editProduct").addEventListener("click", function() {
    window.location.href = "edit_product.php";
});

