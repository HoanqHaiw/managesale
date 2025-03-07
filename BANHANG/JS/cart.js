document.addEventListener("DOMContentLoaded", function () {
    loadCart(); // Gọi hàm loadCart khi trang được tải

    function loadCart() {
        fetch("get_cart.php") // Gọi API lấy giỏ hàng từ database
            .then(response => response.json())
            .then(data => {
                displayCart(data); // Hiển thị giỏ hàng
            })
            .catch(error => console.error("Lỗi khi lấy giỏ hàng:", error));
    }

    function displayCart(cart) {
        let cartTable = document.getElementById("cartItems");
        let totalPrice = 0;

        if (!cartTable) {
            console.error("Lỗi: Không tìm thấy phần tử cartItems.");
            return;
        }

        cartTable.innerHTML = cart.length ? "" : "<tr><td colspan='5'>Giỏ hàng trống</td></tr>";

        cart.forEach((item, index) => {
            let totalItemPrice = item.quantity * item.product_price;

            let row = `
                <tr>
                    <td>${item.product_name}</td>
                    <td>${item.product_price.toLocaleString()} VND</td>
                    <td>${item.quantity}</td>
                    <td>${totalItemPrice.toLocaleString()} VND</td>
                    <td><button onclick="removeItem(${item.cart_id})">Xóa</button></td>
                </tr>`;
            cartTable.innerHTML += row;
            totalPrice += totalItemPrice;
        });

        let totalElement = document.getElementById("totalPrice");
        if (totalElement) {
            totalElement.innerText = `${totalPrice.toLocaleString()} VND`;
        }
    }

    window.removeItem = function (cart_id) {
        fetch(`remove_from_cart.php?cart_id=${cart_id}`, { method: "GET" })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                loadCart();
            })
            .catch(error => console.error("Lỗi khi xóa sản phẩm:", error));
    };
});
