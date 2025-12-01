<?php
include_once 'session.php';
Session::init();

if (Session::get('login') !== true || Session::get('role') !== 'admin') {
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Trang quản trị - Beck Sport</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #fff8dc;
            margin: 0;
            padding: 0;
        }
        .header {
            background-color: #f4b400;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .container {
            padding: 30px;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
        }
        .card {
            background: white;
            border: 2px solid #f4b400;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            transition: transform 0.2s ease;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .card a {
            text-decoration: none;
            color: #f4b400;
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="header">
    <h1>👋 Chào mừng Admin: <?php echo Session::get('username'); ?></h1>
    <p>Trang quản trị hệ thống Beck Sport</p>
</div>

<div class="container">
    <div class="grid">
        <div class="card">
            <h3>🏷️ Quản lý thương hiệu</h3>
            <a href="brandlist.php">Xem danh sách</a>
            <a href="brandadd.php">Thêm mới</a>
        </div>

        <div class="card">
            <h3>📁 Quản lý danh mục</h3>
            <a href="categorylist.php">Xem danh sách</a>
            <a href="categoryadd.php">Thêm mới</a>
        </div>

        <div class="card">
            <h3>📦 Quản lý sản phẩm</h3>
            <a href="productadd.php">Thêm sản phẩm</a>
            <a href="productlist.php">Danh sách sản phẩm</a>
        </div>

        <div class="card">
            <h3>🖼️ Quản lý slider</h3>
            <a href="slider.php">Cập nhật slider</a>
        </div>

        <div class="card">
            <h3>📝 Trình soạn thảo</h3>
            <a href="ckeditor/">CKEditor</a>
            <a href="ckfinder/">CKFinder</a>
        </div>

        <div class="card">
            <h3>📂 Quản lý ảnh</h3>
            <a href="uploads/">Thư mục ảnh</a>
            <a href="images/">Thư mục hình ảnh</a>
        </div>

        <div class="card">
            <h3>⚙️ Cấu hình hệ thống</h3>
            <a href="config.php">File config</a>
            <a href="database.php">Kết nối DB</a>
            <a href="format.php">Định dạng dữ liệu</a>
        </div>

        <div class="card">
            <h3>🔐 Phiên làm việc</h3>
            <a href="session.php">Session</a>
            <a href="../frontend/login.php">Đăng xuất</a>
        </div>
    </div>
</div>

</body>
</html>
