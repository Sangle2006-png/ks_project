<?php
session_start();
include_once __DIR__ . '/../admin/database.php'; // Đảm bảo file này tồn tại và chứa thông tin DB

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error = 'Vui lòng nhập đầy đủ thông tin.';
    } else {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $stmt = $conn->prepare("SELECT * FROM tbl_user WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
if ($user && password_verify($password, $user['password'])) {
    include_once '../admin/session.php';
    Session::set('login', true);
    Session::set('username', $user['username']);
    Session::set('role', $user['role']);

    // XÓA DÒNG exit() Ở ĐÂY!

    // Phân quyền chuyển hướng:
    if ($user['role'] === 'admin') {
        header("Location: ../admin/index.php");
        exit(); // exit() CHỈ GIỮ Ở ĐÂY
    } else {
        header("Location: ../index.php");
        exit(); // VÀ Ở ĐÂY
    }
}

         else {
            $error = 'Tài khoản hoặc mật khẩu không đúng.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập - Beck Sport</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
   <style>
  body {
    background-color: #fff8dc; /* vàng kem */
    color: #333333;
    font-family: 'Segoe UI', sans-serif;
  }

  .login-wrapper {
    max-width: 400px;
    margin: 100px auto;
    background: #ffffff; /* trắng */
    padding: 40px;
    border-radius: 10px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
  }

  .login-wrapper h2 {
    text-align: center;
    margin-bottom: 30px;
    color: #f4b400; /* vàng đậm */
  }

  .login-wrapper input {
    width: 100%;
    padding: 12px;
    margin: 10px 0;
    border: 1px solid #f4b400;
    border-radius: 6px;
    font-size: 16px;
    background-color: #fff8dc;
    color: #333333;
  }

  .login-wrapper input::placeholder {
    color: #999999;
  }

  .login-wrapper button {
    width: 100%;
    padding: 12px;
    background: #f4b400; /* vàng đậm */
    color: white;
    border: none;
    border-radius: 6px;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    transition: background 0.3s ease;
  }

  .login-wrapper button:hover {
    background: #d99900; /* vàng cam */
  }

  .error-message {
    color: red;
    text-align: center;
    margin-bottom: 10px;
  }

  .login-wrapper .register-link {
    text-align: center;
    margin-top: 15px;
  }

  .login-wrapper .register-link a {
    color: #f4b400;
    text-decoration: none;
    font-weight: bold;
  }

  .login-wrapper .register-link a:hover {
    text-decoration: underline;
  }
</style>

</head>
<body>

<div class="login-wrapper">
    <h2><i class="fa fa-user-circle"></i> Đăng nhập</h2>
    <?php if ($error): ?>
        <div class="error-message"><?php echo $error; ?></div>
    <?php endif; ?>
    <form method="POST" action="">
        <input type="text" name="username" placeholder="Tên đăng nhập" required>
        <input type="password" name="password" placeholder="Mật khẩu" required>
        <button type="submit">Đăng nhập</button>
    </form>
    <div class="register-link">
        Chưa có tài khoản? <a href="register.php">Đăng ký ngay</a>
    </div>
</div>

</body>
</html>
