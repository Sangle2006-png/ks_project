<?php
session_start();
// Xóa giỏ hàng sau khi đặt hàng thành công
unset($_SESSION['cart']);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đặt hàng thành công - Beck Sport</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/payment.css">
    <script src="https://kit.fontawesome.com/1147679ae7.js" crossorigin="anonymous"></script>
    <style>
        .success-container {
            text-align: center;
            padding: 80px 20px;
        }
        .success-container h1 {
            font-size: 32px;
            color: #4CAF50;
            margin-bottom: 20px;
        }
        .success-container p {
            font-size: 18px;
            margin-bottom: 40px;
        }
        .success-actions a {
            display: inline-block;
            margin: 0 10px;
            padding: 12px 30px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
        .success-actions a.secondary {
            background-color: #ccc;
            color: #333;
        }
    </style>
</head>
<body>

<header>
    <div class="logo">
        <img src="../images/logo.png" alt="Beck Sport Logo">
    </div>
</header>

<div class="success-container">
    <h1><i class="fas fa-check-circle"></i> Đặt hàng thành công!</h1>
    <p>Cảm ơn bạn đã mua hàng tại SK Sport. Chúng tôi sẽ liên hệ để xác nhận đơn hàng và tiến hành giao hàng sớm nhất.</p>
    <div class="success-actions">
        <a href="index.php">Quay về trang chủ</a>
        <a href="products.php" class="secondary">Tiếp tục mua sắm</a>
    </div>
</div>
<footer>
    <div class="footer-container">
        <!-- Về Chúng Tôi -->
        <div class="footer-section">
            <h3>Về Chúng Tôi</h3>
            <div class="logo-box">
                <h2>beck.</h2>
            </div>
            <div class="social-icons">
                <a href="#"><img src="../images/shopee.png" alt="Shopee"></a>
                <a href="#"><i class="fab fa-tiktok"></i></a>
                <a href="#"><i class="fab fa-facebook-messenger"></i></a>
            </div>
        </div>

        <!-- Thông Tin -->
        <div class="footer-section">
            <h3>Thông Tin</h3>
            <ul>
                <li><a href="#">Chính sách thanh toán</a></li>
                <li><a href="#">Chính sách giao nhận</a></li>
                <li><a href="#">Chính sách đổi trả</a></li>
                <li><a href="#">Chính sách bảo hành</a></li>
                <li><a href="#">Chính sách bảo mật</a></li>
            </ul>
        </div>

        <!-- Bản Đồ -->
        <div class="footer-section">
            <h3>Bản Đồ</h3>
            <img src="../images/shoplocation.png" alt="Store Location" class="store-image">
            <div class="newsletter">
                <h4>Đăng Ký Nhận Tin</h4>
                <div class="newsletter-form">
                    <input type="email" placeholder="Email của bạn">
                    <button><i class="fas fa-envelope"></i> ĐĂNG KÝ</button>
                </div>
            </div>
        </div>

        <!-- Liên Hệ -->
        <div class="footer-section">
            <h3>Liên Hệ</h3>
            <div class="contact-info">
                <p><i class="fas fa-map-marker-alt"></i> 639 Kim Ngưu, P. Vĩnh Tuy, Q. Hai Bà Trưng, Hà Nội</p>
                <p><i class="fas fa-phone"></i> Call/Zalo: 01D803767</p>
                <p><i class="fas fa-comment-dots"></i> Call/Zalo HKD BECK</p>
            </div>
            <div class="payment-methods">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2a/Mastercard-logo.svg/200px-Mastercard-logo.svg.png" alt="Mastercard">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/41/Visa_Logo.png/200px-Visa_Logo.png" alt="Visa">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/b5/PayPal.svg/200px-PayPal.svg.png" alt="PayPal">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/f/fa/American_Express_logo_%282018%29.svg/200px-American_Express_logo_%282018%29.svg.png" alt="Amex">
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <p>Cung cấp bởi Becksport © 2024. All rights reserved.</p>
    </div>
</footer>

</body>
</html>
