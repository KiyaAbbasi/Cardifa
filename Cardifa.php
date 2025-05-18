<?php
/**
 * Plugin Name: کاردیفا - سازنده کارت ویزیت دیجیتال
 * Plugin URI: https://github.com/KiyaAbbasi/Cardifa
 * GitHub Plugin URI: https://github.com/KiyaAbbasi/Cardifa
 * GitHub Branch: Cardifa
 * Description: افزونه‌ای کامل برای ساخت کارت دیجیتال، لینک بایو، سیستم اشتراک و پنل کاربری با قابلیت ثبت‌نام با شماره موبایل و ویجت‌های حرفه‌ای المنتور.
 * Version: 3.0.0
 * Author: Kiya Holding
 * Author URI: https://kiyaholding.com
 * Text Domain: cardifa
 * Domain Path: /lang
 *
 * @package Cardifa
 * @since 1.0.0
 */

defined('ABSPATH') || exit;

// ─── تعریف ثابت‌های اصلی ───────────────────────────
if (! defined('CARDIFA_VERSION')) {
    define('CARDIFA_VERSION', '3.0.0'); // ورژن اصلی پلاگین
}
if (! defined('CARDIFA_FILE')) {
    define('CARDIFA_FILE', __FILE__);
}
if (! defined('CARDIFA_PATH')) {
    define('CARDIFA_PATH', plugin_dir_path(__FILE__)); // دقت کن PATH باشه نه DIR
}
if (! defined('CARDIFA_URL')) {
    define('CARDIFA_URL', plugin_dir_url(__FILE__));
}

// ─── بارگذاری ترجمه‌ها ───────────────────────────────
add_action('plugins_loaded', function() {
    load_plugin_textdomain(
        'cardifa',
        false,
        dirname(plugin_basename(CARDIFA_FILE)) . '/lang'
    );
});

// ─── PSR-4 Autoloader برای کلاس‌های Src/ ───────────────
spl_autoload_register(function($class) {
    // فقط نِیم‌اسپیس Cardifa\
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


require_once plugin_dir_path(__FILE__) . 'Src/Admin/Settings/SmsSettings.php';


// ─── فانکشن‌های Activation/Deactivation (بدون کلاس) ────
require_once CARDIFA_PATH . 'Includes/Activation.php';
require_once CARDIFA_PATH . 'Includes/Deactivation.php';

// ─── لود پست تایپ ──────────────────────────────
require_once CARDIFA_PATH . 'Includes/CustomPostTypes.php';

// ─── هوک‌های نصب/حذف ─────────────────────────────────
register_activation_hook( CARDIFA_FILE,   'cardifa_activate_plugin' );
register_deactivation_hook( CARDIFA_FILE, 'cardifa_deactivate_plugin' );

// ─── بوت کردن اصلی افزونه ──────────────────────────────
function cardifa_init() {
    // فقط singleton رو بساز، اجازه بده init از طریق هوک داخلی خودش اجرا بشه
    \Cardifa\Core\Application::getInstance();
}
add_action('init', 'cardifa_init', 0);

// ─── لود خودکار ویجت‌های المنتور ──────────────────────
add_action('elementor/widgets/widgets_registered', function() {
    foreach (glob(CARDIFA_PATH . 'Src/Elementor/Widgets/*.php') as $widget) {
        require_once $widget;
    }
}, 5);
