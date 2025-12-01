<?php
/**
 * Format Class
 * Chứa các hàm hỗ trợ định dạng dữ liệu
 */
class Format {
    
    // Định dạng ngày tháng (ví dụ: 23/11/2025)
    public function formatDate($date) {
        return date('d/m/Y', strtotime($date));
    }

    // Định dạng ngày giờ đầy đủ (ví dụ: 23 Tháng 11, 2025 - 14:30)
    public function formatDateTime($date) {
        return date('d \T\h\á\n\g m, Y - H:i', strtotime($date));
    }

    // Định dạng tiền tệ Việt Nam (1.250.000 đ)
    public function format_currency($number) {
        return number_format($number, 0, ',', '.') . ' đ';
    }

    // Rút gọn văn bản (hiển thị ... nếu quá dài)
    public function textShorten($text, $limit = 100) {
        $text = $text . " ";
        $text = substr($text, 0, $limit);
        $text = substr($text, 0, strrpos($text, ' '));
        $text = $text . "...";
        return $text;
    }

    // Làm sạch dữ liệu đầu vào (bảo mật cơ bản)
    public function validation($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // Tạo title trang dựa trên tên file
    public function title() {
        $path = $_SERVER['SCRIPT_FILENAME'];
        $title = basename($path, '.php');
        // $title = str_replace('_', ' ', $title);

        if ($title == 'index') {
            $title = 'home';
        } elseif ($title == 'contact') {
            $title = 'contact';
        } elseif ($title == 'cart') {
            $title = 'giỏ hàng';
        } elseif ($title == 'product') {
            $title = 'chi tiết sản phẩm';
        } elseif ($title == 'login' || $title == 'register') {
            $title = 'đăng nhập / đăng ký';
        }

        return $title = ucfirst($title);
    }
}
?>
  