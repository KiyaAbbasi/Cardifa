<?php
/**
 * File Name:       Application.php
 * Description:     کلاس اصلی برنامه کاردیفا - مدیریت بارگذاری بخش‌های مختلف افزونه
 * Since:           1.0.0
 * Last Modified:   2025-05-13
 * Author:          Kiya Holding
 * Author URI:      https://kiyaholding.com
 * License:         GPLv3 or later
 * License URI:     https://www.gnu.org/licenses/gpl-3.0.html
 *
 * @package         Cardifa\Core
 */

namespace Cardifa\Core;

defined('ABSPATH') || exit;

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
            define('CARDIFA_FILE', __FILE__);
        }
        if (! defined('CARDIFA_PATH')) {
            define('CARDIFA_PATH', plugin_dir_path(__FILE__));
        }
        if (! defined('CARDIFA_URL')) {
            define('CARDIFA_URL', plugin_dir_url(__FILE__));
        }

        // ─── بارگذاری ترجمه‌ها ────────────────────────────
        add_action('plugins_loaded', array($this, 'loadTextDomain'));

        // ─── لینک تنظیمات در لیست پلاگین‌ها ───────────────
        add_filter('plugin_action_links_' . plugin_basename(CARDIFA_FILE), array($this, 'plugin_action_links'));

        // ─── اصلی‌ترین راه‌اندازی‌ها ─────────────────────
        add_action('init', array($this, 'init'), 1);
    }

    /**
     * دریافت نمونه Singleton
     *
     * @return Application
     * @since 1.0.0
     */
    public static function getInstance()
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
    public function loadTextDomain()
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
    public function plugin_action_links($links)
    {
        $settings_link = '<a href="' . admin_url('admin.php?page=cardifa-settings-general') . '">'
                       . __('تنظیمات', 'cardifa') . '</a>';
        array_unshift($links, $settings_link);
        return $links;
    }

    /**
     * راه‌اندازی بخش‌های مختلف افزونه
     *
     * @since 1.0.0
     */
    public function init()
    {
        // ─── 0) لود کلاس‌های بوت‌استرپ ─────────────────────
        require_once CARDIFA_PATH . 'Src/Bootstrap/Public-Bootstrap.php';
        require_once CARDIFA_PATH . 'Src/Bootstrap/Elementor-Bootstrap.php';

        // ─── 1) منوی ادمین و تنظیمات ─────────────────────
        if (is_admin()) {
            require_once CARDIFA_PATH . 'Src/Admin/Class-Admin-Menu.php';
            require_once CARDIFA_PATH . 'Src/Admin/Class-Settings.php';
            new \Cardifa\Admin\Class_Admin_Menu();
        }

        // ─── 2) لود فانکشن‌های عمومی ───────────────────────
        require_once CARDIFA_PATH . 'Includes/Functions.php';

        // ─── 3) بارگذاری منابع عمومی ─────────────────────
        \Cardifa\Core\GlobalAssets::init();

        // ─── 4) بارگذاری المنتور بوت‌استرپ ───────────────
        if (defined('ELEMENTOR_VERSION') && did_action('elementor/loaded')) {
            \Cardifa\Bootstrap\Elementor_Bootstrap::register();
        }

        // ─── 5) بارگذاری فایل‌های Includes ────────────────
        $includes = array(
            'Includes/Activation.php',
            'Includes/Deactivation.php',
            'Includes/CustomPostTypes.php',
            'Includes/Taxonomies.php',
            'Includes/TaxonomySettings.php',
            'Includes/MetaBoxes.php',
            'Includes/RolesCapabilities.php',
        );
        foreach ($includes as $file) {
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
    private function check_elementor()
    {
        if (! did_action('elementor/loaded')) {
            add_action('admin_notices', function () {
                echo '<div class="notice notice-warning is-dismissible"><p>'
                     . esc_html__('کاردیفا نیاز به نصب و فعال‌سازی افزونه المنتور دارد.', 'cardifa')
                     . '</p></div>';
            });
            return false;
        }
        return true;
    }
}
