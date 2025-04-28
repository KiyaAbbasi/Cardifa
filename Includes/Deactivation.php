<?php
/**
 * File Name:    deactivation.php
 * Location:     includes/
 * Description:  عملیات غیرفعال‌سازی افزونه
 */
defined('ABSPATH') || exit;

function cardifa_deactivate_plugin() {
    // بررسی تنظیمات موجود قبل از حذف
    if (get_option('cardifa_settings')) {
        delete_option('cardifa_settings');
    }
    
    // TODO: پیام مناسب برای کاربر درباره حذف تنظیمات
}
