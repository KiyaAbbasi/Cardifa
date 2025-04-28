<?php
/**
 * File Name:       Admin_Bootstrap.php
 * Description:     مدیریت منوها و صفحات ادمین کاردیفا
 * Since:           1.0.0
 * Last Modified:   2025-04-26
 * Author:          Kiya Holding
 * Author URI:      https://kiyaholding.com
 * License:         GPLv3 or later
 * License URI:     https://www.gnu.org/licenses/gpl-3.0.html
 * 
 * @package         Cardifa\Src\Bootstrap
 */

namespace Cardifa\Src\Bootstrap;

defined('ABSPATH') || exit;

class Admin_Bootstrap
{
    public function register()
    {
        add_action('admin_menu', [$this, 'add_admin_menus']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_assets']);
    }

    public function add_admin_menus()
    {
        add_menu_page(
            __('کاردیفا', 'cardifa'),
            __('کاردیفا', 'cardifa'),
            'manage_options',
            'cardifa',
            [$this, 'render_dashboard_page'],
            'dashicons-id-alt',
            25
        );

        add_submenu_page(
            'cardifa',
            __('پیشخوان', 'cardifa'),
            __('پیشخوان', 'cardifa'),
            'manage_options',
            'cardifa',
            [$this, 'render_dashboard_page']
        );

        add_submenu_page(
            'cardifa',
            __('تنظیمات عمومی', 'cardifa'),
            __('تنظیمات عمومی', 'cardifa'),
            'manage_options',
            'cardifa-settings-general',
            [$this, 'render_general_settings_page']
        );

        add_submenu_page(
            'cardifa',
            __('تنظیمات پیامکی', 'cardifa'),
            __('تنظیمات پیامکی', 'cardifa'),
            'manage_options',
            'cardifa-settings-sms',
            [$this, 'render_sms_settings_page']
        );

        add_submenu_page(
            'cardifa',
            __('پلن‌های اشتراکی', 'cardifa'),
            __('پلن‌های اشتراکی', 'cardifa'),
            'manage_options',
            'cardifa-plans',
            [$this, 'render_plans_page']
        );

        add_submenu_page(
            'cardifa',
            __('تنظیمات استایل', 'cardifa'),
            __('تنظیمات استایل', 'cardifa'),
            'manage_options',
            'cardifa-style-settings',
            [$this, 'render_style_settings_page']
        );
    }

    public function enqueue_admin_assets($hook)
    {
        if (strpos($hook, 'cardifa') === false) {
            return;
        }

        wp_enqueue_style(
            'cardifa-admin',
            CARDIFA_URL . 'Assets/Admin/Css/Admin.css',
            [],
            CARDIFA_VERSION
        );

        wp_enqueue_script(
            'cardifa-admin',
            CARDIFA_URL . 'Assets/Admin/Js/Settings.js',
            ['jquery'],
            CARDIFA_VERSION,
            true
        );
    }

    public function render_dashboard_page()
    {
        echo '<div class="wrap cardifa-admin"><h1>' . __('پیشخوان کاردیفا', 'cardifa') . '</h1></div>';
    }

    public function render_general_settings_page()
    {
        echo '<div class="wrap cardifa-admin"><h1>' . __('تنظیمات عمومی کاردیفا', 'cardifa') . '</h1></div>';
    }

    public function render_sms_settings_page()
    {
        echo '<div class="wrap cardifa-admin"><h1>' . __('تنظیمات پیامکی کاردیفا', 'cardifa') . '</h1></div>';
    }

    public function render_plans_page()
    {
        echo '<div class="wrap cardifa-admin"><h1>' . __('مدیریت پلن‌های اشتراکی کاردیفا', 'cardifa') . '</h1></div>';
    }

    public function render_style_settings_page()
    {
        echo '<div class="wrap cardifa-admin"><h1>' . __('تنظیمات استایل کاردیفا', 'cardifa') . '</h1></div>';
    }
}
