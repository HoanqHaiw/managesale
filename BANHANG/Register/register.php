<?php
include "../php/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["fullname"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    
    $sql = "INSERT INTO users (fullname, phone, email, password) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $username, $phone, $email, $password);
    
    if ($stmt->execute()) {
        echo "<script>alert('Đăng ký thành công!'); window.location.href='login.php';</script>";
    } else {
        echo "<script>alert('Lỗi: " . $conn->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký</title>
    <link rel="stylesheet" href="../asset/css/base.css">
    <link rel="stylesheet" href="../asset/css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="modal">
        <div class="modal__overlay"></div>
        <div class="modal__body">
            <div class="auth-form">
                <div class="auth-form__container">
                    <div class="auth-form__header">
                        <h3 class="auth-form__heading">Đăng Ký</h3>
                        <span class="auth-form__switch-btn" onclick="window.location.href='login.php'">Đăng Nhập</span>
                    </div>
                    <form action="register.php" method="POST" class="auth-form__form">
                        <div class="auth-form__group">
                            <input type="text" name="fullname" class="auth-form__input" placeholder="Nhập Tên Người Dùng" required>
                        </div>
                        <div class="auth-form__group">
                            <input type="text" name="phone" class="auth-form__input" placeholder="Nhập Số Điện Thoại" required>
                        </div>
                        <div class="auth-form__group">
                            <input type="email" name="email" class="auth-form__input" placeholder="Nhập Email" required>
                        </div>
                        <div class="auth-form__group">
                            <input type="password" name="password" class="auth-form__input" placeholder="Nhập Mật Khẩu" required>
                        </div>
                        <div class="auth-form__group">
                            <input type="password" name="confirm_password" class="auth-form__input" placeholder="Nhập Lại Mật Khẩu" required>
                        </div>
                        <div class="auth-form__controls">
                            <button type="button" class="btn btn--normal" onclick="window.history.back()">TRỞ LẠI</button>
                            <button type="submit" class="btn btn--primary">ĐĂNG KÝ</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
