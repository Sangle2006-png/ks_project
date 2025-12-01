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

// ===================================
// DELIVERY PAGE JAVASCRIPT
// ===================================

document.addEventListener('DOMContentLoaded', function() {
    
    // ===================================
    // RADIO BUTTON HANDLING
    // ===================================
    const radioOptions = document.querySelectorAll('.radio-option');
    const radioInputs = document.querySelectorAll('input[name="loginType"]');
    
    radioInputs.forEach(input => {
        input.addEventListener('change', function() {
            // Remove checked class from all options
            radioOptions.forEach(option => {
                option.classList.remove('checked');
            });
            
            // Add checked class to selected option
            if (this.checked) {
                this.closest('.radio-option').classList.add('checked');
            }
        });
    });
    
    // Click on label to select radio
    radioOptions.forEach(option => {
        option.addEventListener('click', function(e) {
            if (e.target.tagName !== 'INPUT') {
                const radio = this.querySelector('input[type="radio"]');
                radio.checked = true;
                radio.dispatchEvent(new Event('change'));
            }
        });
    });
    
    // ===================================
    // PROVINCE - DISTRICT - WARD CASCADE
    // ===================================
    const provinceSelect = document.getElementById('province');
    const districtSelect = document.getElementById('district');
    const wardSelect = document.getElementById('ward');
    
    // Sample data structure (you can replace with API call)
    const locationData = {
        'hanoi': {
            name: 'Hà Nội',
            districts: {
                'haibatrung': {
                    name: 'Hai Bà Trưng',
                    wards: ['Vĩnh Tuy', 'Bạch Đằng', 'Trương Định', 'Thanh Nhàn', 'Phạm Đình Hổ']
                },
                'dongda': {
                    name: 'Đống Đa',
                    wards: ['Văn Miếu', 'Quốc Tử Giám', 'Khâm Thiên', 'Láng Hạ', 'Ô Chợ Dừa']
                },
                'hoangmai': {
                    name: 'Hoàng Mai',
                    wards: ['Hoàng Văn Thụ', 'Giáp Bát', 'Lĩnh Nam', 'Thịnh Liệt', 'Trần Phú']
                },
                'caugiay': {
                    name: 'Cầu Giấy',
                    wards: ['Nghĩa Đô', 'Dịch Vọng', 'Quan Hoa', 'Mai Dịch', 'Yên Hòa']
                }
            }
        },
        'hcm': {
            name: 'TP. Hồ Chí Minh',
            districts: {
                'quan1': {
                    name: 'Quận 1',
                    wards: ['Bến Nghé', 'Bến Thành', 'Nguyễn Thái Bình', 'Phạm Ngũ Lão', 'Cầu Ông Lãnh']
                },
                'quan3': {
                    name: 'Quận 3',
                    wards: ['Võ Thị Sáu', 'Phường 1', 'Phường 2', 'Phường 3', 'Phường 4']
                },
                'binhthanh': {
                    name: 'Bình Thạnh',
                    wards: ['Phường 1', 'Phường 2', 'Phường 3', 'Phường 11', 'Phường 12']
                }
            }
        },
        'danang': {
            name: 'Đà Nẵng',
            districts: {
                'haichau': {
                    name: 'Hải Châu',
                    wards: ['Thạch Thang', 'Hải Châu 1', 'Hải Châu 2', 'Thanh Bình', 'Bình Hiên']
                },
                'thankhue': {
                    name: 'Thanh Khê',
                    wards: ['Tam Thuận', 'Thanh Khê Tây', 'Thanh Khê Đông', 'Xuân Hà', 'Tân Chính']
                }
            }
        },
        'haiphong': {
            name: 'Hải Phòng',
            districts: {
                'hongan': {
                    name: 'Hồng Bàng',
                    wards: ['Quán Toan', 'Hùng Vương', 'Sở Dầu', 'Thượng Lý', 'Hạ Lý']
                },
                'ngohan': {
                    name: 'Ngô Quyền',
                    wards: ['Máy Chai', 'Máy Tơ', 'Vạn Mỹ', 'Lạc Viên', 'Cầu Tre']
                }
            }
        },
        'cantho': {
            name: 'Cần Thơ',
            districts: {
                'ninhkieu': {
                    name: 'Ninh Kiều',
                    wards: ['Cái Khế', 'An Hòa', 'Thới Bình', 'An Nghiệp', 'An Cư']
                },
                'cairang': {
                    name: 'Cái Răng',
                    wards: ['Lê Bình', 'Hưng Phú', 'Hưng Thạnh', 'Ba Láng', 'Thường Thạnh']
                }
            }
        }
    };
    
    // Update districts when province changes
    provinceSelect.addEventListener('change', function() {
        const provinceValue = this.value;
        
        // Clear district and ward
        districtSelect.innerHTML = '<option value="">Chọn Quận/Huyện</option>';
        wardSelect.innerHTML = '<option value="">Chọn Phường/Xã</option>';
        
        if (provinceValue && locationData[provinceValue]) {
            const districts = locationData[provinceValue].districts;
            
            for (let districtKey in districts) {
                const option = document.createElement('option');
                option.value = districtKey;
                option.textContent = districts[districtKey].name;
                districtSelect.appendChild(option);
            }
        }
    });
    
    // Update wards when district changes
    districtSelect.addEventListener('change', function() {
        const provinceValue = provinceSelect.value;
        const districtValue = this.value;
        
        // Clear ward
        wardSelect.innerHTML = '<option value="">Chọn Phường/Xã</option>';
        
        if (provinceValue && districtValue && locationData[provinceValue]) {
            const wards = locationData[provinceValue].districts[districtValue].wards;
            
            wards.forEach(ward => {
                const option = document.createElement('option');
                option.value = ward.toLowerCase().replace(/\s+/g, '');
                option.textContent = ward;
                wardSelect.appendChild(option);
            });
        }
    });
    
    // ===================================
    // FORM VALIDATION
    // ===================================
    const form = document.querySelector('.delivery-form');
    const submitButton = document.querySelector('.btn-submit');
    
    if (submitButton) {
        submitButton.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Get form values
            const fullName = document.getElementById('fullName').value.trim();
            const phone = document.getElementById('phone').value.trim();
            const province = document.getElementById('province').value;
            const district = document.getElementById('district').value;
            const ward = document.getElementById('ward').value;
            const address = document.getElementById('address').value.trim();
            
            // Validation
            let errors = [];
            
            if (!fullName) {
                errors.push('Vui lòng nhập họ tên');
                highlightError('fullName');
            }
            
            if (!phone) {
                errors.push('Vui lòng nhập số điện thoại');
                highlightError('phone');
            } else if (!isValidPhone(phone)) {
                errors.push('Số điện thoại không hợp lệ');
                highlightError('phone');
            }
            
            if (!province) {
                errors.push('Vui lòng chọn Tỉnh/TP');
                highlightError('province');
            }
            
            if (!district) {
                errors.push('Vui lòng chọn Quận/Huyện');
                highlightError('district');
            }
            
            if (!ward) {
                errors.push('Vui lòng chọn Phường/Xã');
                highlightError('ward');
            }
            
            if (!address) {
                errors.push('Vui lòng nhập địa chỉ cụ thể');
                highlightError('address');
            }
            
            // Show errors or proceed
            if (errors.length > 0) {
                alert('Vui lòng kiểm tra lại thông tin:\n\n' + errors.join('\n'));
            } else {
                // If validation passes, you can submit the form or redirect
                alert('Thông tin đã được xác nhận!\nChuyển đến trang thanh toán...');
                // window.location.href = 'payment.html';
            }
        });
    }
    
    // Helper function to validate phone number
    function isValidPhone(phone) {
        // Vietnamese phone number format (10 digits, starts with 0)
        const phoneRegex = /^0[0-9]{9}$/;
        return phoneRegex.test(phone);
    }
    
    // Helper function to highlight error fields
    function highlightError(fieldId) {
        const field = document.getElementById(fieldId);
        if (field) {
            field.style.borderColor = '#e74c3c';
            field.addEventListener('input', function() {
                this.style.borderColor = '';
            }, { once: true });
        }
    }
    
    // ===================================
    // INPUT FORMATTING
    // ===================================
    const phoneInput = document.getElementById('phone');
    
    if (phoneInput) {
        phoneInput.addEventListener('input', function(e) {
            // Remove non-numeric characters
            this.value = this.value.replace(/[^0-9]/g, '');
            
            // Limit to 10 digits
            if (this.value.length > 10) {
                this.value = this.value.slice(0, 10);
            }
        });
    }
    
    // ===================================
    // SMOOTH SCROLL FOR BACK BUTTON
    // ===================================
    const backButton = document.querySelector('.btn-back');
    
    if (backButton) {
        backButton.addEventListener('click', function(e) {
            // If you want to add animation before going back
            e.preventDefault();
            
            // Add fade out animation
            document.querySelector('.delivery-container').style.opacity = '0';
            document.querySelector('.delivery-container').style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                window.history.back();
                // Or redirect to specific page:
                // window.location.href = 'cart.html';
            }, 300);
        });
    }
    
    // ===================================
    // SAVE TO LOCAL STORAGE (OPTIONAL)
    // ===================================
    const formInputs = document.querySelectorAll('.delivery-form input, .delivery-form select');
    
    // Load saved data from localStorage
    formInputs.forEach(input => {
        const savedValue = localStorage.getItem(`delivery_${input.id}`);
        if (savedValue && input.type !== 'radio') {
            input.value = savedValue;
        }
    });
    
    // Save data to localStorage on input change
    formInputs.forEach(input => {
        input.addEventListener('change', function() {
            if (this.type !== 'radio') {
                localStorage.setItem(`delivery_${this.id}`, this.value);
            }
        });
    });
    
    // ===================================
    // ANIMATION ON LOAD
    // ===================================
    window.addEventListener('load', function() {
        const deliveryContainer = document.querySelector('.delivery-container');
        if (deliveryContainer) {
            deliveryContainer.style.opacity = '0';
            deliveryContainer.style.transform = 'translateY(30px)';
            
            setTimeout(() => {
                deliveryContainer.style.transition = 'all 0.5s ease';
                deliveryContainer.style.opacity = '1';
                deliveryContainer.style.transform = 'translateY(0)';
            }, 100);
        }
    });
    
    // ===================================
    // DYNAMIC PRICE CALCULATION (OPTIONAL)
    // ===================================
    function updateOrderSummary() {
        // This is a placeholder - you can add logic to calculate shipping, taxes, etc.
        const subtotal = 483000;
        const shipping = 30000; // Example shipping fee
        const total = subtotal + shipping;
        
        // You can update the DOM with calculated values
        console.log('Order Total:', total);
    }
    
});

