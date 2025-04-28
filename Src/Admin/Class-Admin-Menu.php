<?php
/**
 * File:        Class-Admin-Menu.php
 * Description: تعریف منوی اصلی «کاردیفا» و زیرمنوها
 * Since:       1.0.0
 * Author:      Kiya Holding
 */

namespace Cardifa\Admin;

defined('ABSPATH') || exit;

use Cardifa\Admin\Class_Settings;

class Class_Admin_Menu
{
    /**
     * Class_Admin_Menu constructor.
     *
     * @since 1.0.0
     */
    public function __construct()
    {
        add_action('admin_menu',          [$this, 'add_admin_menu']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_assets']);
    }

    /**
     * افزودن آیتم منو و زیرمنوها
     *
     * @since 1.0.0
     */
    public function add_admin_menu(): void
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
            __('تنظیمات', 'cardifa'),
            __('تنظیمات', 'cardifa'),
            'manage_options',
            'cardifa-settings',
            [Class_Settings::class, 'render']
        );
    }

    /**
     * enqueue اسکریپت و استایل ادمین
     *
     * @since 1.0.0
     */
    public function enqueue_admin_assets(): void
    {
        wp_enqueue_style('cardifa-admin', CARDIFA_URL . 'Assets/Admin/Css/Admin.css', [], CARDIFA_VERSION);
        wp_enqueue_script('cardifa-admin-settings', CARDIFA_URL . 'Assets/Admin/Js/Settings.js', ['jquery'], CARDIFA_VERSION, true);
    }

    /**
     * رندر صفحه داشبورد (مثلاً redirect یا خلاصه)
     *
     * @since 1.0.0
     */
    public function render_dashboard_page(): void
    {
        // TODO: کد نمایش داشبورد اینجا
        echo '<div class="wrap"><h1>' . esc_html__('Dashboard کاردیفا', 'cardifa') . '</h1></div>';
    }
}
