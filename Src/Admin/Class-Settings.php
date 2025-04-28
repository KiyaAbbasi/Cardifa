<?php
/**
 * File:        Class-Settings.php
 * Description: صفحهٔ تنظیمات کاردیفا با تب‌های عمومی، پیامکی، کاربران، پست‌تایپ‌ها و پلن‌ها
 * Since:       1.0.0
 * Author:      Kiya Holding
 */

namespace Cardifa\Admin;

defined('ABSPATH') || exit;

class Class_Settings
{
    /**
     * رندر کردن فرم تنظیمات
     *
     * @since 1.0.0
     */
    public static function render(): void
    {
        $tabs = [
            'general'    => __('تنظیمات عمومی', 'cardifa'),
            'sms'        => __('تنظیمات پیامکی', 'cardifa'),
            'users'      => __('مدیریت کاربران', 'cardifa'),
            'post_types' => __('مدیریت پست‌تایپ‌ها', 'cardifa'),
            'plans'      => __('مدیریت پلن‌ها', 'cardifa'),
        ];
        // TODO: فرم تنظیمات را بر اساس $tabs خروجی بده
        echo '<div class="wrap"><h1>' . esc_html__('تنظیمات کاردیفا', 'cardifa') . '</h1></div>';
    }
}
