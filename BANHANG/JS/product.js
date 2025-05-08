// product.js

document.addEventListener('DOMContentLoaded', function () {
    const buyNowBtn = document.getElementById('buyNow');
    const addToCartBtn = document.getElementById('addToCart');

    if (buyNowBtn) {
        buyNowBtn.addEventListener('click', function () {
            const productId = this.dataset.id;
            const size = document.getElementById('size').value;
            const quantity = document.getElementById('quantity').value;

            if (!size) {
                alert('Vui lòng chọn size!');
                return;
            }

            window.location.href = `/BANHANG/checkout.php?id=${productId}&size=${size}&quantity=${quantity}`;
        });
    }

    if (addToCartBtn) {
        addToCartBtn.addEventListener('click', function () {
            const productId = this.dataset.id;
            const size = document.getElementById('size').value;
            const quantity = document.getElementById('quantity').value;

            if (!size) {
                alert('Vui lòng chọn size!');
                return;
            }

            const formData = new FormData();
            formData.append('product_id', productId);
            formData.append('size', size);
            formData.append('quantity', quantity);

            fetch('/BANHANG/add_to_cart.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                console.log(data);
                window.location.href = '/BANHANG/cart.php'; // Redirect sau khi thêm thành công
            })
            .catch(error => {
                console.error('Error:', error);
                alert('❌ Lỗi thêm vào giỏ hàng!');
            });
        });
    }
});

function requireLogin() {
    alert("Bạn cần đăng nhập để thực hiện chức năng này!");
    window.location.href = '/BANHANG/Register/login.php';
}
