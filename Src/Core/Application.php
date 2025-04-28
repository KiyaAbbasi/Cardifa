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

use Cardifa\Admin\Admin_Loader;
use Cardifa\Bootstrap\Admin_Bootstrap;
use Cardifa\Bootstrap\Public_Bootstrap;
use Cardifa\Bootstrap\Elementor_Bootstrap;

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
        // ─── تعریف ثابت‌های اصلی ─────────────────────────
        if (! defined('CARDIFA_VERSION')) {
            define('CARDIFA_VERSION', '3.0.0');
        }
        if (! defined('CARDIFA_FILE')) {
            define('CARDIFA_FILE', CARDIFA_PATH . 'Cardifa.php');
        }
        if (! defined('CARDIFA_PATH')) {
            define('CARDIFA_PATH', plugin_dir_path(CARDIFA_FILE));
        }
        if (! defined('CARDIFA_URL')) {
            define('CARDIFA_URL', plugin_dir_url(CARDIFA_FILE));
        }

        // ─── بارگذاری ترجمه‌ها ────────────────────────────
        add_action('plugins_loaded', [$this, 'loadTextDomain']);

        // ─── لینک تنظیمات در لیست پلاگین‌ها ───────────────
        add_filter('plugin_action_links_' . plugin_basename(CARDIFA_FILE), [$this, 'plugin_action_links']);

        // ─── راه‌اندازی افزونه ───────────────────────────
        add_action('init', [$this, 'init'], 1);
    }

    /**
     * دریافت نمونه Singleton
     *
     * @return Application
     * @since 1.0.0
     */
    public static function getInstance(): Application
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * بارگذاری فایل زبان
     *
     * @since 1.0.0
     */
    public function loadTextDomain(): void
    {
        load_plugin_textdomain(
            'cardifa',
            false,
            dirname(plugin_basename(CARDIFA_FILE)) . '/lang'
        );
    }

    /**
     * ثبت لینک تنظیمات در لیست پلاگین‌ها
     *
     * @param array $links
     * @return array
     * @since 1.0.0
     */
    public function plugin_action_links(array $links): array
    {
        $settings_link = '<a href="' . admin_url('admin.php?page=cardifa-settings') . '">' 
                       . __('تنظیمات', 'cardifa') . '</a>';
        array_unshift($links, $settings_link);
        return $links;
    }

    /**
     * راه‌اندازی بخش‌های مختلف افزونه
     *
     * @since 1.0.0
     */
    public function init(): void
    {
        // بارگذاری ترجمه‌ها
        $this->loadTextDomain();

        // بررسی فعال بودن المنتور
        if (! $this->check_elementor()) {
            return;
        }

        // ─── بوت‌استرپ ادمین ─────────────────────────────
        (new Admin_Loader());                // لودر کلاس‌های ادمین
        Admin_Bootstrap::register();         // منوها و استایل/اسکریپت ادمین

        // ─── بوت‌استرپ عمومی ────────────────────────────
        Public_Bootstrap::register();        // شورتکد و Assets عمومی

        // ─── بوت‌استرپ المنتور ─────────────────────────
        if (defined('ELEMENTOR_VERSION')) {
            Elementor_Bootstrap::register();
        }

        // ─── بارگذاری فایل‌های شامل (CPT, Taxonomies, Roles…) ──
        $this->load_includes();
    }

    /**
     * بارگذاری فایل‌های شامل (CPT, Taxonomy, Meta Boxes, Roles)
     *
     * @since 1.0.0
     */
    private function load_includes(): void
    {
        $files = [
            'Includes/Functions.php',
            'Includes/Activation.php',
            'Includes/Deactivation.php',
            'Includes/Custom-Post-Types.php',
            'Includes/Taxonomies.php',
            'Includes/Meta-Boxes.php',
            'Includes/Roles-Capabilities.php',
        ];

        foreach ($files as $file) {
            $path = CARDIFA_PATH . $file;
            if (file_exists($path)) {
                require_once $path;
            }
        }
    }

    /**
     * چک کردن فعال بودن المنتور
     *
     * @return bool
     * @since 1.0.0
     */
    private function check_elementor(): bool
    {
        if (! did_action('elementor/loaded')) {
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
