<?php
/**
 * File: Class-Settings.php
 * Description: صفحهٔ تنظیمات کاردیفا با تب‌های عمومی، پیامکی، کاربران، پست‌تایپ‌ها و پلن‌ها
 */

namespace Cardifa\Src\Admin;

defined('ABSPATH') || exit;

class Class_Settings
{
    public static function render()
    {
        $tabs = [
            'general'    => 'تنظیمات عمومی',
            'sms'        => 'تنظیمات پیامکی',
            'users'      => 'مدیریت کاربران',
            'post_types' => 'مدیریت پست‌تایپ‌ها',
            'plans'      => 'مدیریت پلن‌ها',
        ];

        $current = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : 'general';

        echo '<div id="cardifa-settings-wrapper">';
        
        // هدر
        echo '<div id="cardifa-settings-header">';
        echo '<h1>تنظیمات کاردیفا</h1>';
        submit_button('ذخیره تنظیمات', 'primary', 'submit', false, ['id' => 'cardifa-settings-save']);
        echo '</div>';

        settings_errors('cardifa_settings_' . $current);

        // تب‌ها
        echo '<h2 class="nav-tab-wrapper">';
        foreach ($tabs as $slug => $label) {
            $active = ($slug === $current) ? ' nav-tab-active' : '';
            echo '<a class="nav-tab' . esc_attr($active) . '" href="?page=cardifa_settings&tab=' . esc_attr($slug) . '">' . esc_html($label) . '</a>';
        }
        echo '</h2>';

        // فرم تنظیمات
        echo '<form method="post" action="options.php">';
        settings_fields('cardifa_settings_' . $current);
        do_settings_sections('cardifa_settings_' . $current);

        // مخصوص پلن‌ها
        if ('plans' === $current) {
            $plans = get_option('cardifa_plans_options', []);
            echo '<table class="form-table"><tbody>';
            foreach ($plans as $i => $plan) {
                echo '<tr>';
                echo '<td><input name="cardifa_plans_options[' . $i . '][name]" value="' . esc_attr($plan['name'] ?? '') . '" placeholder="نام پلن"></td>';
                echo '<td><input name="cardifa_plans_options[' . $i . '][price]" value="' . esc_attr($plan['price'] ?? '') . '" placeholder="قیمت"></td>';
                echo '<td><input name="cardifa_plans_options[' . $i . '][duration]" value="' . esc_attr($plan['duration'] ?? '') . '" placeholder="مدت (ماه)"></td>';
                echo '<td><input name="cardifa_plans_options[' . $i . '][discount]" value="' . esc_attr($plan['discount'] ?? '') . '" placeholder="% تخفیف"></td>';
                echo '<td><input name="cardifa_plans_options[' . $i . '][max_cards]" value="' . esc_attr($plan['max_cards'] ?? '') . '" placeholder="حداکثر کارت"></td>';
                echo '<td><input name="cardifa_plans_options[' . $i . '][free_sms]" value="' . esc_attr($plan['free_sms'] ?? '') . '" placeholder="SMS رایگان"></td>';
                echo '<td><input name="cardifa_plans_options[' . $i . '][storage]" value="' . esc_attr($plan['storage'] ?? '') . '" placeholder="فضای ذخیره (MB)"></td>';
                echo '<td><a href="#" class="remove-plan">حذف</a></td>';
                echo '</tr>';
            }
            echo '</tbody></table>';
            echo '<p><a href="#" id="cardifa-add-plan" class="button">افزودن پلن جدید</a></p>';
        }

        echo '</form>';
        echo '</div>';
    }
}

// ثبت تنظیمات
function cardifa_register_settings()
{
    $sections = [
        'general'    => 'تنظیمات عمومی',
        'sms'        => 'تنظیمات پیامکی',
        'users'      => 'مدیریت کاربران',
        'post_types' => 'مدیریت پست‌تایپ‌ها',
        'plans'      => 'مدیریت پلن‌ها',
    ];

    foreach ($sections as $key => $title) {
        register_setting('cardifa_settings_' . $key, 'cardifa_' . $key . '_options');
        add_settings_section($key . '_section', $title, '__return_null', 'cardifa_settings_' . $key);
    }
}
add_action('admin_init', __NAMESPACE__ . '\cardifa_register_settings');
