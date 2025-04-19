<?php
/**
 * 📁 فایل functions.php
 * -----------------------
 * توابع مشترک برای مدیریت slug اختصاصی کاربر در سیستم Cardifa
 */

if (!defined('ABSPATH')) exit;

/**
 * ✅ ذخیره slug اختصاصی کاربر برای بایولینک
 *
 * @param int $user_id آیدی کاربر
 * @param string $slug اسلاگ انتخابی
 */
if (!function_exists('cardifa_bio_save_user_slug')) {
    function cardifa_bio_save_user_slug($user_id, $slug) {
        update_user_meta($user_id, 'cardifa_bio_slug', sanitize_title($slug));
    }
}

/**
 * ✅ بررسی اینکه آیا slug وارد شده قبلاً توسط کاربری ثبت شده یا نه
 *
 * @param string $slug اسلاگ انتخابی
 * @return bool true اگر تکراری بود، false اگر قابل استفاده بود
 */
if (!function_exists('cardifa_bio_slug_exists')) {
    function cardifa_bio_slug_exists($slug) {
        $users = get_users(array(
            'meta_key'   => 'cardifa_bio_slug',
            'meta_value' => $slug,
            'number'     => 1,
            'fields'     => 'ID',
        ));
        return !empty($users);
    }
}

/**
 * ✅ دریافت slug ذخیره‌شده کاربر
 *
 * @param int $user_id آیدی کاربر
 * @return string|null slug یا null اگر وجود نداشت
 */
if (!function_exists('cardifa_bio_get_user_slug')) {
    function cardifa_bio_get_user_slug($user_id) {
        return get_user_meta($user_id, 'cardifa_bio_slug', true);
    }
}
