// ==================== TOÀN BỘ SCRIPT CHO WEB (gồm cả Product) ====================

document.addEventListener('DOMContentLoaded', function () {

    // ==================== STICKY HEADER + BACK TO TOP ====================
    const header = document.querySelector("header");
    const topBtn = document.querySelector(".top");
    window.addEventListener("scroll", function () {
        const x = window.pageYOffset;
        if (x > 0) {
            header?.classList.add("sticky");
            topBtn?.classList.add("active");
        } else {
            header?.classList.remove("sticky");
            topBtn?.classList.remove("active");
        }
    });

    // ==================== CHỨC NĂNG TRANG SẢN PHẨM (PRODUCT) ====================
    const mainImage = document.getElementById('mainImage');
    if (mainImage) { // Chỉ chạy khi đang ở trang chi tiết sản phẩm
        const defaultSrc = mainImage.src;

        // Highlight ảnh nhỏ đầu tiên khi vào trang
        const firstSmallImg = document.querySelector('.product-content-left-small-img img');
        if (firstSmallImg) firstSmallImg.classList.add('active');

        // Đổi ảnh lớn
        window.changeMainImage = function (element) {
            mainImage.src = element.src;
            document.querySelectorAll('.product-content-left-small-img img').forEach(img => {
                img.classList.remove('active');
            });
            element.classList.add('active');
        };

        // Double click ảnh lớn → về ảnh mặc định
        mainImage.addEventListener('dblclick', () => {
            mainImage.src = defaultSrc;
            document.querySelectorAll('.product-content-left-small-img img').forEach(img => {
                img.classList.remove('active');
            });
            firstSmallImg?.classList.add('active');
        });

        // Chọn Size
        window.selectSize = function (element) {
            document.querySelectorAll('.size-option').forEach(s => s.classList.remove('active'));
            element.classList.add('active');
        };

        // Tăng số lượng
        window.increaseQuantity = function () {
            const input = document.getElementById('quantity');
            input.value = parseInt(input.value) + 1;
        };

        // Giảm số lượng
        window.decreaseQuantity = function () {
            const input = document.getElementById('quantity');
            if (parseInt(input.value) > 1) {
                input.value = parseInt(input.value) - 1;
            }
        };

        // Thêm vào giỏ hàng
        document.querySelector('.btn-add-cart')?.addEventListener('click', function () {
            const productName = document.querySelector('.product-content-right h1')?.textContent || 'Sản phẩm';
            const quantity = document.getElementById('quantity').value;
            const selectedSize = document.querySelector('.size-option.active')?.textContent || 'chưa chọn';

            alert(`Đã thêm vào giỏ hàng!\n\nSản phẩm: ${productName}\nSize: ${selectedSize}\nSố lượng: ${quantity}`);
            // Sau này bạn có thể thay alert bằng lưu vào localStorage hoặc gọi API giỏ hàng
        });
    }
});


    // Update Cart Quantity
    function updateCartQuantity(button, change) {
        const input = button.parentElement.querySelector('input');
        let currentValue = parseInt(input.value);
        let newValue = currentValue + change;
        
        if (newValue >= 1) {
            input.value = newValue;
            updateCartTotals();
        }
    }

    // Remove Cart Item
    function removeCartItem(button) {
        if (confirm('Bạn có chắc muốn xóa sản phẩm này khỏi giỏ hàng?')) {
            const cartItem = button.closest('.cart-item');
            cartItem.style.opacity = '0';
            cartItem.style.transform = 'translateX(-100px)';
            
            setTimeout(() => {
                cartItem.remove();
                updateCartTotals();
                checkEmptyCart();
            }, 300);
        }
    }

    // Update Cart Totals
    function updateCartTotals() {
        // This is a simple example - you would calculate actual totals here
        console.log('Updating cart totals...');
    }

    // Check if cart is empty
    function checkEmptyCart() {
        const cartItems = document.querySelectorAll('.cart-item');
        if (cartItems.length === 0) {
            const cartItemsContainer = document.querySelector('.cart-items');
            cartItemsContainer.innerHTML = `
                <div class="cart-empty">
                    <i class="fa fa-shopping-cart"></i>
                    <h2>Giỏ hàng trống</h2>
                    <p>Bạn chưa có sản phẩm nào trong giỏ hàng</p>
                    <button class="btn-continue-shopping" onclick="continueShopping()">
                        MUA SẮM NGAY
                    </button>
                </div>
            `;
        }
    }

    // Go to Checkout
    function goToCheckout() {
        alert('Chuyển đến trang thanh toán...');
        // window.location.href = 'checkout.html';
    }

    // Continue Shopping
    function continueShopping() {
        alert('Quay lại trang chủ...');
        // window.location.href = 'index.html';
    }

