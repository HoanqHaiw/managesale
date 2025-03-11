document.addEventListener("DOMContentLoaded", function() {
    function loadCart() {
        fetch("cart.php?action=view")
            .then(response => response.json())
            .then(data => {
                console.log("Dữ liệu giỏ hàng nhận được:", data); // Debug xem có dữ liệu không
                let cartItems = document.getElementById("cartItems");
                cartItems.innerHTML = "";
                let total = 0;

                if (data.length === 0) {
                    cartItems.innerHTML = "<tr><td colspan='5'>Giỏ hàng trống</td></tr>";
                    document.getElementById("totalPrice").textContent = "0 VNĐ";
                    return;
                }

                data.forEach(item => {
                    let row = `<tr>
                        <td>${item.product_name}</td>
                        <td>${item.product_price} VNĐ</td>
                        <td>${item.quantity}</td>
                        <td>${item.total_price} VNĐ</td>
                        <td><button class='removeItem' data-id='${item.product_id}'>Xóa</button></td>
                    </tr>`;
                    cartItems.innerHTML += row;
                    total += parseInt(item.total_price);
                });
                document.getElementById("totalPrice").textContent = total + " VNĐ";
            })
            .catch(error => console.error("Lỗi khi tải giỏ hàng:", error));
    }

    document.addEventListener("click", function(e) {
        if (e.target.classList.contains("removeItem")) {
            let itemId = e.target.getAttribute("data-id");
            fetch("cart.php?action=remove", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ item_id: itemId })
            })
            .then(() => loadCart());
        }
    });

    loadCart();
    // back về trang chủ
    document.getElementById("homeButton").addEventListener("click", function () {
        window.location.href = "index.php";
    });
    // thanh toán
    document.getElementById("checkoutButton").addEventListener("click", function () {
        window.location.href = "checkout.php";
    });
});
