document.addEventListener("DOMContentLoaded", function() {
    function checkLogin(callback) {
        fetch("check_login.php")
            .then(response => response.json())
            .then(data => {
                callback(data.isLoggedIn);
            })
            .catch(error => {
                console.error("Lỗi kiểm tra đăng nhập:", error);
                callback(false);
            });
    }
    // Xử lý khi bấm nút "Thêm vào giỏ hàng"    
    
    document.getElementById("addToCart").addEventListener("click", function () {
        checkLogin(function (isLoggedIn) {
            if (!isLoggedIn) {
                alert("Bạn cần đăng nhập để thêm sản phẩm vào giỏ hàng!");
                window.location.href = "./Register/Login.php";
                return;
            }
    
            let productId = document.getElementById("addToCart").getAttribute("data-id");
            let productName = document.getElementById("addToCart").getAttribute("data-name");
            let productPrice = document.getElementById("addToCart").getAttribute("data-price");
            let quantity = parseInt(document.getElementById("quantity").value) || 1;
    
            fetch("cart.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({
                    action: "add",
                    product_id: productId,
                    product_name: productName,
                    product_price: productPrice,
                    quantity: quantity
                })
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
            })
            .catch(error => {
                console.error("Lỗi:", error);
            });
        });
    });
    
        // Xử lý khi bấm nút "Xem Giỏ Hàng"
    document.querySelector(".header__cart-view-cart").addEventListener("click", function () {
        window.location.href = "cart.php";
    });
    // Xử lý khi bấm nút mua ngay
    document.getElementById("buyNow").addEventListener("click", function() {
        const productId = this.dataset.id;
        const productName = this.dataset.name;
        const productPrice = this.dataset.price;
        const quantity = document.getElementById("quantity").value;
    
        // Chuyển hướng đến trang thanh toán với sản phẩm đã chọn
        window.location.href = `checkout.php?product_id=${productId}&product_name=${encodeURIComponent(productName)}&product_price=${productPrice}&quantity=${quantity}`;
    });       
});