// ===================================
// UTILITY FUNCTIONS
// ===================================

// Format currency
function formatCurrency(amount) {
    return new Intl.NumberFormat('vi-VN', {
        style: 'currency',
        currency: 'VND'
    }).format(amount);
}

// Format phone number display
function formatPhoneDisplay(phone) {
    if (phone.length === 10) {
        return phone.replace(/(\d{4})(\d{3})(\d{3})/, '$1 $2 $3');
    }
    return phone;
}


// ===================================
// PAYMENT PAGE JAVASCRIPT
// ===================================

// Shipping fee constant
const SHIPPING_FEE = 38000;

// Load cart data from localStorage
let cartItems = [];
let orderInfo = {};

// Try to load saved data
try {
    const savedCart = localStorage.getItem('cart');
    if (savedCart) {
        cartItems = JSON.parse(savedCart);
    }
    
    const savedOrder = localStorage.getItem('orderInfo');
    if (savedOrder) {
        orderInfo = JSON.parse(savedOrder);
    }
} catch (e) {
    console.error('Error loading data:', e);
}

document.addEventListener('DOMContentLoaded', function() {
    
    // ===================================
    // RENDER PRODUCTS & CALCULATE
    // ===================================
    renderProducts();
    calculateTotals();
    
    // ===================================
    // RADIO BUTTON HANDLING
    // ===================================
    const paymentOptions = document.querySelectorAll('.payment-option');
    const radioInputs = document.querySelectorAll('input[type="radio"]');
    
    radioInputs.forEach(input => {
        input.addEventListener('change', function() {
            // Remove checked class from all options of the same name
            const sameName = document.querySelectorAll(`input[name="${this.name}"]`);
            sameName.forEach(radio => {
                radio.closest('.payment-option').classList.remove('checked');
            });
            
            // Add checked class to selected option
            if (this.checked) {
                this.closest('.payment-option').classList.add('checked');
            }
        });
    });
    
    // Click on label to select radio
    paymentOptions.forEach(option => {
        option.addEventListener('click', function(e) {
            if (e.target.tagName !== 'INPUT') {
                const radio = this.querySelector('input[type="radio"]');
                if (radio) {
                    radio.checked = true;
                    radio.dispatchEvent(new Event('change'));
                }
            }
        });
    });
    
    // ===================================
    // COUPON CODE APPLICATION
    // ===================================
    const applyCouponBtn = document.querySelector('.btn-apply-coupon');
    const couponInput = document.getElementById('couponCode');
    
    if (applyCouponBtn) {
        applyCouponBtn.addEventListener('click', function() {
            const couponCode = couponInput.value.trim().toUpperCase();
            
            if (!couponCode) {
                alert('Vui lòng nhập mã giảm giá!');
                return;
            }
            
            // Sample coupon validation (replace with your API)
            const validCoupons = {
                'BECK2024': { type: 'percentage', value: 10, description: 'Giảm 10%' },
                'FREESHIP': { type: 'shipping', value: SHIPPING_FEE, description: 'Miễn phí vận chuyển' },
                'SAVE50K': { type: 'fixed', value: 50000, description: 'Giảm 50.000₫' }
            };
            
            if (validCoupons[couponCode]) {
                const coupon = validCoupons[couponCode];
                applyCoupon(coupon);
                alert(`✓ Áp dụng mã thành công: ${coupon.description}`);
                couponInput.value = '';
            } else {
                alert('Mã giảm giá không hợp lệ hoặc đã hết hạn!');
            }
        });
    }
    
    // ===================================
    // EMPLOYEE CODE APPLICATION
    // ===================================
    const applyEmployeeBtn = document.querySelector('.btn-apply-employee');
    const employeeInput = document.getElementById('employeeCode');
    
    if (applyEmployeeBtn) {
        applyEmployeeBtn.addEventListener('click', function() {
            const employeeCode = employeeInput.value.trim().toUpperCase();
            
            if (!employeeCode) {
                alert('Vui lòng nhập mã cộng tác viên!');
                return;
            }
            
            // Sample employee code validation
            const validEmployees = {
                'CTV001': { discount: 5, name: 'Nguyễn Văn A' },
                'CTV002': { discount: 7, name: 'Trần Thị B' },
                'CTV003': { discount: 10, name: 'Lê Văn C' }
            };
            
            if (validEmployees[employeeCode]) {
                const employee = validEmployees[employeeCode];
                alert(`✓ Áp dụng mã CTV thành công!\nCộng tác viên: ${employee.name}\nGiảm thêm ${employee.discount}%`);
                employeeInput.value = '';
            } else {
                alert('Mã cộng tác viên không hợp lệ!');
            }
        });
    }
    
    // ===================================
    // EMPLOYEE SELECT CHANGE
    // ===================================
    const employeeSelect = document.getElementById('employeeSelect');
    
    if (employeeSelect) {
        employeeSelect.addEventListener('change', function() {
            if (this.value) {
                alert(`Đã chọn nhân viên: ${this.options[this.selectedIndex].text}`);
            }
        });
    }
    
    // ===================================
    // FORM SUBMISSION
    // ===================================
    const submitButton = document.querySelector('.btn-submit');
    
    if (submitButton) {
        submitButton.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Get selected payment method
            const selectedPayment = document.querySelector('input[name="paymentMethod"]:checked');
            const selectedShipping = document.querySelector('input[name="shippingMethod"]:checked');
            
            if (!selectedPayment) {
                alert('Vui lòng chọn phương thức thanh toán!');
                return;
            }
            
            if (!selectedShipping) {
                alert('Vui lòng chọn phương thức giao hàng!');
                return;
            }
            
            // Check if cart is empty
            if (!cartItems || cartItems.length === 0) {
                alert('Giỏ hàng trống! Vui lòng thêm sản phẩm.');
                return;
            }
            
            // Prepare order data
            const finalOrder = {
                customer: orderInfo.customer || {},
                items: cartItems,
                payment: {
                    method: selectedPayment.value,
                    methodName: getPaymentMethodName(selectedPayment.value)
                },
                shipping: {
                    method: selectedShipping.value,
                    fee: SHIPPING_FEE
                },
                totals: calculateTotals(),
                orderDate: new Date().toISOString(),
                orderNumber: generateOrderNumber()
            };
            
            // Save final order
            localStorage.setItem('finalOrder', JSON.stringify(finalOrder));
            
            // Show confirmation
            const confirmMessage = `
✓ ĐẶT HÀNG THÀNH CÔNG!

Mã đơn hàng: ${finalOrder.orderNumber}
Tổng thanh toán: ${formatCurrency(finalOrder.totals.finalTotal)}
Phương thức thanh toán: ${finalOrder.payment.methodName}

Chúng tôi sẽ liên hệ với bạn sớm nhất!
            `;
            
            alert(confirmMessage);
            
            // Clear cart after successful order
            localStorage.removeItem('cart');
            localStorage.removeItem('orderInfo');
            
            // Redirect to order confirmation page or home
            // window.location.href = 'order-confirmation.html?order=' + finalOrder.orderNumber;
            // Or redirect to home
            // window.location.href = 'index.html';
        });
    }
    
    // ===================================
    // BACK BUTTON
    // ===================================
    const backButton = document.querySelector('.btn-back');
    
    if (backButton) {
        backButton.addEventListener('click', function(e) {
            e.preventDefault();
            window.location.href = 'delivery.html';
        });
    }
    
    // ===================================
    // ANIMATION ON LOAD
    // ===================================
    window.addEventListener('load', function() {
        const paymentContainer = document.querySelector('.payment-container');
        if (paymentContainer) {
            paymentContainer.style.opacity = '0';
            paymentContainer.style.transform = 'translateY(30px)';
            
            setTimeout(() => {
                paymentContainer.style.transition = 'all 0.5s ease';
                paymentContainer.style.opacity = '1';
                paymentContainer.style.transform = 'translateY(0)';
            }, 100);
        }
    });
});

