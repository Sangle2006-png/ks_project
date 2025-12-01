<?php
session_start();

// Kết nối database
include_once __DIR__ . '/../admin/class/product_class.php';
$product = new product();

// Khởi tạo giỏ hàng nếu chưa có
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Tính tổng tiền từ database thực
$total_quantity = 0;
$total_price = 0;
$final_price = 0;
$cart_items = array();

if (!empty($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        // Kiểm tra xem $item có phải là mảng không
        if (!is_array($item)) {
            continue; // Bỏ qua nếu không phải mảng
        }

        // Kiểm tra các key có tồn tại không
        if (!isset($item['product_id']) || !isset($item['quantity'])) {
            continue; // Bỏ qua nếu thiếu thông tin
        }

        $product_id = $item['product_id'];
        $quantity = $item['quantity'];
        $size = isset($item['size']) ? $item['size'] : '';

        $product_detail = $product->get_product_detail($product_id);
        
        if ($product_detail && is_array($product_detail)) {
            // Lấy giá sản phẩm
            $price = 0;
            if (isset($product_detail['product_price_new']) && !empty($product_detail['product_price_new'])) {
                $price = floatval(str_replace('.', '', $product_detail['product_price_new']));
            } elseif (isset($product_detail['product_price']) && !empty($product_detail['product_price'])) {
                $price = floatval(str_replace('.', '', $product_detail['product_price']));
            }

            $original_price = 0;
            if (isset($product_detail['product_price']) && !empty($product_detail['product_price'])) {
                $original_price = floatval(str_replace('.', '', $product_detail['product_price']));
            }

            // Tính giảm giá
            $discount = 0;
            if ($original_price > 0 && $price > 0 && $original_price > $price) {
                $discount = round((($original_price - $price) / $original_price) * 100);
            }

            $item_total = $price * $quantity;

            $total_quantity += $quantity;
            $total_price += $original_price * $quantity;
            $final_price += $item_total;

            $cart_items[] = array(
                'product_id' => $product_id,
                'name' => isset($product_detail['product_name']) ? $product_detail['product_name'] : 'Sản phẩm',
                'image' => isset($product_detail['product_img']) ? $product_detail['product_img'] : 'default.jpg',
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
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Giỏ hàng - Beck Sport</title>
  <script src="https://kit.fontawesome.com/1147679ae7.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="../css/style.css" />
</head>
<body>

  <header>
      <div class="logo">
        <a href="index.html"><img src="../images/logo.png" alt="Beck Sport"></a>
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

  <!-- Cart Section -->
  <section class="cart-section">
    <div class="cart-container">
      <!-- Cart Steps -->
      <div class="cart-steps">
        <div class="cart-step active"><div class="step-icon"><i class="fa fa-shopping-cart"></i></div><span class="step-text">Giỏ hàng</span></div>
        <div class="cart-step"><div class="step-icon"><i class="fa fa-truck"></i></div><span class="step-text">Địa chỉ giao hàng</span></div>
        <div class="cart-step"><div class="step-icon"><i class="fa fa-credit-card"></i></div><span class="step-text">Thanh toán</span></div>
      </div>

      <div class="cart-content">
        <!-- Left: Cart Items -->
        <div class="cart-items">
          <div class="cart-items-header">
            <div>SẢN PHẨM</div><div>MÀU</div><div>SIZE</div><div>SL</div><div>THÀNH TIỀN</div><div>XÓA</div>
          </div>
<?php if (!empty($cart_items)) {
            foreach ($cart_items as $item) {
          ?>
          <div class="cart-item" data-product-id="<?php echo $item['product_id']; ?>" data-size="<?php echo htmlspecialchars($item['size']); ?>">

            <div class="cart-product-info">
              <div class="cart-product-image">
                <img src="../admin/uploads/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
              </div>
              <div class="cart-product-details">
                <h3><?php echo htmlspecialchars($item['name']); ?></h3>
                <p class="cart-product-price">
                  <?php echo number_format($item['price']); ?>đ
                </p>
                <?php if ($item['discount'] > 0) { ?>
                <p class="cart-product-discount">- <?php echo $item['discount']; ?>%</p>
                <?php } ?>
                <p class="cart-product-meta">MSP: <?php echo htmlspecialchars($item['code']); ?></p>
              </div>
            </div>
            
            <div class="cart-color">
              <div class="cart-color-box" style="background-color: #ccc;"></div>
              <span>-</span>
            </div>
            
            <div class="cart-size"><?php echo htmlspecialchars($item['size']); ?></div>
            
            <div class="cart-quantity">
              <div class="cart-quantity-input">
                <button onclick="updateQuantity(<?php echo $item['product_id']; ?>, -1, '<?php echo htmlspecialchars($item['size']); ?>')">-</button>
                <input type="number" value="<?php echo $item['quantity']; ?>" min="1" readonly>
                <button onclick="updateQuantity(<?php echo $item['product_id']; ?>, 1, '<?php echo htmlspecialchars($item['size']); ?>')">+</button>
              </div>
            </div>
            
            <div class="cart-item-total"><?php echo number_format($item['item_total']); ?><sup>đ</sup></div>
            
            <div class="cart-remove">
              <button onclick="removeFromCart(<?php echo $item['product_id']; ?>, '<?php echo htmlspecialchars($item['size']); ?>')">
                <i class="fa fa-times"></i>
              </button>
            </div>
          </div>
          <?php }} else { ?>
          <div style="text-align:center; padding:40px; grid-column: 1/-1;">
            <i class="fa fa-box-open" style="font-size:60px; color:#ccc;"></i>
            <p style="margin: 20px 0;">Giỏ hàng của bạn đang trống.</p>
            <a href="products.php" class="btn-continue-shopping" style="display: inline-block; padding: 12px 30px; background: #4CAF50; color: white; text-decoration: none; border-radius: 5px;">Tiếp tục mua sắm</a>
          </div>
          <?php } ?>
        
        </div>

        <!-- Right: Cart Summary -->
        <div class="cart-summary">
          <h2>Tổng Tiền Giỏ Hàng</h2>
          <div class="cart-summary-row"><span class="cart-summary-label">Tổng sản phẩm</span><span class="cart-summary-value"><?php echo $total_quantity; ?></span></div>
          <div class="cart-summary-row"><span class="cart-summary-label">Tổng tiền hàng</span><span class="cart-summary-value"><?php echo number_format($total_price); ?><sup>đ</sup></span></div>
          <div class="cart-summary-row"><span class="cart-summary-label">Thành tiền</span><span class="cart-summary-value red"><?php echo number_format($final_price); ?><sup>đ</sup></span></div>
          <div class="cart-summary-divider"></div>
          <div class="cart-summary-total"><span class="cart-summary-label">Tạm tính</span><span class="cart-summary-value"><?php echo number_format($final_price); ?><sup>đ</sup></span></div>

          <?php if ($final_price > 0) {
            if ($final_price < 2000000) {
              $missing = 2000000 - $final_price;
          ?>
          <div class="cart-free-ship">
            Bạn sẽ được miễn phí ship khi đơn hàng của bạn có tổng giá trị trên <strong>2.000.000đ</strong><br><br>
            Mua thêm <strong style="color: #E60000;"><?php echo number_format($missing); ?>đ</strong> để được miễn phí SHIP
          </div>
          <?php } else { ?>
          <div class="cart-free-ship" style="background-color:#d4edda; color:#155724;">
            ✓ Đơn hàng của bạn đã đủ điều kiện miễn phí ship!
          </div>
          <?php }} ?>

          <div class="cart-actions">
            <button class="btn-checkout" onclick="window.location.href='delivery.php'">THANH TOÁN</button>
            <button class="btn-continue-shopping" onclick="window.location.href='products.php'">TIẾP TỤC MUA SẮM</button>
          </div>

          <div class="cart-account">
            <h4>Tài Khoản BECK</h4>
            <p>Hãy <a href="login.php">đăng nhập</a> tài khoản của bạn để tích điểm thành viên</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- --------------------footer----------------------- -->
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

<script>
// Sticky header
const header = document.querySelector("header");
window.addEventListener("scroll", function(){
    let x = window.pageYOffset;
    if(x > 0){
        header.classList.add("sticky");
    } else {
        header.classList.remove("sticky");
    }
});

// Update quantity
function updateQuantity(productId, change, size) {
    fetch('cart_handler.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'action=update&product_id=' + productId + '&change=' + change + '&size=' + size
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            location.reload();
        } else {
            alert('Có lỗi xảy ra!');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Không thể cập nhật số lượng!');
    });
}



// Remove from cart
function removeFromCart(productId, size) {
    if(confirm('Bạn có chắc muốn xóa sản phẩm này?')) {
        fetch('cart_handler.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'action=remove&product_id=' + productId + '&size=' + size
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                location.reload();
            } else {
                alert('Có lỗi xảy ra!');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Không thể xóa sản phẩm!');
        });
    }
}



</script>

</body>
</html>