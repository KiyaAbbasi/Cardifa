<?php
/**
 * Plugin Name:   کاردیفا – سازنده کارت ویزیت دیجیتال
 * Plugin URI:    https://cardifa.link
 * Description:   افزونه‌ای جامع برای ساخت کارت دیجیتال، لینک بایو، سیستم اشتراک و پنل کاربری با ثبت‌نام موبایل و ویجت‌های المنتور
 * Version:       1.0.0
 * Author:        Kiya Holding
 * Author URI:    https://kiyaholding.com
 * Text Domain:   cardifa
 * Domain Path:   /languages
 */

defined('ABSPATH') || exit;

// ─── PSR-4 Autoload ─────────────────────────────────
spl_autoload_register(function($class) {
    if (strpos($class, 'Cardifa\\') !== 0) return;
    $rel = substr($class, strlen('Cardifa\\'));
    $path = plugin_dir_path(__FILE__) . 'Src/' . str_replace('\\', '/', $rel) . '.php';
    if (file_exists($path)) require_once $path;
});

// ─── ترجمه‌ها ───────────────────────────────────────
add_action('init', function(){
    load_plugin_textdomain('cardifa', false, dirname(plugin_basename(__FILE__)) . '/languages');
});

// ─── Activation / Deactivation ───────────────────────
require_once __DIR__ . '/Includes/activation.php';
require_once __DIR__ . '/Includes/deactivation.php';
register_activation_hook(   __FILE__, 'cardifa_activate_plugin'   );
register_deactivation_hook( __FILE__, 'cardifa_deactivate_plugin' );

// ─── Bootstrapping اصلی ─────────────────────────────
add_action('init', function(){
    \Cardifa\Core\Application::getInstance()->init();
}, 0);
