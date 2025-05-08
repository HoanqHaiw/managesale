// Hàm thêm vào giỏ hàng
function addToCart(productId, productName, productPrice) {
    fetch('/BANHANG/cart.php?action=add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            product_id: productId,
            product_name: productName,
            product_price: productPrice,
            quantity: 1
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('✅ ' + data.message); // Thông báo thành công
        } else {
            alert('❌ Lỗi: ' + data.message); // Báo lỗi nếu có
        }
    })
    .catch(error => {
        console.error('❌ Lỗi fetch:', error);
        alert('❌ Đã xảy ra lỗi khi thêm sản phẩm!');
    });
}

// Hàm mua ngay
function buyNow(productId, productName, productPrice) {
    fetch('/BANHANG/cart.php?action=add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            product_id: productId,
            product_name: productName,
            product_price: productPrice,
            quantity: 1
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Sau khi thêm thành công thì chuyển sang trang thanh toán
            window.location.href = '/BANHANG/checkout.php';
        } else {
            alert('❌ Không thể mua ngay: ' + data.message);
        }
    })
    .catch(error => {
        console.error('❌ Lỗi fetch:', error);
        alert('❌ Đã xảy ra lỗi khi mua ngay!');
    });
}
