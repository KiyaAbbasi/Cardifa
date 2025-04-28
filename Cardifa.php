<?php
/**
 * Plugin Name:   کاردیفا – سازنده کارت ویزیت دیجیتال
 * Plugin URI:    https://github.com/KiyaAbbasi/Cardifa
 * Description:   افزونه‌ای کامل برای ساخت کارت دیجیتال، لینک بایو، سیستم اشتراک و پنل کاربری…
 * Version:       3.0.0
 * Author:        Kiya Holding
 * Author URI:    https://kiyaholding.com
 * Text Domain:   cardifa
 * Domain Path:   /lang
 */

defined('ABSPATH') || exit;

// ─── ثابت‌ها ────────────────────────────
if (! defined('CARDIFA_VERSION')) {
    define('CARDIFA_VERSION', '3.0.0');
}
if (! defined('CARDIFA_FILE')) {
    define('CARDIFA_FILE', __FILE__);
}
if (! defined('CARDIFA_PATH')) {
    define('CARDIFA_PATH', plugin_dir_path(__FILE__));
}
if (! defined('CARDIFA_URL')) {
    define('CARDIFA_URL', plugin_dir_url(__FILE__));
}

// ─── ترجمه‌ها ────────────────────────────
add_action('plugins_loaded', function() {
    load_plugin_textdomain(
        'cardifa',
        false,
        dirname(plugin_basename(CARDIFA_FILE)) . '/lang'
    );
});

// ─── PSR-4 Autoloader ────────────────────
spl_autoload_register(function($class) {
    // only load our namespace
    if (strpos($class, 'Cardifa\\') !== 0) {
        return;
    }
    // Cardifa\Foo\Bar => Src/Foo/Bar.php
    $relative = str_replace('\\', '/', substr($class, strlen('Cardifa\\')));
    $file = CARDIFA_PATH . 'Src/' . $relative . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

// ─── include قدیمی (Activation/Deactivation) ─
require_once CARDIFA_PATH . 'Includes/Activation.php';
require_once CARDIFA_PATH . 'Includes/Deactivation.php';

// ─── Activation / Deactivation Hooks ──────
register_activation_hook(CARDIFA_FILE,   'cardifa_activate_plugin');
register_deactivation_hook(CARDIFA_FILE, 'cardifa_deactivate_plugin');

// ─── بوت‌کردن افزونه ─────────────────────
add_action('init', function() {
    // Core Application
    \Cardifa\Core\Application::getInstance()->run();
    
    // اگر بدون Composer می‌خوای Admin Loader داشته باشی
    if (class_exists('Cardifa\\Src\\Admin\\Admin_Loader')) {
        new \Cardifa\Src\Admin\Admin_Loader();
    }
}, 0);

// ─── Elementor Widgets لود خودکار ───────
add_action('elementor/widgets/widgets_registered', function() {
    foreach (glob(CARDIFA_PATH . 'Src/Elementor/Widgets/*.php') as $f) {
        require_once $f;  // کلاس‌ها namespace رو حفظ کنن!
    }
}, 5);
