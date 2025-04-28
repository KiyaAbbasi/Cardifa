<?php
/**
 * File Name:       Application.php
 * Description:     کلاس اصلی برنامه کاردیفا - مدیریت بارگذاری بخش‌های مختلف افزونه
 * Since:           1.0.0
 * Last Modified:   2025-04-26
 * Author:          Kiya Holding
 * Author URI:      https://kiyaholding.com
 * License:         GPLv3 or later
 * License URI:     https://www.gnu.org/licenses/gpl-3.0.html
 * 
 * @package         Cardifa\Core
 */

namespace Cardifa\Core;

use Cardifa\Src\Admin\Admin_Loader;
use Cardifa\Src\Bootstrap\Admin_Bootstrap;
use Cardifa\Src\Bootstrap\Public_Bootstrap;
use Cardifa\Src\Bootstrap\Elementor_Bootstrap;
use Cardifa\Src\Services\HookManager;
use Cardifa\Src\Services\AssetManager;


defined('ABSPATH') || exit;

/**
 * کلاس اصلی برنامه
 *
 * @since 1.0.0
 * @package Cardifa\Core
 */
final class Application
{
    /**
     * نمونه Singleton کلاس
     *
     * @var Application|null
     */
    private static $instance = null;

    /**
     * Application constructor.
     *
     * @since 1.0.0
     */
    private function __construct()
    {
        $this->define_constants();

        add_action('plugins_loaded', [$this, 'init']);
        add_filter('plugin_action_links_' . plugin_basename(CARDIFA_FILE), [$this, 'plugin_action_links']);
    }

    /**
     * دریافت نمونه Singleton
     *
     * @return Application
     * @since 1.0.0
     */
    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * تعریف ثابت‌های پروژه
     *
     * @since 1.0.0
     */
    private function define_constants()
    {
        if (!defined('CARDIFA_VERSION')) {
            define('CARDIFA_VERSION', '1.0.0');
        }
        if (!defined('CARDIFA_PATH')) {
            define('CARDIFA_PATH', plugin_dir_path(__DIR__, 2)); // 👈 مسیر درست تا Cardifa/
        }
        if (!defined('CARDIFA_URL')) {
            define('CARDIFA_URL', plugin_dir_url(__DIR__, 2)); // 👈 مسیر درست تا Cardifa/
        }
        if (!defined('CARDIFA_FILE')) {
            define('CARDIFA_FILE', CARDIFA_PATH . 'Cardifa.php');
        }
    }

    /**
     * راه‌اندازی بخش‌های مختلف افزونه
     *
     * @since 1.0.0
     */
    public function init()
    {
        // بارگذاری ترجمه‌ها
        load_plugin_textdomain('cardifa', false, dirname(plugin_basename(CARDIFA_FILE)) . '/lang');

        // چک فعال بودن المنتور
        if (!$this->check_elementor()) {
            return;
        }

        // راه‌اندازی بخش‌های اصلی
        (new Admin_Bootstrap())->register();
        (new Admin_Loader()); // 👈 اضافه میشه
        (new Public_Bootstrap())->register();
        (new Elementor_Bootstrap())->register();



        // بارگذاری فایل‌های اصلی شامل CPT ها، تکسونومی و ...
        $this->load_includes();
    }

    /**
     * بارگذاری فایل‌های شامل
     *
     * @since 1.0.0
     */
    private function load_includes()
    {
        $includes = [
            'Includes/Functions.php',
            'Includes/Activation.php',
            'Includes/Deactivation.php',
            'Includes/Custom-Post-Types.php',
            'Includes/Taxonomies.php',
            'Includes/Meta-Boxes.php',
            'Includes/Roles-Capabilities.php',
            'Src/Services/HookManager.php', // ✅ مسیر درست
            'Src/Services/AssetManager.php', // ✅ مسیر درست
            'Src/Admin/Class-Admin-Menu.php',
            'Src/Admin/Class-Settings.php',
        ];
    
        foreach ($includes as $file) {
            $path = CARDIFA_PATH . $file;
            if (file_exists($path)) {
                require_once $path;
            }
        }
    }

    /**
     * بارگذاری استایل‌های مدیریت
     *
     * @since 1.0.0
     */
    public function enqueue_admin_assets()
    {
        wp_enqueue_style(
            'cardifa-admin',
            CARDIFA_URL . 'Assets/Admin/Css/Admin.css',
            [],
            CARDIFA_VERSION
        );
    }

    /**
     * اضافه کردن لینک سریع تنظیمات در لیست افزونه‌ها
     *
     * @param array $links
     * @return array
     * @since 1.0.0
     */
    public function plugin_action_links($links)
    {
        $custom_links = [
            '<a href="' . admin_url('admin.php?page=cardifa-settings') . '">' . __('تنظیمات', 'cardifa') . '</a>',
        ];
        return array_merge($custom_links, $links);
    }

    /**
     * چک کردن فعال بودن المنتور
     *
     * @return bool
     * @since 1.0.0
     */
    private function check_elementor()
    {
        if (!did_action('elementor/loaded')) {
            add_action('admin_notices', function () {
                echo '<div class="notice notice-warning is-dismissible"><p>';
                echo esc_html__('کاردیفا نیاز به نصب و فعال‌سازی افزونه المنتور دارد.', 'cardifa');
                echo '</p></div>';
            });
            return false;
        }
        return true;
    }
}
