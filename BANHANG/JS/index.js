
// index.js - Xử lý khi bấm vào sản phẩm trong index.html
document.querySelectorAll(".home-product-item").forEach(item => {
    item.addEventListener("click", function (event) {
        event.preventDefault();
        
        const product = {
            name: this.querySelector(".home-product-item__name")?.innerText || "",
            image: this.querySelector(".home-product-item__img")?.style.backgroundImage.slice(5, -2) || "",
            priceOld: this.querySelector(".home-product-item__price-old")?.innerText || "",
            priceCurrent: this.querySelector(".home-product-item__price-current")?.innerText || ""
        };
        
        localStorage.setItem("selectedProduct", JSON.stringify(product));
        window.location.href = "product.php";
    });
});





// product.js - Hiển thị thông tin sản phẩm từ localStorage
document.addEventListener("DOMContentLoaded", function () {
    const product = JSON.parse(localStorage.getItem("selectedProduct"));
    if (product) {
        document.querySelector(".product-img").src = product.image;
        document.querySelector(".product__title").innerText = product.name;
        document.querySelector(".product__price").innerText = "Giá: " + product.priceCurrent + " VND";
    }

    // Thêm vào giỏ hàng
    document.getElementById("addToCart").addEventListener("click", function () {
        const cart = JSON.parse(localStorage.getItem("cart")) || [];
        let quantity = parseInt(document.querySelector(".product__quantity").value);
        
        if (isNaN(quantity) || quantity <= 0) {
            alert("Vui lòng nhập số lượng hợp lệ!");
            return;
        }

        // Chuyển đổi giá thành số để tránh lỗi NaN
        let price = parseFloat(product.priceCurrent.replace(/[^\d]/g, '')); 
        
        if (isNaN(price)) {
            alert("Lỗi giá sản phẩm!");
            return;
        }

        const cartItem = { 
            ...product, 
            quantity, 
            price
        };
    
        // Kiểm tra sản phẩm đã tồn tại chưa
        const existingItem = cart.find(item => item.name === cartItem.name);
        if (existingItem) {
            existingItem.quantity += quantity;
        } else {
            cart.push(cartItem);
        }
        
        localStorage.setItem("cart", JSON.stringify(cart));
        updateCartCount(); // Cập nhật số lượng giỏ hàng
        alert("Sản phẩm đã được thêm vào giỏ hàng!");
    });
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

// Hiển thị danh sách sản phẩm trong giỏ hàng khi hover vào cart
document.addEventListener("DOMContentLoaded", function () {
    const cartList = document.querySelector(".header__cart-list-item");
    const cartWrapper = document.querySelector(".header__cart-list");
    
    function renderCart() {
        const cart = JSON.parse(localStorage.getItem("cart")) || [];
        cartList.innerHTML = ""; // Xóa dữ liệu cũ trước khi render

        if (cart.length === 0) {
            cartWrapper.classList.add("header__cart-list--no-cart");
        } else {
            cartWrapper.classList.remove("header__cart-list--no-cart");
            cart.forEach(item => {
                const cartItem = document.createElement("li");
                cartItem.classList.add("header__cart-item");
                cartItem.innerHTML = `
                    <img src="${item.image}" class="header__cart-img">
                    <div class="header__cart-item-info">
                        <span class="header__cart-item-name">${item.name}</span>
                        <span class="header__cart-item-price">${item.price.toLocaleString()} VND</span>
                        <span class="header__cart-item-quantity">x${item.quantity}</span>
                    </div>
                `;
                cartList.appendChild(cartItem);
            });
        }
    }

    // Gọi hàm renderCart khi hover vào giỏ hàng
    document.querySelector(".header__cart-wrap").addEventListener("mouseenter", function () {
        renderCart();
    });

    // Cập nhật số lượng giỏ hàng ngay khi tải trang
    updateCartCount();
});

