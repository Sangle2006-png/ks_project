<?php
/**
 * Session Class
 * Quản lý session người dùng (login, logout, check đăng nhập...)
 */
class Session {
    
    // Khởi tạo session (gọi 1 lần duy nhất)
    public static function init() {
        if (version_compare(phpversion(), '5.4.0', '<')) {
            if (session_id() == '') {
                session_start();
            }
        } else {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
        }
    }

    // Đặt giá trị session
    public static function set($key, $val) {
        $_SESSION[$key] = $val;
    }

    // Lấy giá trị session
    public static function get($key) {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        } else {
            return false;
        }
    }

    // Kiểm tra đã đăng nhập chưa + redirect nếu chưa
    public static function checkLogin() {
        self::init();
        if (self::get('login') == true) {
            header("Location: index.php");
        }
    }

    // Kiểm tra session đăng nhập + redirect nếu đã login (dùng cho trang login/register)
    public static function checkSession() {
        self::init();
        if (self::get('login') == false) {
            self::destroy();
            header("Location: login.php");
        }
    }

    // Kiểm tra quyền admin (nếu cần phân quyền sau này)
    public static function checkAdmin() {
        self::init();
        if (self::get('login') == false || self::get('admin') != true) {
            self::destroy();
            header("Location: login.php");
        }
    }

    // Đăng xuất - Hủy toàn bộ session
    public static function destroy() {
        session_destroy();
        session_unset();
        header("Location: login.php");
    }

    // Đăng xuất và quay về trang chủ (dùng cho nút logout ở frontend)
    public static function logout() {
        session_destroy();
        session_unset();
        header("Location: index.php");
    }
}
?>