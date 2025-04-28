<?php
/**
 * File: Class-Admin-Menu.php
 * Description: تعریف منوی اصلی «کاردیفا» و زیرمنوها
 */

namespace Cardifa\Src\Admin;

defined('ABSPATH') || exit;

use Cardifa\Admin\Class_Settings;

class Class_Admin_Menu
{
    public function __construct()
    {
        add_action('admin_menu', [$this, 'add_admin_menu']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_assets']);
    }

    public function add_admin_menu()
    {
        $icon = 'dashicons-id';

        // منوی اصلی
        add_menu_page(
            __('کاردیفا', 'cardifa'),
            __('کاردیفا', 'cardifa'),
            'manage_options',
            'cardifa_main_menu',
            [$this, 'settings_page'],
            $icon,
            21
        );

        add_submenu_page(
            'cardifa_main_menu',
            __('افزودن کاردیفا جدید', 'cardifa'),
            __('افزودن کاردیفا جدید', 'cardifa'),
            'manage_options',
            'post-new.php?post_type=cardifa'
        );

        add_submenu_page(
            'cardifa_main_menu',
            __('دیدگاه‌های کاردیفا‌ها', 'cardifa'),
            __('دیدگاه‌های کاردیفا‌ها', 'cardifa'),
            'manage_options',
            'edit-comments.php?comment_type=cardifa'
        );

        add_submenu_page(
            'cardifa_main_menu',
            __('تنظیمات کاردیفا', 'cardifa'),
            __('تنظیمات', 'cardifa'),
            'manage_options',
            'cardifa_settings',
            [$this, 'settings_page']
        );
    }

    public function enqueue_admin_assets()
    {
        wp_enqueue_style(
            'cardifa-admin',
            CARDIFA_URL . 'Assets/Admin/Css/admin.css',
            [],
            CARDIFA_VERSION
        );

        wp_enqueue_script(
            'cardifa-settings-js',
            CARDIFA_URL . 'Assets/Admin/Js/settings.js',
            ['jquery'],
            CARDIFA_VERSION,
            true
        );
    }

    public function settings_page()
    {
        Class_Settings::render();
    }
}
