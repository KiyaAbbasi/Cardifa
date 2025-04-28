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
 * @since   1.0.0
 */

defined('ABSPATH') || exit;

// ─── ثابت‌ها ───────────────────────────────────
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

// ─── ترجمه‌ها ───────────────────────────────────
add_action('plugins_loaded', function() {
    load_plugin_textdomain(
        'cardifa',
        false,
        dirname(plugin_basename(CARDIFA_FILE)) . '/lang'
    );
});

// ─── Autoload همه کلاس‌های Src/ براساس PSR-4 ──────
spl_autoload_register(function($class) {
    // فقط نِیم‌اسپیس Cardifa\
    if (strpos($class, 'Cardifa\\') !== 0) {
        return;
    }
    // Cardifa\Foo\Bar => Src/Foo/Bar.php
    $rel = str_replace('\\', '/', substr($class, strlen('Cardifa\\')));
    $file = CARDIFA_PATH . 'Src/' . $rel . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

// ─── فانکشن‌های Activation/Deactivation (بدون کلاس) ─
require_once CARDIFA_PATH . 'Includes/Activation.php';
require_once CARDIFA_PATH . 'Includes/Deactivation.php';

// ─── هوک‌های نصب/حذف ───────────────────────────────
register_activation_hook( CARDIFA_FILE,   'cardifa_activate_plugin' );
register_deactivation_hook(CARDIFA_FILE, 'cardifa_deactivate_plugin' );

// ─── بوت‌کردن اصلی افزونه (Admin / Public / Elementor) ─
add_action('init', function() {
    // متد run() در Application همه‌ی Bootstrap ها رو register می‌کنه
    \Cardifa\Core\Application::getInstance()->run();
}, 0);
