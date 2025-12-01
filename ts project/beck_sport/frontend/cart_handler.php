<?php
// QUAN TRỌNG: Tắt hiển thị lỗi để không làm hỏng JSON
error_reporting(0);
ini_set('display_errors', 0);

session_start();

// Set header JSON ngay từ đầu
header('Content-Type: application/json; charset=utf-8');

// Include class
include_once __DIR__ . '/../admin/class/product_class.php';

try {
    $product = new product();
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Lỗi kết nối database']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = isset($_POST['action']) ? trim($_POST['action']) : '';
    $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
    $size = isset($_POST['size']) ? trim($_POST['size']) : '';
    $color = isset($_POST['color']) ? trim($_POST['color']) : '';

    // Khởi tạo giỏ hàng nếu chưa có
    if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    // THÊM SẢN PHẨM VÀO GIỎ
    if ($action === 'add') {
        // Validate dữ liệu
        if ($product_id <= 0) {
            echo json_encode(['success' => false, 'message' => 'Product ID không hợp lệ']);
            exit;
        }
        
        if ($quantity <= 0) {
            echo json_encode(['success' => false, 'message' => 'Số lượng phải lớn hơn 0']);
            exit;
        }
        
        if (empty($size)) {
            echo json_encode(['success' => false, 'message' => 'Vui lòng chọn size']);
            exit;
        }

        // Kiểm tra sản phẩm có tồn tại không
        $product_detail = $product->get_product_detail($product_id);
        if (!$product_detail || !is_array($product_detail)) {
            echo json_encode(['success' => false, 'message' => 'Sản phẩm không tồn tại']);
            exit;
        }

        // Kiểm tra xem sản phẩm đã có trong giỏ chưa
        $found = false;
        if (!empty($_SESSION['cart']) && is_array($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $index => $item) {
                // Đảm bảo $item là array
                if (!is_array($item)) {
                    continue;
                }
                
                // Kiểm tra key tồn tại
                $item_product_id = isset($item['product_id']) ? intval($item['product_id']) : 0;
                $item_size = isset($item['size']) ? trim($item['size']) : '';
                
                if ($item_product_id == $product_id && $item_size == $size) {
                    $_SESSION['cart'][$index]['quantity'] = (isset($_SESSION['cart'][$index]['quantity']) ? $_SESSION['cart'][$index]['quantity'] : 0) + $quantity;
                    $found = true;
                    break;
                }
            }
        }

        // Nếu chưa có thì thêm mới
        if (!$found) {
            $_SESSION['cart'][] = array(
                'product_id' => $product_id,
                'quantity' => $quantity,
                'size' => $size,
                'color' => $color
            );
        }

        echo json_encode([
            'success' => true, 
            'message' => 'Đã thêm sản phẩm vào giỏ hàng',
            'cart_count' => count($_SESSION['cart'])
        ]);
        exit;
    }

    // CẬP NHẬT SỐ LƯỢNG
    if ($action === 'update') {
        $change = isset($_POST['change']) ? intval($_POST['change']) : 0;
        
        if (!empty($_SESSION['cart']) && is_array($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $index => $item) {
                if (!is_array($item)) continue;
                
                $item_product_id = isset($item['product_id']) ? intval($item['product_id']) : 0;
                $item_size = isset($item['size']) ? trim($item['size']) : '';
                
                if ($item_product_id == $product_id && $item_size == $size) {
                    $new_quantity = (isset($_SESSION['cart'][$index]['quantity']) ? $_SESSION['cart'][$index]['quantity'] : 0) + $change;
                    $_SESSION['cart'][$index]['quantity'] = max(1, $new_quantity); // Tối thiểu là 1
                    break;
                }
            }
        }
        
        echo json_encode(['success' => true]);
        exit;
    }

    // XÓA SẢN PHẨM
    if ($action === 'remove') {
        if (!empty($_SESSION['cart']) && is_array($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $index => $item) {
                if (!is_array($item)) continue;
                
                $item_product_id = isset($item['product_id']) ? intval($item['product_id']) : 0;
                $item_size = isset($item['size']) ? trim($item['size']) : '';
                
                if ($item_product_id == $product_id && $item_size == $size) {
                    unset($_SESSION['cart'][$index]);
                    $_SESSION['cart'] = array_values($_SESSION['cart']); // Reindex array
                    break;
                }
            }
        }
        
        echo json_encode(['success' => true]);
        exit;
    }

    // Action không hợp lệ
    echo json_encode(['success' => false, 'message' => 'Action không hợp lệ']);
    exit;
}

// Method không hợp lệ
echo json_encode(['success' => false, 'message' => 'Method không hợp lệ']);
exit;
?>