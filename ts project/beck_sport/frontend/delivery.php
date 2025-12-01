<?php
session_start();
include_once __DIR__ . '/../admin/class/product_class.php';
$product = new product();

// Tính toán giỏ hàng
$total_quantity = 0;
$total_price = 0;
$final_price = 0;
$cart_items = array();

if (!empty($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        if (!is_array($item) || !isset($item['product_id']) || !isset($item['quantity'])) continue;

        $product_id = $item['product_id'];
        $quantity = $item['quantity'];
        $size = isset($item['size']) ? $item['size'] : '';

        $product_detail = $product->get_product_detail($product_id);
        if ($product_detail && is_array($product_detail)) {
            $price = isset($product_detail['product_price_new']) ? floatval(str_replace('.', '', $product_detail['product_price_new'])) : 0;
            $original_price = isset($product_detail['product_price']) ? floatval(str_replace('.', '', $product_detail['product_price'])) : 0;
            $discount = ($original_price > $price) ? round((($original_price - $price) / $original_price) * 100) : 0;
            $item_total = $price * $quantity;

            $total_quantity += $quantity;
            $total_price += $original_price * $quantity;
            $final_price += $item_total;

            $cart_items[] = array(
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
            );
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Địa chỉ giao hàng - Beck Sport</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/delivery.css">
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

<div class="delivery-container">
    <!-- Progress Bar -->
    <div class="progress-bar">
        <div class="progress-step completed"><div class="step-icon"><i class="fas fa-shopping-cart"></i></div><span class="step-label">Giỏ hàng</span></div>
        <div class="progress-line active"></div>
        <div class="progress-step active"><div class="step-icon"><i class="fas fa-map-marker-alt"></i></div><span class="step-label">Địa chỉ giao hàng</span></div>
        <div class="progress-line"></div>
        <div class="progress-step"><div class="step-icon"><i class="fas fa-credit-card"></i></div><span class="step-label">Thanh toán</span></div>
    </div>

    <div class="delivery-content">
        <!-- Form nhập địa chỉ -->
        <form class="delivery-form" action="payment.php" method="POST">
            <h2>Vui lòng chọn địa chỉ giao hàng</h2>

            <div class="form-group-row">
                <div class="form-group">
                    <label for="fullName">Họ tên <span class="required">*</span></label>
                    <input type="text" id="fullName" name="fullName" required>
                </div>
                <div class="form-group">
                    <label for="phone">Điện thoại <span class="required">*</span></label>
                    <input type="tel" id="phone" name="phone" required>
                </div>
            </div>

            <div class="form-group-row">
                <div class="form-group">
                    <label for="province">Tỉnh/TP <span class="required">*</span></label>
                    <select id="province" name="province" required>
                        <option value="">Chọn Tỉnh/TP</option>
                        <option value="hanoi">Hà Nội</option>
                        <option value="hcm">TP. Hồ Chí Minh</option>
                        <option value="danang">Đà Nẵng</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="district">Quận/Huyện <span class="required">*</span></label>
                    <select id="district" name="district" required>
                        <option value="">Chọn Quận/Huyện</option>
                        <option value="caugiay">Cầu Giấy</option>
                        <option value="hoangmai">Hoàng Mai</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="address">Địa chỉ cụ thể <span class="required">*</span></label>
                <input type="text" id="address" name="address" required>
            </div>

            <div class="form-actions">
                <a href="cart.php" class="btn-back"><i class="fas fa-arrow-left"></i> Quay lại giỏ hàng</a>
                <button type="submit" class="btn-submit">TIẾP TỤC THANH TOÁN <i class="fas fa-arrow-right"></i></button>
            </div>
        </form>

        <!-- Tóm tắt đơn hàng -->
        <div class="order-summary">
            <h3>Đơn hàng của bạn</h3>
            <?php foreach ($cart_items as $item): ?>
                <div class="product-item">
                    <div class="product-info">
                        <div class="product-name"><?php echo htmlspecialchars($item['name']); ?></div>
                        <div class="product-details"><?php echo htmlspecialchars($item['size']); ?> / -</div>
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
            <div class="summary-row"><span>Tổng tiền hàng</span><span class="amount"><?php echo number_format($total_price); ?>₫</span></div>
            <div class="summary-row discount"><span>Giảm giá</span><span class="amount">- <?php echo number_format($total_price - $final_price); ?>₫</span></div>
            <div class="summary-divider"></div>
            <div class="summary-row total"><span>Tạm tính</span><span class="amount"><?php echo number_format($final_price); ?>₫</span></div>
            <div class="shipping-note"><i class="fas fa-info-circle"></i> Phí vận chuyển sẽ được tính ở bước thanh toán</div>
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
const districts = {
  hanoi: ["Cầu Giấy", "Hoàng Mai", "Đống Đa", "Hai Bà Trưng"],
  hcm: ["Quận 1", "Quận 3", "Tân Bình", "Bình Thạnh"],
  danang: ["Hải Châu", "Thanh Khê", "Ngũ Hành Sơn", "Liên Chiểu", "Hòa Vang"]
};

document.getElementById("province").addEventListener("change", function () {
  const selected = this.value;
  const districtSelect = document.getElementById("district");
  districtSelect.innerHTML = '<option value="">Chọn Quận/Huyện</option>';

  if (districts[selected]) {
    districts[selected].forEach(function (d) {
      const opt = document.createElement("option");
      opt.value = d.toLowerCase().replace(/\s/g, '');
      opt.textContent = d;
      districtSelect.appendChild(opt);
    });
  }
});
</script>

</body>
</html>
