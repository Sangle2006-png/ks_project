<?php
include_once '../admin/session.php';
include_once __DIR__ . '/../admin/class/product_class.php';

Session::init();

// Khởi tạo class Product
$product = new product();

// Lấy từ khóa tìm kiếm
$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';

// Tìm kiếm sản phẩm nếu có từ khóa
$search_results = null;
if (!empty($keyword)) {
    $search_results = $product->search_product($keyword);
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kết quả tìm kiếm - Beck Sport</title>
    <script src="https://kit.fontawesome.com/1147679ae7.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        /* Container chính */
        .search-container {
            max-width: 1400px;
            margin: 40px auto 60px;
            padding: 0 30px;
            min-height: 60vh;
        }

        /* Header tìm kiếm */
        .search-header {
            margin-bottom: 40px;
            padding: 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.2);
            position: relative;
            overflow: hidden;
        }

        .search-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: pulse 4s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .search-header h2 {
            color: white;
            margin-bottom: 12px;
            font-size: 28px;
            font-weight: 600;
            position: relative;
            z-index: 1;
            text-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .search-keyword {
            color: #FFD700;
            font-weight: 700;
            text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        .search-count {
            color: rgba(255,255,255,0.9);
            font-size: 15px;
            margin-top: 8px;
            position: relative;
            z-index: 1;
        }

        /* Grid sản phẩm */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 30px;
            margin-bottom: 50px;
        }

        /* Card sản phẩm */
        .product-item {
            background: white;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 6px rgba(0,0,0,0.07);
            border: 1px solid #f0f0f0;
            position: relative;
            overflow: hidden;
        }

        .product-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
            transition: left 0.5s;
        }

        .product-item:hover::before {
            left: 100%;
        }

        .product-item:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 24px rgba(0,0,0,0.15);
            border-color: #e74c3c;
        }

        .product-item a {
            text-decoration: none;
        }

        .product-item img {
            width: 100%;
            height: 240px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 18px;
            transition: transform 0.4s;
        }

        .product-item:hover img {
            transform: scale(1.05);
        }

        .product-item h3 {
            font-size: 17px;
            color: #2c3e50;
            margin-bottom: 12px;
            min-height: 45px;
            line-height: 1.4;
            font-weight: 600;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .product-price {
            color: #e74c3c;
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 18px;
            display: block;
        }

        .product-link {
            display: inline-block;
            padding: 12px 30px;
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            color: white;
            text-decoration: none;
            border-radius: 25px;
            font-weight: 600;
            font-size: 14px;
            letter-spacing: 0.5px;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(231, 76, 60, 0.3);
        }

        .product-link:hover {
            background: linear-gradient(135deg, #c0392b 0%, #e74c3c 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(231, 76, 60, 0.4);
        }

        /* Không có kết quả */
        .no-results {
            text-align: center;
            padding: 80px 40px;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            border-radius: 20px;
            margin: 40px 0;
        }

        .no-results i {
            font-size: 100px;
            color: #bdc3c7;
            margin-bottom: 30px;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }

        .no-results h3 {
            color: #34495e;
            margin-bottom: 15px;
            font-size: 26px;
            font-weight: 600;
        }

        .no-results p {
            color: #7f8c8d;
            margin: 12px 0;
            font-size: 16px;
            line-height: 1.6;
        }

        .back-link {
            display: inline-block;
            margin-top: 25px;
            padding: 14px 35px;
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            color: white;
            text-decoration: none;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
        }

        .back-link:hover {
            background: linear-gradient(135deg, #2980b9 0%, #3498db 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(52, 152, 219, 0.4);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .search-container {
                padding: 0 15px;
                margin: 20px auto 40px;
            }

            .search-header {
                padding: 20px;
                margin-bottom: 25px;
            }

            .search-header h2 {
                font-size: 22px;
            }

            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
                gap: 20px;
            }

            .product-item {
                padding: 15px;
            }

            .product-item img {
                height: 180px;
            }

            .no-results {
                padding: 50px 20px;
            }

            .no-results i {
                font-size: 70px;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
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
            <a href="index.php"><img src="../images/logo.png" alt="Beck Sport Logo"></a>
        </div>

        <div class="menu">
            <li><a href="products.php">TẤT CẢ SẢN PHẨM</a></li>
            <li><a href="#">Giày Ba Sọc</a> 
                <ul class="sub-menu">
                    <li><a href="cartegory.php?brand_id=1">Ba Sọc Beck Truyền Thống</a></li>
                    <li><a href="cartegory.php?brand_id=4">Ba Sọc ACE 16</a></li>
                    <li><a href="cartegory.php?brand_id=11">Giày Ba Sọc Toni</a></li>
                </ul>
            </li>
            <li><a href="#">Giày BaTa</a> 
                <ul class="sub-menu">
                    <li><a href="cartegory.php?brand_id=16">Giày BaTa Warrior Hộp</a></li>
                    <li><a href="cartegory.php?brand_id=17">Giày Bata Warrior Đế Đen</a></li>
                </ul>
            </li>
            <li><a href="#">Giày Adidas</a>
                <ul class="sub-menu">
                    <li><a href="cartegory.php?brand_id=20">Giày Adidas F50</a></li>
                    <li><a href="cartegory.php?brand_id=22">Giày Adidas Copa</a></li>
                </ul>
            </li>
            <li><a href="#">Giày Nike</a> 
                <ul class="sub-menu">
                    <li><a href="cartegory.php?brand_id=28">Giày Nike Tiempo</a></li>
                    <li><a href="cartegory.php?brand_id=30">Giày Nike Mercurial</a></li>
                </ul>
            </li>
            <li><a href="#">Giày Mizuno</a> 
                <ul class="sub-menu">
                    <li><a href="cartegory.php?brand_id=31">Giày Mizuno Alpha</a></li>
                    <li><a href="cartegory.php?brand_id=33">Giày Mizuno Morelia</a></li>
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
                    <input placeholder="Tìm Kiếm" type="text" name="keyword" id="searchInput" value="<?php echo htmlspecialchars($keyword); ?>">
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

    <!-- Kết quả tìm kiếm -->
    <div class="search-container">
        <?php if (!empty($keyword)): ?>
            <div class="search-header">
                <h2>Kết quả tìm kiếm cho: "<span class="search-keyword"><?php echo htmlspecialchars($keyword); ?></span>"</h2>
                <?php if ($search_results && $search_results->num_rows > 0): ?>
                    <p class="search-count">Tìm thấy <?php echo $search_results->num_rows; ?> sản phẩm</p>
                <?php endif; ?>
            </div>

            <?php if ($search_results && $search_results->num_rows > 0): ?>
                <div class="products-grid">
                    <?php while($row = $search_results->fetch_assoc()): 
                        // Xử lý giá
                        $price = floatval(str_replace(['.', ','], '', $row['product_price_new']));
                        if ($price == 0) {
                            $price = floatval(str_replace(['.', ','], '', $row['product_price']));
                        }
                    ?>
                        <div class="product-item">
                            <a href="products.php?id=<?php echo $row['product_id']; ?>">
                                <img src="../admin/uploads/<?php echo $row['product_img']; ?>" 
                                     alt="<?php echo htmlspecialchars($row['product_name']); ?>">
                            </a>
                            <h3><?php echo htmlspecialchars($row['product_name']); ?></h3>
                            <p class="product-price"><?php echo number_format($price, 0, ',', '.'); ?> VNĐ</p>
                            <a href="products.php?id=<?php echo $row['product_id']; ?>" class="product-link">
                                Xem chi tiết
                            </a>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <div class="no-results">
                    <i class="fas fa-search"></i>
                    <h3>Không tìm thấy sản phẩm nào</h3>
                    <p>Không có sản phẩm nào phù hợp với từ khóa "<strong><?php echo htmlspecialchars($keyword); ?></strong>"</p>
                    <p>Vui lòng thử lại với từ khóa khác hoặc xem tất cả sản phẩm</p>
                    <a href="index.php" class="back-link">Quay về trang chủ</a>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="no-results">
                <i class="fas fa-exclamation-circle"></i>
                <h3>Vui lòng nhập từ khóa tìm kiếm</h3>
                <p>Bạn chưa nhập từ khóa để tìm kiếm sản phẩm</p>
                <a href="index.php" class="back-link">Quay về trang chủ</a>
            </div>
        <?php endif; ?>
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

        // Submit form khi nhấn Enter
        const searchInput = document.getElementById('searchInput');
        const searchForm = document.getElementById('searchForm');
        
        if (searchForm) {
            searchForm.addEventListener('submit', function(e) {
                const keyword = searchInput.value.trim();
                
                if (!keyword) {
                    e.preventDefault();
                    alert('Vui lòng nhập từ khóa tìm kiếm!');
                    searchInput.focus();
                    return false;
                }
            });
        }
    </script>
</body>
</html>