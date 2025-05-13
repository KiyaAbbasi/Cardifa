<?php
/**
 * File: functions.php
 * Location: includes/
 * Description:
 *   عملکردهای عمومی افزونه:
 *   - بارگذاری assetهای CSS/JS/Fonts
 *   - مرتب‌سازی منوها برای قرارگیری صحیح کاردیفا
 */

defined( 'ABSPATH' ) || exit;

/**
 * Enqueue Cardifa styles & scripts for admin & public.
 */
function cardifa_enqueue_assets() {
    // بررسی وجود فایل‌ها قبل از بارگذاری
    $assets_path = CARDIFA_URL . 'assets/';
    $admin_css = $assets_path . 'admin/css/admin-style.css';
    $admin_js = $assets_path . 'admin/js/admin-settings.js';
    $public_css = $assets_path . 'public/css/public-style.css';
    $public_js = $assets_path . 'public/js/public-script.js';

    // بارگذاری استایل‌ها و اسکریپت‌ها برای بخش ادمین
    if ( is_admin() ) {
        // ۱) بارگذاری Dashicons
        wp_enqueue_style( 'dashicons' );

        if ( file_exists( $admin_css ) ) {
            wp_enqueue_style(
                'cardifa-admin-style',
                $admin_css,
                array( 'cardifa-yekan', 'cardifa-fontello' ),
                '1.1.0'
            );
        }
        if ( file_exists( $admin_js ) ) {
            wp_enqueue_script(
                'cardifa-admin-settings',
                $admin_js,
                array( 'jquery' ),
                '1.1.0',
                true
            );
        }

        // بارگذاری استایل دکمه‌های ویرایشگر (TinyMCE)
        wp_enqueue_style( 'editor-buttons' );

    } else {
        // بارگذاری استایل‌ها و اسکریپت‌ها برای بخش عمومی
        if ( file_exists( $public_css ) ) {
            wp_enqueue_style(
                'cardifa-public-style',
                $public_css,
                array(),
                '1.0.0'
            );
        }
        if ( file_exists( $public_js ) ) {
            wp_enqueue_script(
                'cardifa-public-script',
                $public_js,
                array( 'jquery' ),
                '1.0.0',
                true
            );
        }
    }
}
add_action( 'admin_enqueue_scripts', 'cardifa_enqueue_assets', 20 );
add_action( 'wp_enqueue_scripts',    'cardifa_enqueue_assets' );

