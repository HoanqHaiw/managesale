document.addEventListener("DOMContentLoaded", function() {
    function checkLogin(callback) {
        fetch("check_login.php")
            .then(response => response.json())
            .then(data => callback(data.logged_in));
    }
    
    document.getElementById("addToCart").addEventListener("click", function() {
        checkLogin(function(isLoggedIn) {
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
            });
        });
    });
        // Xử lý khi bấm nút "Xem Giỏ Hàng"
    document.querySelector(".header__cart-view-cart").addEventListener("click", function () {
        window.location.href = "cart.php";
    });

    document.getElementById("buyNow").addEventListener("click", function() {
        checkLogin(function(isLoggedIn) {
            if (!isLoggedIn) {
                alert("Bạn cần đăng nhập để mua hàng!");
                window.location.href = "./Register/Login.php";
                return;
            }
            let productId = this.getAttribute("data-id");
            let productPrice = this.getAttribute("data-price");  // Lấy giá sản phẩm
            let quantity = document.getElementById("quantity").value;
            
            window.location.href = `cart.php?action=buy_now&product_id=${productId}&quantity=${quantity}&price=${productPrice}`;
        });
    });    
});