// ===================================
// RENDER PRODUCTS FUNCTION
// ===================================
function renderProducts() {
    const productList = document.getElementById('productList');
    
    if (!productList) return;
    
    if (!cartItems || cartItems.length === 0) {
        productList.innerHTML = '<p style="text-align: center; color: #999; padding: 20px;">Giỏ hàng trống</p>';
        return;
    }
    
    productList.innerHTML = '';
    
    cartItems.forEach(item => {
        const discountedPrice = item.discount > 0 
            ? item.price * (1 - item.discount / 100) 
            : item.price;
        
        const itemTotal = discountedPrice * item.quantity;
        
        const productHTML = `
            <div class="product-item">
                <div class="product-info">
                    <div class="product-name">${item.name}</div>
                    <div class="product-details">${item.size} / ${item.color}</div>
                    <div class="product-price">
                        <span class="product-code">${item.code}</span>
                        ${item.discount > 0 ? `<span class="original-price">${formatCurrency(item.price)}</span>` : ''}
                    </div>
                </div>
                <div class="product-meta">
                    <span class="quantity">SL: ${item.quantity}</span>
                    <span class="product-total">${formatCurrency(itemTotal)}</span>
                </div>
            </div>
        `;
        
        productList.innerHTML += productHTML;
    });
}

