<?php
session_start(); // Thêm session_start để hiển thị số lượng giỏ hàng

// Kết nối database và lấy dữ liệu
include_once __DIR__ . '/../admin/class/product_class.php';
$product = new product();

// Lấy brand_id từ URL
$brand_id = isset($_GET['brand_id']) ? intval($_GET['brand_id']) : 0;

// Lấy page hiện tại (cho phân trang)
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$products_per_page = 12;
$offset = ($page - 1) * $products_per_page;

// NẾU KHÔNG CÓ brand_id → Lấy TẤT CẢ sản phẩm
if ($brand_id == 0) {
    $products = $product->show_product();
    $brand_name = 'Tất cả sản phẩm';
} else {
    // Có brand_id → Lấy theo brand
    $brand_info = $product->get_brand($brand_id);
    if($brand_info) {
        $brand_data = $brand_info->fetch_assoc();
        $brand_name = $brand_data['brand_name'];
    } else {
        $brand_name = 'Danh mục không tồn tại';
    }
    $products = $product->get_product_by_brand($brand_id);
}

// Đếm tổng số sản phẩm để tính số trang
$total_products = $products ? mysqli_num_rows($products) : 0;
$total_pages = ceil($total_products / $products_per_page);

// Lấy tất cả danh mục và loại sản phẩm cho menu
$categories = $product->show_cartegory();
$brands = $product->show_brand();

// Đếm số sản phẩm trong giỏ hàng
$cart_count = 0;
if(isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    $cart_count = count($_SESSION['cart']);
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($brand_name); ?> - Beck Sport</title>
    <script src="https://kit.fontawesome.com/1147679ae7.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        /* Style cho badge số lượng giỏ hàng */
        .cart-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #e74c3c;
            color: white;
            font-size: 11px;
            font-weight: bold;
            padding: 2px 6px;
            border-radius: 50%;
            min-width: 18px;
            text-align: center;
        }
        
        .others li {
            position: relative;
        }
        
        /* Highlight menu item hiện tại */
        .cartegory-left-li ul li a.active {
            color: #4CAF50;
            font-weight: bold;
            background: #f0f0f0;
            padding-left: 20px;
        }
        
        /* Style cho phân trang */
        .page-link {
            display: inline-block;
            padding: 8px 12px;
            margin: 0 4px;
            border: 1px solid #ddd;
            text-decoration: none;
            color: #333;
            border-radius: 4px;
            transition: all 0.3s;
        }
        
        .page-link:hover {
            background: #4CAF50;
            color: white;
            border-color: #4CAF50;
        }
        
        .page-link.active {
            background: #4CAF50;
            color: white;
            border-color: #4CAF50;
            pointer-events: none;
        }
        
        .page-link.disabled {
            opacity: 0.5;
            pointer-events: none;
        }
    </style>
</head>
<body>
    <header>
      <div class="logo">
        <a href="index.php"><img src="../images/logo.png" alt="Beck Sport"></a>
      </div>
      <div class="menu">
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
              <li><a href="cartegory.php?brand_id=16">Giày BaTa Warrior Hộp</a></li>
              <li><a href="cartegory.php?brand_id=17">Giày Bata Warrior Đế Đen</a></li>
              <li><a href="cartegory.php?brand_id=18">Giày Bata Mickey</a></li>
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

<!-- ---------------------cartegory----------------------- -->
<section class="cartegory">
    <div class="container">
<div class="cartegory-top">
    <p><a href="index.php" style="color: inherit;">Trang chủ</a></p> 
    <span>&#10230;</span>
    <p><a href="cartegory.php" style="color: inherit;">Tất cả sản phẩm</a></p>
    <span>&#10230;</span>  
    <p><?php echo $brand_name; ?></p>
