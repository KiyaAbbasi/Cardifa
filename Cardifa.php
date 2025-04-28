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

// ─── تعریف ثابت‌های اصلی ───
if (!defined('CARDIFA_VERSION')) {
    define('CARDIFA_VERSION', '3.0.0'); // ورژن اصلی پلاگین
}
if (!defined('CARDIFA_FILE')) {
    define('CARDIFA_FILE', __FILE__);
}
if (!defined('CARDIFA_PATH')) {
    define('CARDIFA_PATH', plugin_dir_path(__FILE__)); // دقت کن PATH باشه نه DIR
}
if (!defined('CARDIFA_URL')) {
    define('CARDIFA_URL', plugin_dir_url(__FILE__));
}

// ─── Composer Autoloader (اختیاری) ───
if (file_exists(CARDIFA_PATH . 'Vendor/autoload.php')) {
    require_once CARDIFA_PATH . 'Vendor/autoload.php';
}

// ─── بارگذاری لودر مدیریت ───
require_once CARDIFA_PATH . 'Src/Admin/Admin_Loader.php'; // 👈👈👈 این خط جدید

// ─── بارگذاری فایل‌های سرویس ───
require_once CARDIFA_PATH . 'Src/Services/HookManager.php';
require_once CARDIFA_PATH . 'Src/Services/AssetManager.php';

// ─── بارگذاری فایل‌های بوت استرپ ───
require_once CARDIFA_PATH . 'Src/Bootstrap/Admin_Bootstrap.php';
require_once CARDIFA_PATH . 'Src/Bootstrap/Public_Bootstrap.php';
require_once CARDIFA_PATH . 'Src/Bootstrap/Elementor_Bootstrap.php';

// ─── بارگذاری Application ───
require_once CARDIFA_PATH . 'Src/Core/Application.php';

// ─── بارگذاری اکتیویشن/دی اکتیویشن ───
require_once CARDIFA_PATH . 'Includes/Activation.php';
require_once CARDIFA_PATH . 'Includes/Deactivation.php';

// ─── تعریف هوک‌های فعال‌سازی و غیرفعال‌سازی ───
register_activation_hook(__FILE__, 'cardifa_activate_plugin');
register_deactivation_hook(__FILE__, 'cardifa_deactivate_plugin');

// ─── بوت کردن افزونه ───
function cardifa_init() {
    return \Cardifa\Core\Application::getInstance();
}
cardifa_init();
