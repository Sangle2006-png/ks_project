<?php
session_start();
include_once __DIR__ . '/../admin/database.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm'] ?? '';

    if ($username === '' || $email === '' || $phone === '' || $password === '' || $confirm === '') {
        $error = 'Vui lòng nhập đầy đủ thông tin.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Email không hợp lệ.';
    } elseif (!preg_match('/^[0-9]{9,11}$/', $phone)) {
        $error = 'Số điện thoại không hợp lệ.';
    } elseif ($password !== $confirm) {
        $error = 'Mật khẩu xác nhận không khớp.';
    } else {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $stmt = $conn->prepare("SELECT * FROM tbl_user WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = 'Tên đăng nhập hoặc email đã tồn tại.';
        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $insert = $conn->prepare("INSERT INTO tbl_user (username, email, phone, password, role) VALUES (?, ?, ?, ?, 'user')");
            $insert->bind_param("ssss", $username, $email, $phone, $hashed);
            if ($insert->execute()) {
                $success = 'Đăng ký thành công! Đang chuyển hướng...';
                header("refresh:2;url=login.php");
            } else {
                $error = 'Lỗi khi đăng ký. Vui lòng thử lại.';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký - Beck Sport</title>
    <style>
        body {
            background-color: #fff8dc;
            color: #333333;
            font-family: 'Segoe UI', sans-serif;
        }
        .register-wrapper {
            max-width: 420px;
            margin: 100px auto;
            background: #ffffff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }
        .register-wrapper h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #f4b400;
        }
        .register-wrapper input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #f4b400;
            border-radius: 6px;
            font-size: 16px;
            background-color: #fff8dc;
            color: #333333;
        }
        .register-wrapper input::placeholder {
            color: #999999;
        }
        .register-wrapper button {
            width: 100%;
            padding: 12px;
            background: #f4b400;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        .register-wrapper button:hover {
            background: #d99900;
        }
        .error-message {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }
        .success-message {
            color: green;
            text-align: center;
            margin-bottom: 10px;
        }
        .register-wrapper .login-link {
            text-align: center;
            margin-top: 15px;
        }
        .register-wrapper .login-link a {
            color: #f4b400;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="register-wrapper">
    <h2>Đăng ký tài khoản</h2>
    <?php if ($error): ?>
        <div class="error-message"><?php echo $error; ?></div>
    <?php elseif ($success): ?>
        <div class="success-message"><?php echo $success; ?></div>
    <?php endif; ?>
    <form method="POST" action="">
        <input type="text" name="username" placeholder="Tên đăng nhập" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="phone" placeholder="Số điện thoại" required>
        <input type="password" name="password" placeholder="Mật khẩu" required>
        <input type="password" name="confirm" placeholder="Xác nhận mật khẩu" required>
        <button type="submit">Đăng ký</button>
    </form>
    <div class="login-link">
        Đã có tài khoản? <a href="login.php">Đăng nhập ngay</a>
    </div>
</div>

</body>
</html>
