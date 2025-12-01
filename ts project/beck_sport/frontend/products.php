<?php
session_start();

// Kết nối database
include_once __DIR__ . '/../admin/class/product_class.php';
$product_obj = new product();

// Lấy product_id từ URL
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Lấy chi tiết sản phẩm
$product_detail = $product_obj->get_product_detail($product_id);

// Nếu không tìm thấy sản phẩm
if (!$product_detail) {
    header('Location: cartegory.php');
    exit;
}

// Lấy ảnh mô tả sản phẩm
$product_images = $product_obj->get_product_images($product_id);

// Tính giá
$original_price = isset($product_detail['product_price_old']) 
    ? floatval(str_replace('.', '', $product_detail['product_price_old'])) 
    : 0;

$price = isset($product_detail['product_price_new']) 
    ? floatval(str_replace('.', '', $product_detail['product_price_new'])) 
    : 0;

$discount = ($price > 0 && $original_price > 0)
    ? round((($original_price - $price) / $original_price) * 100)
    : 0;


?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $product_detail['product_name']; ?> - Beck Sport</title>
    <script src="https://kit.fontawesome.com/1147679ae7.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <!-- Header -->
    <header>
      <div class="logo">
        <a href="index.html"><img src="../images/logo.png" alt="Beck Sport"></a>
      </div>
      <div class="menu">
        <li><a href="#">Giày Ba Sọc</a> 
            <ul class="sub-menu">
              <li><a href="cartegory.php?brand_id=1">Ba Sọc Beck Truyền Thống</a></li>
              <li><a href="cartegory.php?brand_id=2">Ba Sọc ACE 16</a></li>
              <li><a href="cartegory.php?brand_id=3">Giày Ba Sọc Toni</a></li>
            </ul>
        </li>

        <li><a href="#">Giày BaTa</a> 
         <ul class="sub-menu">
              <li><a href="cartegory.php?brand_id=7">Giày BaTa Warrior Hộp</a></li>
              <li><a href="cartegory.php?brand_id=8">Giày Bata Warrior Đế Đen</a></li>
            </ul>
        </li>

       <li><a href="#">Giày Adidas</a>
         <ul class="sub-menu">
              <li><a href="cartegory.php?brand_id=11">Giày Adidas F50</a></li>
              <li><a href="cartegory.php?brand_id=13">Giày Adidas Copa</a></li>
            </ul>
       </li>

        <li><a href="#">Giày Nike</a> 
           <ul class="sub-menu">
              <li><a href="cartegory.php?brand_id=19">Giày Nike Tiempo</a></li>
              <li><a href="cartegory.php?brand_id=21">Giày Nike Mercurial</a></li>
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

    <!-- Product Detail Section -->
    <section class="product">
        <div class="container">
            <!-- Breadcrumb -->
            <div class="product-top">
                <p><a href="index.php">Trang chủ</a></p>
                <span>›</span>
                <p><a href="cartegory.php?brand_id=<?php echo $product_detail['brand_id']; ?>">
                    <?php echo $product_detail['brand_name']; ?>
                </a></p>
                <span>›</span>
                <p><?php echo $product_detail['product_name']; ?></p>
            </div>

            <!-- Product Content -->
            <div class="product-content">
                <!-- Left: Product Images -->
                <div class="product-content-left">
                    <div class="product-content-left-big-img">
                        <img src="../admin/uploads/<?php echo $product_detail['product_img']; ?>" 
                             alt="<?php echo $product_detail['product_name']; ?>" 
                             id="mainImage">
                    </div>
                    
                    <div class="product-content-left-small-img">
                        <!-- Ảnh chính -->
                        <img src="../admin/uploads/<?php echo $product_detail['product_img']; ?>" 
                             alt="Main" 
                             onclick="changeMainImage(this.src)"
                             class="active">
                        
                        <!-- Ảnh mô tả -->
                        <?php 
                        if ($product_images && mysqli_num_rows($product_images) > 0) {
                            $count = 0;
                            while ($img = mysqli_fetch_assoc($product_images)) {
                                if ($count < 3) { // Hiển thị tối đa 3 ảnh mô tả
                        ?>
                        <img src="../admin/uploads/<?php echo $img['product_img_desc']; ?>" 
                             alt="Image <?php echo $count + 2; ?>"
                             onclick="changeMainImage(this.src)">
                        <?php 
                                $count++;
                                }
                            }
                        }
                        ?>
                    </div>
                </div>

                <!-- Right: Product Info -->
                <div class="product-content-right">
                    <h1><?php echo $product_detail['product_name']; ?></h1>
                    <p class="product-code">MSP: <?php echo $product_detail['product_id']; ?></p>
                    
                    <div style="margin-bottom: 20px;">
                        <?php if ($discount > 0) { ?>
                        <p style="text-decoration: line-through; color: #999; font-size: 18px; margin-bottom: 5px;">
                            <?php echo number_format($original_price); ?>đ
                        </p>
                        <p class="product-price">
                            <?php echo number_format($price); ?><sup>đ</sup>
                            <span style="background: #e74c3c; color: white; padding: 5px 10px; border-radius: 3px; font-size: 14px; margin-left: 10px;">
                                -<?php echo $discount; ?>%
                            </span>
                        </p>
                        <?php } else { ?>
                        <p class="product-price"><?php echo number_format($price); ?><sup>đ</sup></p>
                        <?php } ?>
                    </div>

                   

                    <!-- Product Size -->
                    <div class="product-size">
                        <h4>Kích thước</h4>
                        <div class="size-options">
                            <div class="size-option" data-size="39">39</div>
                            <div class="size-option" data-size="40">40</div>
                            <div class="size-option" data-size="41">41</div>
                            <div class="size-option" data-size="42">42</div>
                            <div class="size-option" data-size="43">43</div>
                            <div class="size-option" data-size="44">44</div>
                        </div>
                    </div>

                    <!-- Quantity -->
                    <div class="product-quantity">
                        <h4>Số lượng</h4>
                        <div class="quantity-selector">
                            <div class="quantity-input">
                                <button onclick="changeQuantity(-1)">-</button>
                                <input type="number" id="quantity" value="1" min="1" readonly>
                                <button onclick="changeQuantity(1)">+</button>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="product-actions">
                        <button class="btn-add-cart" onclick="addToCart()">
                            <i class="fas fa-shopping-cart"></i>
                            THÊM VÀO GIỎ HÀNG
                        </button>
                        <button class="btn-find-store">
                            <i class="fas fa-store"></i>
                            TÌM CỬA HÀNG
                        </button>
                    </div>
                    

                    <!-- Contact Methods -->
                    <div class="product-contact">
                        <div class="contact-item">
                            <i class="fab fa-facebook-messenger"></i>
                            Chat Messenger
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-phone"></i>
                            01D803767
                        </div>
                        <div class="contact-item">
                            <i class="fab fa-tiktok"></i>
                            TikTok
                        </div>
                    </div>

                    <!-- Product Description -->
                    <div style="margin-top: 30px; padding-top: 30px; border-top: 2px solid #e5e5e5;">
                        <h4 style="font-size: 18px; margin-bottom: 15px; color: #000;">Mô tả sản phẩm</h4>
                        <div style="line-height: 1.8; color: #666;">
                            <?php echo nl2br($product_detail['product_desc']); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include_once 'review_section.php'; ?>

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

    // Change main image
    function changeMainImage(src) {
        document.getElementById('mainImage').src = src;
        
        // Update active state
        document.querySelectorAll('.product-content-left-small-img img').forEach(img => {
            img.classList.remove('active');
        });
        event.target.classList.add('active');
    }

    // Color selection
    document.querySelectorAll('.color-option').forEach(option => {
        option.addEventListener('click', function() {
            document.querySelectorAll('.color-option').forEach(o => o.classList.remove('active'));
            this.classList.add('active');
        });
    });

    // Size selection
    document.querySelectorAll('.size-option').forEach(option => {
        option.addEventListener('click', function() {
            document.querySelectorAll('.size-option').forEach(o => o.classList.remove('active'));
            this.classList.add('active');
        });
    });

    // Change quantity
    function changeQuantity(change) {
        const input = document.getElementById('quantity');
        let value = parseInt(input.value) + change;
        if (value < 1) value = 1;
        input.value = value;
    }

    // Add to cart
    // Add to cart - PHIÊN BẢN SỬA LỖI
