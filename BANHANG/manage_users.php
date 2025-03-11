<!-- QUẢN LÝ NGUOIWF DÙNG PHÂN QUYỀN ADMIN -->
<?php
session_start();
require './php/db.php';

// Kiểm tra nếu người dùng không phải admin thì không cho truy cập
if (!isset($_SESSION["role"]) || $_SESSION["role"] != "admin") {
    header("Location: index.php");
    exit();
}

// Lấy danh sách người dùng
$sql = "SELECT user_id, fullname, phone, email, role FROM users";
$result = $conn->query($sql);

// Xử lý thay đổi quyền (Admin <-> Member)
if (isset($_POST['change_role'])) {
    $user_id = intval($_POST['user_id']);
    $new_role = ($_POST['current_role'] == 'admin') ? 'member' : 'admin';

    $update_sql = "UPDATE users SET role = ? WHERE user_id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("si", $new_role, $user_id);

    if ($stmt->execute()) {
        echo "<script>alert('Cập nhật quyền thành công!'); window.location.href='manage_users.php';</script>";
    } else {
        echo "<script>alert('Lỗi khi cập nhật quyền!');</script>";
    }
}

// Xử lý xóa người dùng
if (isset($_POST['delete_user'])) {
    $user_id = intval($_POST['user_id']);

    $delete_sql = "DELETE FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        echo "<script>alert('Xóa tài khoản thành công!'); window.location.href='manage_users.php';</script>";
    } else {
        echo "<script>alert('Lỗi khi xóa tài khoản!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý người dùng</title>
    <link rel="stylesheet" href="/BANHANG/asset/css/cart.css">
</head>
<body>
    <h2>Danh sách người dùng</h2>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Họ và Tên</th>
                <th>Số điện thoại</th>
                <th>Email</th>
                <th>Quyền</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['user_id']; ?></td>
                <td><?php echo htmlspecialchars($row['fullname']); ?></td>
                <td><?php echo htmlspecialchars($row['phone']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td><?php echo ucfirst($row['role']); ?></td>
                <td>
                    <form method="post" style="display:inline;">
                        <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
                        <input type="hidden" name="current_role" value="<?php echo $row['role']; ?>">
                        <button type="submit" name="change_role">
                            <?php echo ($row['role'] == 'admin') ? 'Hạ xuống Member' : 'Nâng lên Admin'; ?>
                        </button>
                    </form>

                    <form method="post" style="display:inline;" onsubmit="return confirm('Bạn có chắc muốn xóa tài khoản này?');">
                        <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
                        <button type="submit" name="delete_user" style="background-color:red;">Xóa</button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <a href="index.php">
        <button id="homeButton">Quay lại trang chủ</button>
    </a>
</body>
</html>
