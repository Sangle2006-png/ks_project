<?php
session_start();
include_once __DIR__ . '/../admin/class/product_class.php';
$product = new product();

// Nhận thông tin giao hàng từ delivery.php
$fullName = $_POST['fullName'] ?? '';
$phone = $_POST['phone'] ?? '';
$province = $_POST['province'] ?? '';
$district = $_POST['district'] ?? '';
$address = $_POST['address'] ?? '';

// Tính toán giỏ hàng
$total_quantity = 0;
$total_price = 0;
$final_price = 0;
$shipping_fee = 38000;
$cart_items = [];

if (!empty($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        if (!is_array($item) || !isset($item['product_id']) || !isset($item['quantity'])) continue;

        $product_id = $item['product_id'];
        $quantity = $item['quantity'];
        $size = $item['size'] ?? '';

        $product_detail = $product->get_product_detail($product_id);
        if ($product_detail && is_array($product_detail)) {
            $price = isset($product_detail['product_price_new']) ? floatval(str_replace('.', '', $product_detail['product_price_new'])) : 0;
            $original_price = isset($product_detail['product_price']) ? floatval(str_replace('.', '', $product_detail['product_price'])) : 0;
            $discount = ($original_price > $price) ? round((($original_price - $price) / $original_price) * 100) : 0;
            $item_total = $price * $quantity;

            $total_quantity += $quantity;
            $total_price += $original_price * $quantity;
            $final_price += $item_total;

            $cart_items[] = [
                'product_id' => $product_id,
                'name' => $product_detail['product_name'] ?? 'Sản phẩm',
                'image' => $product_detail['product_img'] ?? 'default.jpg',
                'price' => $original_price,
                'discounted_price' => $price,
                'discount' => $discount,
                'quantity' => $quantity,
                'item_total' => $item_total,
                'code' => $product_id,
                'size' => $size
            ];
        }
    }
}

$grand_total = $final_price + $shipping_fee;
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thanh toán - Beck Sport</title>
    <link rel="stylesheet" href="../css/style.css">
   
    <script src="https://kit.fontawesome.com/1147679ae7.js" crossorigin="anonymous"></script>
</head>
<body>

<header>
        <div class="logo">
            <img src="../images/logo.png" alt="Beck Sport Logo">
        </div>
       <div class="menu">
          <li><a href="products.php">TẤT CẢ SẢN PHẨM</a></li> <!-- THÊM DÒNG NÀY -->
        <li><a href="#">Giày Ba Sọc</a> 
            <ul class="sub-menu">
              <li><a href="cartegory.php?brand_id=1">Ba Sọc Beck Truyền Thống</a></li>
              <li><a href="cartegory.php?brand_id=4">Ba Sọc ACE 16</a></li>
              <li><a href="cartegory.php?brand_id=11">Giày Ba Sọc Toni</a></li>
              <li><a href="cartegory.php?brand_id=6">Giày Ba Sọc Phủi F50</a></li>
              <li><a href="cartegory.php?brand_id=3">Giày Ba Sọc Wika</a></li>
              <li><a href="cartegory.php?brand_id=13">Giày Ba Sọc 1 Màu</a></li>
            </ul>
        </li>

        <li><a href="#">Giày BaTa</a> 
         <ul class="sub-menu">
              <li><a href="cartegory.php?brand_id=16">Giày BaTa Warrior Hộp (Bata Siêu Phủi)</a></li>
              <li><a href="cartegory.php?brand_id=17">Giày Bata Warrior Đế Đen (Bata Tàu)</a></li>
              <li><a href="cartegory.php?brand_id=18">Giày Bata Mickey (Bata Cánh Bướm)</a></li>
              <li><a href="cartegory.php?brand_id=19">Giày Bata Ráp Đế</a></li>
            </ul>
        </li>

       <li><a href="#">Giày Adidas</a>
         <ul class="sub-menu">
              <li><a href="cartegory.php?brand_id=20">Giày Adidas F50</a></li>
              <li><a href="cartegory.php?brand_id=21">Giày Adidas Speedflow</a></li>
              <li><a href="cartegory.php?brand_id=22">Giày Adidas Copa</a></li>
              <li><a href="cartegory.php?brand_id=23">Giày Adidas Predator</a></li>
            </ul>
       </li>

        <li><a href="#">Găng Tay</a> 
           <ul class="sub-menu">
              <li><a href="cartegory.php?brand_id=24">Găng tay Zocker</a></li>
              <li><a href="cartegory.php?brand_id=25">Găng tay GKVN</a></li>
              <li><a href="cartegory.php?brand_id=26">Găng tay Nike</a></li>
              <li><a href="cartegory.php?brand_id=27">Găng tay Adidas</a></li>
            </ul>
        </li>

         <li><a href="#">Giày Nike</a> 
           <ul class="sub-menu">
              <li><a href="cartegory.php?brand_id=28">Giày Nike Tiempo</a></li>
              <li><a href="cartegory.php?brand_id=29">Giày Nike Phantom</a></li>
              <li><a href="cartegory.php?brand_id=30">Giày Nike Mercurial</a></li>
            </ul>
        </li>

          <li><a href="#">Giày Mizuno</a> 
           <ul class="sub-menu">
              <li><a href="cartegory.php?brand_id=31">Giày Mizuno Alpha</a></li>
              <li><a href="cartegory.php?brand_id=32">Giày Mizuno Neo 4</a></li>
              <li><a href="cartegory.php?brand_id=33">Giày Mizuno Morelia</a></li>
              <li><a href="cartegory.php?brand_id=34">Giày Mizuno Sala</a></li>
            </ul>
          </li>

           <li><a href="#">Thông Tin</a> 
            <ul class="sub-menu">
              <li><a href="contact.php">Liên Hệ</a></li>
              <li><a href="warranty.php">Chính Sách Bảo hành</a></li>
            </ul>
          </li>
        </div>
  <div class="others">
          <li>
    <form action="search.php" method="GET" id="searchForm" style="display: inline;">
        <input placeholder="Tìm Kiếm" type="text" name="keyword" id="searchInput">
        <button type="submit" style="background: none; border: none; cursor: pointer;">
            <i class="fas fa-search"></i>
        </button>
    </form>