// ===================================
// CALCULATE TOTALS
// ===================================
function calculateTotals() {
    let subtotal = 0;
    let totalDiscount = 0;
    
    cartItems.forEach(item => {
        const itemSubtotal = item.price * item.quantity;
        subtotal += itemSubtotal;
        
        if (item.discount > 0) {
            const discountAmount = (item.price * item.discount / 100) * item.quantity;
            totalDiscount += discountAmount;
        }
    });
    
    const tempTotal = subtotal - totalDiscount;
    const finalTotal = tempTotal + SHIPPING_FEE;
    
    // Update DOM
    const subtotalEl = document.getElementById('subtotalAmount');
    const tempTotalEl = document.getElementById('tempTotal');
    const shippingEl = document.getElementById('shippingFee');
    const finalTotalEl = document.getElementById('finalTotal');
    
    if (subtotalEl) subtotalEl.textContent = formatCurrency(subtotal);
    if (tempTotalEl) tempTotalEl.textContent = formatCurrency(tempTotal);
    if (shippingEl) shippingEl.textContent = formatCurrency(SHIPPING_FEE);
    if (finalTotalEl) finalTotalEl.textContent = formatCurrency(finalTotal);
    
    return {
        subtotal: subtotal,
        discount: totalDiscount,
        tempTotal: tempTotal,
        shippingFee: SHIPPING_FEE,
        finalTotal: finalTotal
    };
}

