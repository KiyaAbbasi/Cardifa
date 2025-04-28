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
 * @package         Cardifa\Bootstrap
 */

namespace Cardifa\Bootstrap; // ← اصلاح شد

use Cardifa\Services\AssetManager; // ← اطمینان از namespace صحیح

defined('ABSPATH') || exit;

class Admin_Bootstrap
{
    /**
     * ثبت هوک‌های ادمین
     *
     * @since 1.0.0
     */
    public static function register(): void
    {
        add_action('admin_menu',            [__CLASS__, 'add_admin_menus']);
        add_action('admin_enqueue_scripts', [__CLASS__, 'enqueue_admin_assets']);
    }

    /**
     * افزودن منو و زیرمنوها
     *
     * @since 1.0.0
     */
    public static function add_admin_menus(): void
    {
        add_menu_page(
            __('کاردیفا', 'cardifa'),
            __('کاردیفا', 'cardifa'),
            'manage_options',
            'cardifa',
            [__CLASS__, 'render_settings_page'],
            'dashicons-id-alt',
            25
        );
    }

    /**
     * رندر صفحه تنظیمات
     *
     * @since 1.0.0
     */
    public static function render_settings_page(): void
    {
        require CARDIFA_PATH . 'Templates/Admin/Settings-Page.php';
    }

    /**
     * enqueue استایل و اسکریپت در پنل ادمین
     *
     * @since 1.0.0
     */
    public static function enqueue_admin_assets(): void
    {
        $am = new AssetManager();
        $am->load_assets('admin');
    }
}