function addToCart() {
    const quantity = document.getElementById('quantity').value;
    const productId = <?php echo $product_id; ?>;
    
    // Kiểm tra đã chọn size chưa
    const selectedSize = document.querySelector('.size-option.active');
    if (!selectedSize) {
        alert('Vui lòng chọn kích thước!');
        return;
    }
    
    // Lấy giá trị size từ data-size attribute
    const size = selectedSize.getAttribute('data-size');
    
    // Debug - xem dữ liệu trước khi gửi
    console.log('Product ID:', productId);
    console.log('Quantity:', quantity);
    console.log('Size:', size);
    
    // Gửi AJAX - QUAN TRỌNG: phải gửi cả size
    fetch('cart_handler.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'action=add&product_id=' + productId + '&quantity=' + quantity + '&size=' + size + '&color='
    })
    .then(response => {
        console.log('Response status:', response.status);
        console.log('Response headers:', response.headers.get('content-type'));
        return response.text(); // Lấy text trước để debug
    })
    .then(text => {
        console.log('Response text:', text); // Xem response thực tế
        try {
            const data = JSON.parse(text);
            console.log('Parsed data:', data);
            
            if(data.success) {
                alert('✅ Đã thêm sản phẩm vào giỏ hàng!');
                // Có thể chuyển sang trang giỏ hàng hoặc reload
                window.location.href = 'cart.php';
            } else {
                alert('❌ ' + (data.message || 'Không thể thêm vào giỏ hàng!'));
            }
        } catch(e) {
            console.error('JSON Parse Error:', e);
            console.error('Response was:', text);
            alert('⚠️ Lỗi xử lý phản hồi từ server!');
        }
    })
    .catch(error => {
        console.error('Fetch Error:', error);
        alert('⚠️ Không thể kết nối tới server! ' + error.message);
    });
    
}






    </script>
</body>
</html>




























































     