</li>
            <li><a href="index.php"><i class="fa fa-paw"></i></a></li>
            <li><a href="login.php"><i class="fa fa-user"></i></a></li>
            <li><a href="cart.php"><i class="fa fa-shopping-bag"></i></a></li>
        </div>       
    </header>

<div class="payment-container">
    <!-- Progress Bar -->
    <div class="progress-bar">
        <div class="progress-step completed"><div class="step-icon"><i class="fas fa-shopping-cart"></i></div><span class="step-label">Giỏ hàng</span></div>
        <div class="progress-line completed"></div>
        <div class="progress-step completed"><div class="step-icon"><i class="fas fa-map-marker-alt"></i></div><span class="step-label">Địa chỉ giao hàng</span></div>
        <div class="progress-line active"></div>
        <div class="progress-step active"><div class="step-icon"><i class="fas fa-credit-card"></i></div><span class="step-label">Thanh toán</span></div>
    </div>

    <div class="payment-content">
        <!-- Left: Phương thức thanh toán -->
        <form class="payment-form" action="order_success.php" method="POST">
            <input type="hidden" name="fullName" value="<?php echo htmlspecialchars($fullName); ?>">
            <input type="hidden" name="phone" value="<?php echo htmlspecialchars($phone); ?>">
            <input type="hidden" name="province" value="<?php echo htmlspecialchars($province); ?>">
            <input type="hidden" name="district" value="<?php echo htmlspecialchars($district); ?>">
            <input type="hidden" name="address" value="<?php echo htmlspecialchars($address); ?>">

        <div class="payment-section">
    <h2>Phương thức giao hàng</h2>
    <label class="payment-option checked">
        <input type="radio" name="shippingMethod" value="express" checked>
        Giao hàng chuyển phát nhanh
    </label>
</div>

<div class="payment-section">
    <h2>Phương thức thanh toán</h2>
    <label class="payment-option checked">
        <input type="radio" name="paymentMethod" value="cod" checked>
        Thanh toán khi nhận hàng
    </label>
    <label class="payment-option">
        <input type="radio" name="paymentMethod" value="momo">
        Thanh toán qua Momo
    </label>
    <label class="payment-option">
        <input type="radio" name="paymentMethod" value="atm">
        Thẻ ATM nội địa
    </label>
    <label class="payment-option">
        <input type="radio" name="paymentMethod" value="creditcard">
        Thẻ tín dụng
    </label>
