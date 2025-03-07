<?php
session_start();
include "../php/db.php"; // Kết nối database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form và loại bỏ khoảng trắng thừa
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    if (empty($email) || empty($password)) {
        $error = "Vui lòng nhập đầy đủ email và mật khẩu!";
    } else {
        // Chuẩn bị truy vấn SQL
        $sql = "SELECT user_id, fullname, password, role FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // Kiểm tra mật khẩu
            if (password_verify($password, $row["password"])) {
                // Lưu thông tin vào SESSION
                $_SESSION["user_id"] = $row["user_id"];
                $_SESSION["fullname"] = $row["fullname"];
                $_SESSION["role"] = $row["role"]; // Lưu quyền người dùng

                // Điều hướng dựa trên quyền
                if ($row["role"] == "admin") {
                    header("Location: ../index.php"); // Trang admin
                } else {
                    header("Location: ../index.php"); // Trang chính
                }
                exit();
            } else {
                $error = "Mật khẩu không đúng!";
            }
        } else {
            $error = "Email không tồn tại!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập</title>
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
                        <h3 class="auth-form__heading">Đăng Nhập</h3>
                        <span class="auth-form__switch-btn" onclick="window.location.href='register.php'">Đăng Ký</span>
                    </div>
                    
                    <?php if (isset($error)) echo "<p style='color:red; text-align:center;'>$error</p>"; ?>
                    
                    <form action="login.php" method="POST" class="auth-form__form">
                        <div class="auth-form__group">
                            <input type="email" name="email" class="auth-form__input" placeholder="Nhập Email" required>
                        </div>
                        <div class="auth-form__group">
                            <input type="password" name="password" class="auth-form__input" placeholder="Nhập Mật Khẩu" required>
                        </div>
                        <div class="auth-form__controls">
                            <button type="button" class="btn btn--normal" onclick="window.history.back()">TRỞ LẠI</button>
                            <button type="submit" class="btn btn--primary">ĐĂNG NHẬP</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>