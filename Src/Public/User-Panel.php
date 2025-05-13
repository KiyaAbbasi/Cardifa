<?php
/**
 * File Name:       User_Panel.php
 * Description:     مدیریت پنل کاربری در بخش عمومی سایت
 * Since:           1.0.0
 * Last Modified:   2025-04-24 14:08:19
 * Author:          KiyaAbbasi
 * Author URI:      https://kiyaholding.com
 * License:         GPLv3 or later
 * License URI:     https://www.gnu.org/licenses/gpl-3.0.html
 * 
 * @package         Cardifa\Public
 */

namespace Cardifa\Public;

use Cardifa\Core\Services\HookManager;

defined('ABSPATH') || exit;

/**
 * کلاس مدیریت پنل کاربری
 *
 * @since      1.0.0
 * @package    Cardifa\Public
 * @author     KiyaAbbasi
 */
class User_Panel {
    /**
     * @var HookManager نمونه کلاس مدیریت هوک‌ها
     */
    private $hook_manager;

    /**
     * سازنده کلاس
     *
     * @param HookManager $hook_manager نمونه کلاس مدیریت هوک‌ها
     * @since 1.0.0
     */
    public function __construct(HookManager $hook_manager) {
        $this->hook_manager = $hook_manager;
        $this->init_hooks();
    }

    /**
     * راه‌اندازی هوک‌ها
     *
     * @since 1.0.0
     */
    private function init_hooks() {
        $this->hook_manager->add_action('init', [$this, 'register_endpoints']);
        $this->hook_manager->add_filter('query_vars', [$this, 'add_query_vars']);
        $this->hook_manager->add_action('template_redirect', [$this, 'handle_endpoints']);
    }

    /**
     * ثبت endpoint های پنل کاربری
     *
     * @since 1.0.0
     */
    public function register_endpoints() {
        add_rewrite_endpoint('cardifa-panel', EP_ROOT | EP_PAGES);
        add_rewrite_endpoint('cardifa-cards', EP_ROOT | EP_PAGES);
        add_rewrite_endpoint('cardifa-settings', EP_ROOT | EP_PAGES);
    }

    /**
     * اضافه کردن query var های مورد نیاز
     *
     * @param array $vars متغیرهای موجود
     * @return array
     * @since 1.0.0
     */
    public function add_query_vars($vars) {
        $vars[] = 'cardifa-panel';
        $vars[] = 'cardifa-cards';
        $vars[] = 'cardifa-settings';
        return $vars;
    }

    /**
     * مدیریت درخواست‌های endpoint ها
     *
     * @since 1.0.0
     */
    public function handle_endpoints() {
        if (get_query_var('cardifa-panel')) {
            $this->render_panel();
        }
        if (get_query_var('cardifa-cards')) {
            $this->render_cards_manager();
        }
        if (get_query_var('cardifa-settings')) {
            $this->render_user_settings();
        }
    }

    /**
     * رندر صفحه اصلی پنل
     *
     * @since 1.0.0
     */
    private function render_panel() {
        if (!is_user_logged_in()) {
            wp_redirect(wp_login_url());
            exit;
        }
        include CARDIFA_DIR . 'templates/user-panel/dashboard.php';
        exit;
    }

    /**
     * رندر مدیریت کارت‌ها
     *
     * @since 1.0.0
     */
    private function render_cards_manager() {
        if (!is_user_logged_in()) {
            wp_redirect(wp_login_url());
            exit;
        }
        include CARDIFA_DIR . 'templates/user-panel/cards.php';
        exit;
    }

    /**
     * رندر تنظیمات کاربر
     *
     * @since 1.0.0
     */
    private function render_user_settings() {
        if (!is_user_logged_in()) {
            wp_redirect(wp_login_url());
            exit;
        }
        include CARDIFA_DIR . 'templates/user-panel/settings.php';
        exit;
    }
}