</div>


            <div class="form-actions">
                <a href="delivery.php" class="btn-back"><i class="fas fa-arrow-left"></i> Quay lại</a>
                <button type="submit" class="btn-submit">ĐẶT HÀNG <i class="fas fa-check"></i></button>
            </div>
        </form>

        <!-- Right: Tóm tắt đơn hàng -->
        <div class="order-summary">
            <h3>Đơn hàng của bạn</h3>
            <?php foreach ($cart_items as $item): ?>
                <div class="product-item">
                    <div class="product-info">
                        <div class="product-name"><?php echo htmlspecialchars($item['name']); ?></div>
                        <div class="product-details">Size: <?php echo htmlspecialchars($item['size']); ?></div>
                        <div class="product-price">
                            <span class="product-code">MSP: <?php echo $item['code']; ?></span>
                            <span class="original-price"><?php echo number_format($item['price']); ?>₫</span>
                        </div>
                    </div>
                    <div class="product-discount">
                        <?php if ($item['discount'] > 0): ?>
                            <span class="discount-badge">- <?php echo $item['discount']; ?>%</span>
                        <?php endif; ?>
                        <span class="quantity">x <?php echo $item['quantity']; ?></span>
                    </div>
                    <div class="product-total"><?php echo number_format($item['item_total']); ?>₫</div>
                </div>
            <?php endforeach; ?>

            <div class="summary-divider"></div>
            <div class="summary-row"><span>Tổng tiền hàng</span><span class="amount"><?php echo number_format($final_price); ?>₫</span></div>
            <div class="summary-row shipping"><span>Phí vận chuyển</span><span class="amount"><?php echo number_format($shipping_fee); ?>₫</span></div>
            <div class="summary-divider"></div>
            <div class="summary-row total"><span>Tiền thanh toán</span><span class="amount"><?php echo number_format($grand_total); ?>₫</span></div>
        </div>
    </div>
</div>

<!-- Footer -->
    <footer>
        <div class="footer-container">
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

            <div class="footer-section">
                <h3>Liên Hệ</h3>
                <div class="contact-info">
                    <p><i class="fas fa-map-marker-alt"></i> 639 Kim Ngưu, P. Vĩnh Tuy, Q. Hai Bà Trưng, Hà Nội</p>
                    <p><i class="fas fa-phone"></i> Call/Zalo: 01D803767</p>
                    <p><i class="fas fa-comment-dots"></i> Call/Zalo HKD BECK</p>
                    <p><i class="fas fa-comment"></i> Call/Zalo phòng TM</p>
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

<script>
document.addEventListener("DOMContentLoaded", function () {
    const shippingFee = 38000;

    // Tính tổng tiền hàng từ các phần tử đã render
    let subtotal = 0;
    document.querySelectorAll(".product-total").forEach(el => {
        const value = parseInt(el.textContent.replace(/[^\d]/g, ""));
        subtotal += isNaN(value) ? 0 : value;
    });

    // Hiển thị các giá trị
    document.getElementById("subtotalAmount").textContent = subtotal.toLocaleString() + "₫";
    document.getElementById("tempTotal").textContent = subtotal.toLocaleString() + "₫";
    document.getElementById("shippingFee").textContent = shippingFee.toLocaleString() + "₫";
    document.getElementById("finalTotal").textContent = (subtotal + shippingFee).toLocaleString() + "₫";

    // Xử lý chọn phương thức thanh toán
    document.querySelectorAll('input[name="paymentMethod"]').forEach(input => {
        input.addEventListener("change", function () {
            document.querySelectorAll(".payment-option").forEach(opt => opt.classList.remove("checked"));
            this.closest(".payment-option").classList.add("checked");
        });
    });

    // Xử lý chọn phương thức giao hàng
    document.querySelectorAll('input[name="shippingMethod"]').forEach(input => {
        input.addEventListener("change", function () {
            document.querySelectorAll(".shipping-options .payment-option").forEach(opt => opt.classList.remove("checked"));
            this.closest(".payment-option").classList.add("checked");
        });
    });

    // Áp dụng mã giảm giá (demo)
    document.querySelector(".btn-apply-coupon")?.addEventListener("click", function () {
        const code = document.getElementById("couponCode").value.trim();
        if (code === "SALE10") {
            const discount = Math.round(subtotal * 0.1);
            subtotal -= discount;
            document.getElementById("subtotalAmount").textContent = subtotal.toLocaleString() + "₫";
            document.getElementById("finalTotal").textContent = (subtotal + shippingFee).toLocaleString() + "₫";
            alert("Áp dụng mã giảm giá thành công: -10%");
        } else {
            alert("Mã không hợp lệ hoặc đã hết hạn.");
        }
    });
});
</script>

</body>
</html>
