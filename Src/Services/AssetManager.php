<?php
/**
 * File Name:       AssetManager.php
 * Description:     مدیریت تمام asset های پلاگین (CSS, JS, Fonts)
 * Since:           1.0.0
 * Last Modified:   2025-04-24 14:02
 * Author:          Kiya Holding
 * Author URI:      https://kiyaholding.com
 * License:         GPLv3 or later
 * License URI:     https://www.gnu.org/licenses/gpl-3.0.html
 * 
 * @package         Cardifa\Core\Services
 */

namespace Cardifa\Src\Services;

defined('ABSPATH') || exit;

/**
 * کلاس مدیریت asset ها
 * این کلاس مسئول مدیریت تمام فایل‌های CSS، JS و فونت‌ها است
 *
 * @since      1.0.0
 * @package    Cardifa\Core\Services
 * @author     Kiya Holding
 */
class AssetManager {
    /**
     * @var string مسیر اصلی پوشه assets
     */
    private $assets_path;

    /**
     * @var string آدرس اصلی پوشه assets
     */
    private $assets_url;

    /**
     * سازنده کلاس
     * تنظیم مسیرهای اصلی و ثبت اکشن‌ها
     *
     * @since 1.0.0
     */
    public function __construct() {
        $this->assets_path = CARDIFA_PATH . 'assets/';
        $this->assets_url = CARDIFA_URL . 'assets/';

        // ثبت اکشن‌ها برای بخش عمومی و ادمین
        add_action('wp_enqueue_scripts', [$this, 'register_public_assets']);
        add_action('admin_enqueue_scripts', [$this, 'register_admin_assets']);
    }

    /**
     * ثبت asset های بخش عمومی
     *
     * @since 1.0.0
     */
    public function register_public_assets() {
        // استایل‌های عمومی
        wp_register_style(
            'cardifa-public',
            $this->assets_url . 'public/css/public.css',
            [],
            CARDIFA_VERSION
        );

        // اسکریپت‌های عمومی
        wp_register_script(
            'cardifa-public',
            $this->assets_url . 'public/js/public.js',
            ['jquery'],
            CARDIFA_VERSION,
            true
        );
    }

    /**
     * ثبت asset های بخش مدیریت
     *
     * @since 1.0.0
     */
    public function register_admin_assets() {
        // استایل‌های ادمین
        wp_register_style(
            'cardifa-admin',
            $this->assets_url . 'admin/css/admin.css',
            [],
            CARDIFA_VERSION
        );

        // اسکریپت‌های ادمین
        wp_register_script(
            'cardifa-admin-settings',
            $this->assets_url . 'admin/js/settings.js',
            ['jquery'],
            CARDIFA_VERSION,
            true
        );
    }

    /**
     * لود کردن asset های مورد نیاز
     *
     * @param string $context زمینه ('admin' یا 'public')
     * @since 1.0.0
     */
    public function load_assets($context = 'public') {
        if ($context === 'admin') {
            wp_enqueue_style('cardifa-admin');
            wp_enqueue_script('cardifa-admin-settings');
        } else {
            wp_enqueue_style('cardifa-public');
            wp_enqueue_script('cardifa-public');
        }
    }
}
