
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liên hệ</title>
    <link rel="stylesheet" href="/BANHANG/asset/css/about.css">
</head>
<body>

<header>
    <a href="index.php">Trang chủ</a>
    <a href="about_us.php">Về Chúng Tôi</a>
    <a href="contact.php" class="active">Liên hệ</a>
</header>

<main>
    <div class="contact-section">
    <h2>Liên hệ với chúng tôi</h2>
    <form class="contact-form" action="send_contact.php" method="POST">
        <input type="text" name="fullname" placeholder="Họ và tên" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="phone" placeholder="Số điện thoại" required>
        <textarea name="message" placeholder="Nội dung tin nhắn" required></textarea>
        <button type="submit">Gửi tin nhắn</button>
    </form>
</div>
</main>

<footer>
    Bản quyền © 2025 Justin Hoàng.
</footer>

</body>

