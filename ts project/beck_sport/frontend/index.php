<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beck Sport - Cửa hàng giày thể thao</title>
    <script src="https://kit.fontawesome.com/1147679ae7.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/style.css">
    
</head>
<body>
    <header>
   <?php
include_once '../admin/session.php'; // hoặc đúng đường dẫn
Session::init();
?>

<div class="top-menu">
    <?php if (Session::get('login')): ?>
        👋 Xin chào, <strong><?php echo Session::get('username'); ?></strong> |
        <a href="log_out.php">Đăng xuất</a>
    <?php else: ?>
        <a href="login.php">Đăng nhập</a> |
        <a href="register.php">Đăng ký</a>
    <?php endif; ?>
</div>



      <div class="logo">
        <img src="../images/logo.png" alt="Beck Sport Logo">
      </div>
      <div class="menu">
          <li><a href="products.php">Tất cả sản phẩm</a></li> <!-- THÊM DÒNG NÀY -->
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
        <form action="search.php" method="GET" id="searchForm">
            <input placeholder="Tìm Kiếm" type="text" name="keyword" id="searchInput">
            <button type="submit">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </li>
    <li><a href="index.php"><i class="fa fa-paw"></i></a></li>
    <li><a href="login.php"><i class="fa fa-user"></i></a></li>
    <li><a href="cart.php"><i class="fa fa-shopping-bag"></i></a></li>
</div>   
    </header>

    <!-- Slider Section -->
    <section class="Slider">
      <div class="aspect-ratio-169">
        <img src="../images/slider1.png" alt="Slider 1">
        <img src="../images/slider2.png" alt="Slider 2">
        <img src="../images/slider3.png" alt="Slider 3">
        <img src="../images/slider4.png" alt="Slider 4">
        <img src="../images/slider5.png" alt="Slider 5">
        <img src="../images/slider6.png" alt="Slider 6">
      </div>
      <div class="dot-container">
        <div class="dot active"></div>
        <div class="dot"></div>
        <div class="dot"></div>
        <div class="dot"></div>
        <div class="dot"></div>
        <div class="dot"></div>
      </div>
    </section>

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

  // Slider
  const imgPosition = document.querySelectorAll(".aspect-ratio-169 img");
  const imgContainer = document.querySelector(".aspect-ratio-169");
  const dotItem = document.querySelectorAll(".dot");
  let imgNumber = imgPosition.length;
  let index = 0;

  imgPosition.forEach(function(image, idx){
    image.style.left = idx * 100 + "%";
    dotItem[idx].addEventListener("click", function(){
      slider(idx);
    });
  });

  function imgSlide(){
    index++;
    if(index >= imgNumber) {
      index = 0;
    }
    slider(index);
  }

  function slider(idx){
    imgContainer.style.left = "-" + idx * 100 + "%";
    const dotActive = document.querySelector('.active');
    dotActive.classList.remove("active");
    dotItem[idx].classList.add("active");
    index = idx;
  }
  
  setInterval(imgSlide, 5000);
</script>
</html>