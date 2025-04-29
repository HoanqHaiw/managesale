<?php
session_start();
include './php/db.php';

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

if (!isset($_SESSION['user_id'])) {
    die("Bạn chưa đăng nhập.");
}
$user_id = $_SESSION['user_id'];

$message = "";

// Hàm kiểm tra số điện thoại và email
function isValidPhone($phone) {
    return preg_match('/^\d{10}$/', $phone);
}
function isValidEmail($email) {
    return strpos($email, '@') !== false;
}

// Lấy thông tin hiện tại của user để show vào form
$sql = "SELECT fullname, phone, email FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($fullname, $phone, $email);
$stmt->fetch();
$stmt->close();

// Xử lý form submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = trim($_POST["fullname"]);
    $phone = trim($_POST["phone"]);
    $email = trim($_POST["email"]);
    $new_password = trim($_POST["password"]);

    if (empty($fullname) || empty($phone) || empty($email)) {
        $message = "❌ Vui lòng điền đầy đủ thông tin.";
    } elseif (!isValidPhone($phone)) {
        $message = "❌ Số điện thoại phải đúng 10 số.";
    } elseif (!isValidEmail($email)) {
        $message = "❌ Email không hợp lệ (thiếu @).";
    } else {
        if (!empty($new_password)) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $sql = "UPDATE users SET fullname=?, phone=?, email=?, password=? WHERE user_id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssi", $fullname, $phone, $email, $hashed_password, $user_id);
        } else {
            $sql = "UPDATE users SET fullname=?, phone=?, email=? WHERE user_id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssi", $fullname, $phone, $email, $user_id);
        }

        if ($stmt->execute()) {
            $message = "✅ Cập nhật thành công!";
        } else {
            $message = "❌ Lỗi: " . $stmt->error;
        }
        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chỉnh sửa hồ sơ</title>
    <link rel="stylesheet" href="/BANHANG/asset/css/cart.css">
    <link rel="stylesheet" href="./asset/css/base.css">
    <link rel="stylesheet" href="./asset/css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
        <?php include '../include/header.php'; ?>
        <h2 style="text-align:center; color: var(--primary-color); font-size: 2.4rem;">Chỉnh sửa thông tin cá nhân</h2>

        <form method="post">
            <div class="form-group">
                <label for="fullname">Họ tên:</label>
                <input type="text" name="fullname" id="fullname" value="<?= htmlspecialchars($fullname) ?>" required>
            </div>
            <div class="form-group">
                <label for="phone">Số điện thoại:</label>
                <input type="text" name="phone" id="phone" value="<?= htmlspecialchars($phone) ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" value="<?= htmlspecialchars($email) ?>" required>
            </div>
            <div class="form-group">
                <label for="password">Mật khẩu mới (bỏ trống nếu không đổi):</label>
                <input type="password" name="password" id="password">
            </div>
            <button type="submit" class="btn btn--primary">Cập nhật</button>
            <a href="/BANHANG/index.php" class="btn btn--primary">Trở về trang chủ</a>
        </form>

        <?php 
        if (!empty($message)) {
            echo "<script>
                alert(".json_encode($message).");
                window.location.href = '/BANHANG/index.php';
            </script>";
        }
        ?>

        <?php include '../include/footer.php'; ?>
    </div>
</body>
</html>