// ===================================
// APPLY COUPON FUNCTION
// ===================================
function applyCoupon(coupon) {
    // This is a simplified version
    // In real app, you'd modify the totals based on coupon type
    
    if (coupon.type === 'shipping') {
        // Free shipping
        document.getElementById('shippingFee').textContent = '0₫';
        calculateTotals();
    } else if (coupon.type === 'percentage') {
        // Percentage discount
        // Apply discount logic here
        calculateTotals();
    } else if (coupon.type === 'fixed') {
        // Fixed amount discount
        // Apply discount logic here
        calculateTotals();
    }
}

// ===================================
// UTILITY FUNCTIONS
// ===================================

// Format currency
function formatCurrency(amount) {
    return new Intl.NumberFormat('vi-VN', {
        style: 'decimal',
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
    }).format(amount) + '₫';
}

// Get payment method name
function getPaymentMethodName(method) {
    const methodNames = {
        'creditcard': 'Thẻ tín dụng (OnePay)',
        'atm': 'Thẻ ATM (OnePay)',
        'momo': 'Ví MoMo',
        'cod': 'Thu tiền tận nơi'
    };
    return methodNames[method] || 'Không xác định';
}

// Generate order number
function generateOrderNumber() {
    const timestamp = Date.now();
    const random = Math.floor(Math.random() * 1000);
    return `BECK${timestamp}${random}`;
}

// ===================================
// EXPORT FUNCTIONS FOR OTHER PAGES
// ===================================

// Function to check if order is ready
function isOrderReady() {
    return cartItems.length > 0 && orderInfo.customer;
}

// Function to get order summary
function getOrderSummary() {
    return {
        items: cartItems,
        customer: orderInfo.customer,
        totals: calculateTotals()
    };
}