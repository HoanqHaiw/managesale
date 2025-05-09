// product.js

document.addEventListener('DOMContentLoaded', function () {
    const buyNowBtn = document.getElementById('buyNow');
    const addToCartBtn = document.getElementById('addToCart');
    const sizeSelect = document.getElementById('size');
    const stockQuantityText = document.getElementById('stockQuantity');
    const quantityInput = document.getElementById('quantity');

    if (sizeSelect) {
        sizeSelect.addEventListener('change', function () {
            const selectedSize = this.value;
            if (selectedSize && sizesStock[selectedSize] !== undefined) {
                const availableStock = sizesStock[selectedSize];
                stockQuantityText.textContent = availableStock;
                quantityInput.max = availableStock;
                quantityInput.value = 1;

                if (availableStock === 0) {
                    alert('❌ Size này đã hết hàng!');
                }
            } else {
                // Nếu chưa chọn size hoặc size không tồn tại
                let totalStock = 0;
                for (let size in sizesStock) {
                    totalStock += parseInt(sizesStock[size]);
                }
                stockQuantityText.textContent = totalStock;
                quantityInput.max = totalStock;
                quantityInput.value = 1;
            }
        });
    }

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
                window.location.href = '/BANHANG/cart.php';
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