</div>

    </div>
    
    <div class="container">
        <div class="row">
            <!-- Menu bên trái -->
            <div class="cartegory-left">
                <ul>
                    <?php
                    // Nhóm brands theo cartegory
                    $grouped_brands = [];
                    
                    if($brands && mysqli_num_rows($brands) > 0) {
                        mysqli_data_seek($brands, 0);
                        while($brand_row = mysqli_fetch_assoc($brands)) {
                            $cat_id = $brand_row['cartegory_id'];
                            if(!isset($grouped_brands[$cat_id])) {
                                $grouped_brands[$cat_id] = [];
                            }
                            $grouped_brands[$cat_id][] = $brand_row;
                        }
                    }
                    
                    // Hiển thị menu theo cartegory
                    if($categories && mysqli_num_rows($categories) > 0) {
                        mysqli_data_seek($categories, 0);
                        while($cat_row = mysqli_fetch_assoc($categories)) {
                            $cat_id = $cat_row['cartegory_id'];
                    ?>
                    <li class="cartegory-left-li">
                        <a href="#"><?php echo htmlspecialchars($cat_row['cartegory_name']); ?></a>
                        <?php if(isset($grouped_brands[$cat_id])) { ?>
                        <ul>
                            <?php foreach($grouped_brands[$cat_id] as $brand_item) { 
                                $is_active = ($brand_item['brand_id'] == $brand_id) ? 'active' : '';
                            ?>
                            <li>
                                <a href="cartegory.php?brand_id=<?php echo $brand_item['brand_id']; ?>" 
                                   class="<?php echo $is_active; ?>">
                                    <?php echo htmlspecialchars($brand_item['brand_name']); ?>
                                </a>
                            </li>
                            <?php } ?>
                        </ul>
                        <?php } ?>
                    </li>
                    <?php 
                        }
                    }
                    ?>
                </ul>
            </div>

            <!-- Phần hiển thị sản phẩm bên phải -->
            <div class="cartegory-right">
                <div class="cartegory-right-top row">
                    <div class="cartegory-right-top-item">
                        <p><?php echo strtoupper(htmlspecialchars($brand_name)); ?></p>
                    </div>
                    <div class="cartegory-right-top-item">
                        <span style="color: #666; font-size: 14px;">
                            Tìm thấy <strong><?php echo $total_products; ?></strong> sản phẩm
                        </span>
                    </div>
                </div>

                <div class="cartegory-right-content">
                    <?php
                    if ($products && mysqli_num_rows($products) > 0) {
                        // Reset pointer và skip đến offset
                        mysqli_data_seek($products, 0);
                        $current = 0;
                        $displayed = 0;
                        
                        while ($row = mysqli_fetch_assoc($products)) {
                            // Skip sản phẩm cho đến offset
                            if($current < $offset) {
                                $current++;
                                continue;
                            }
                            
                            // Dừng khi đã hiển thị đủ số lượng
                            if($displayed >= $products_per_page) {
                                break;
                            }
                            
                            // Tính giá hiển thị
                            $price_raw = $row['product_price_new'] ? $row['product_price_new'] : $row['product_price'];
                            $price_clean = preg_replace('/[^\d]/', '', $price_raw);
                            $price = (float)$price_clean;
                            
                            // Tính giảm giá nếu có
                            $discount = 0;
                            if($row['product_price_new'] && $row['product_price']) {
                                $old_price = (float)preg_replace('/[^\d]/', '', $row['product_price']);
                                if($old_price > $price) {
                                    $discount = round((($old_price - $price) / $old_price) * 100);
                                }
                            }
                    ?>
                    <!-- Product Item -->
                    <a href="products.php?id=<?php echo $row['product_id']; ?>" class="cartegory-right-content-item">
                        <div class="brand-logo">TS.</div>
                        <?php if($discount > 0) { ?>
                        <span class="badge">-<?php echo $discount; ?>%</span>
                        <?php } else { ?>
                        <span class="badge">Pro</span>
                        <?php } ?>
                        <img src="../admin/uploads/<?php echo htmlspecialchars($row['product_img']); ?>" 
                             alt="<?php echo htmlspecialchars($row['product_name']); ?>" 
                             class="product-image">
                        <p class="product-code">Mã SP: <?php echo $row['product_id']; ?></p>
                        <p class="product-price"><?php echo number_format($price); ?><sup>đ</sup></p>
                        <p class="product-stock">HÀNG CÓ SẴN</p>
                        <h1><?php echo htmlspecialchars($row['product_name']); ?></h1>
                    </a>
                    <?php
                            $displayed++;
                            $current++;
                        }
                    } else {
                        echo '<div style="grid-column: 1/-1; text-align: center; padding: 60px 20px;">';
                        echo '<i class="fas fa-box-open" style="font-size: 80px; color: #ccc; margin-bottom: 20px; display: block;"></i>';
                        echo '<p style="font-size: 18px; color: #666;">Hiện chưa có sản phẩm nào trong danh mục này.</p>';
                        echo '<a href="index.php" style="display: inline-block; margin-top: 20px; padding: 12px 30px; background: #4CAF50; color: white; text-decoration: none; border-radius: 5px;">Quay về trang chủ</a>';
                        echo '</div>';
                    }
                    ?>
                </div>

                <?php if ($total_products > $products_per_page) { ?>
                <div class="cartegory-right-bottom">
                    <div class="cartegory-right-bottom-items">
                        <p>Hiển thị <?php echo min($offset + 1, $total_products); ?>-<?php echo min($offset + $products_per_page, $total_products); ?> trong tổng số <?php echo $total_products; ?> sản phẩm</p>
                    </div>
                    <div class="cartegory-right-bottom-items">
                        <p>
                            <?php if($page > 1) { ?>
                            <a href="?brand_id=<?php echo $brand_id; ?>&page=<?php echo $page - 1; ?>" class="page-link">&#171; Trước</a>
                            <?php } else { ?>
                            <span class="page-link disabled">&#171; Trước</span>
                            <?php } ?>
                            
                            <?php
                            // Hiển thị các số trang
                            $start_page = max(1, $page - 2);
                            $end_page = min($total_pages, $page + 2);
                            
                            for($i = $start_page; $i <= $end_page; $i++) {
                                $active_class = ($i == $page) ? 'active' : '';
                            ?>
                            <a href="?brand_id=<?php echo $brand_id; ?>&page=<?php echo $i; ?>" 
                               class="page-link <?php echo $active_class; ?>"><?php echo $i; ?></a>
                            <?php } ?>
                            
                            <?php if($page < $total_pages) { ?>
                            <a href="?brand_id=<?php echo $brand_id; ?>&page=<?php echo $page + 1; ?>" class="page-link">Sau &#187;</a>
                            <?php } else { ?>
                            <span class="page-link disabled">Sau &#187;</span>
                            <?php } ?>
                        </p>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>

<!-- --------------------footer----------------------- -->
<footer>
    <div class="footer-container">
        <div class="footer-section">
            <h3>Về Chúng Tôi</h3>
            <div class="logo-box"><h2>beck.</h2></div>
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
            </ul>
        </div>
        
        <div class="footer-section">
            <h3>Liên Hệ</h3>
            <div class="contact-info">
                <p><i class="fas fa-map-marker-alt"></i> 639 Kim Ngưu, Hai Bà Trưng, Hà Nội</p>
                <p><i class="fas fa-phone"></i> Call/Zalo: 01D803767</p>
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

  // Toggle menu con bên trái
  const menuItems = document.querySelectorAll('.cartegory-left-li > a');
  menuItems.forEach(item => {
    item.addEventListener('click', function(e) {
      e.preventDefault();
      const parent = this.parentElement;
      parent.classList.toggle('active');
      
      // Đóng các menu khác
      menuItems.forEach(otherItem => {
        if(otherItem !== item) {
          otherItem.parentElement.classList.remove('active');
        }
      });
    });
  });
  
  // Auto mở menu chứa brand đang active
  window.addEventListener('DOMContentLoaded', function() {
    const activeLink = document.querySelector('.cartegory-left-li ul a.active');
    if(activeLink) {
      activeLink.closest('.cartegory-left-li').classList.add('active');
    }
  });
</script>
</body>
</html>