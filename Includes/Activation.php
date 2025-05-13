<?php
/**
 * File Name:    activation.php
 * Location:     includes/
 * Description:  عملیات فعال‌سازی افزونه
 */
defined('ABSPATH') || exit;

function cardifa_activate_plugin() {
    // بررسی وجود تنظیمات پیش‌فرض
    if (!get_option('cardifa_settings')) {
        $default_options = array(
            'color' => '#000000',
            'font'  => 'Yekan Bakh',
            'version' => CARDIFA_VERSION
        );
        add_option('cardifa_settings', $default_options);
    } else {
        // در صورت وجود، نسخه را به‌روزرسانی کنید
        $current_options = get_option('cardifa_settings');
        $current_options['version'] = CARDIFA_VERSION;
        update_option('cardifa_settings', $current_options);
    }
}
