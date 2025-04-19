<?php
/**
 * Plugin Name: Cardifa Links
 * Description: افزونه ساخت بایولینک حرفه‌ای برای کاربران با URL کوتاه و تنظیمات المنتوری.
 * Version: 1.0.0
 * Author: Kiya Holding
 */

    if (!defined('ABSPATH')) exit;
    
    // 🔒 تعریف مسیرهای ثابت افزونه
    define('CARDIFA_BIO_PATH', plugin_dir_path(__FILE__));
    define('CARDIFA_BIO_URL', plugin_dir_url(__FILE__));
    
    // ✅ بارگذاری دستی همه کنترل‌ها (امن‌تر از glob)
    require_once CARDIFA_BIO_PATH . 'includes/traits/controls/control-text-style.php';
    require_once CARDIFA_BIO_PATH . 'includes/traits/controls/control-icon-style.php';
    require_once CARDIFA_BIO_PATH . 'includes/traits/controls/control-layout-style.php';
    require_once CARDIFA_BIO_PATH . 'includes/traits/controls/control-background-style.php';
    require_once CARDIFA_BIO_PATH . 'includes/traits/controls/control-border-style.php';
    require_once CARDIFA_BIO_PATH . 'includes/traits/controls/control-box-shadow-style.php';
    require_once CARDIFA_BIO_PATH . 'includes/traits/controls/control-button-style.php';
    require_once CARDIFA_BIO_PATH . 'includes/traits/controls/control-css-filters-style.php';
    require_once CARDIFA_BIO_PATH . 'includes/traits/controls/control-display-style.php';
    require_once CARDIFA_BIO_PATH . 'includes/traits/controls/control-hover-style.php';
    require_once CARDIFA_BIO_PATH . 'includes/traits/controls/control-media-style.php';
    require_once CARDIFA_BIO_PATH . 'includes/traits/controls/control-position-style.php';
    require_once CARDIFA_BIO_PATH . 'includes/traits/controls/control-scroll-style.php';
    require_once CARDIFA_BIO_PATH . 'includes/traits/controls/control-spacing-style.php';
    require_once CARDIFA_BIO_PATH . 'includes/traits/controls/control-text-shadow-style.php';
    require_once CARDIFA_BIO_PATH . 'includes/traits/controls/control-typography-style.php';
    require_once CARDIFA_BIO_PATH . 'includes/traits/controls/control-animation-style.php';
    
    // 🔁 Trait اصلی
    require_once CARDIFA_BIO_PATH . 'includes/traits/trait-basic-cardifa.php';
    
    // 🧩 ویجت‌ها فقط بعد از اجرای المنتور لود بشن
    add_action('elementor/init', function () {
        require_once CARDIFA_BIO_PATH . 'widgets-loader.php';
    });
    
    // 📦 سایر فایل‌های افزونه
    $includes = [
        'includes/post-type.php',
        'includes/routes.php',
        'includes/functions.php',
        'includes/elementor-controls.php',
        'includes/shortcodes.php',
        'admin/meta-boxes.php',
    ];
    
    foreach ($includes as $file) {
        $path = CARDIFA_BIO_PATH . $file;
        if (file_exists($path)) {
            require_once $path;
        } else {
            error_log("❌ Cardifa: فایل '$file' یافت نشد.");
            add_action('admin_notices', function() use ($file) {
                echo "<div class='notice notice-error'><p>❌ افزونه Cardifa: فایل <code>$file</code> پیدا نشد.</p></div>";
            });
        }
    }
