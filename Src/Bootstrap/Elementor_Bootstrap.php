<?php
/**
 * File Name:       Elementor_Bootstrap.php
 * Description:     مدیریت راه‌اندازی و پیکربندی المنتور در افزونه کاردیفا
 * Since:           1.0.0
 * Last Modified:   2025-04-26
 * Author:          Kiya Holding
 * Author URI:      https://kiyaholding.com
 * License:         GPLv3 or later
 * License URI:     https://www.gnu.org/licenses/gpl-3.0.html
 * 
 * @package         Cardifa\Bootstrap
 */

namespace Cardifa\Src\Bootstrap;

use Cardifa\Src\Services\HookManager;
use Cardifa\Src\Services\AssetManager;

defined('ABSPATH') || exit;

/**
 * کلاس راه‌اندازی المنتور
 *
 * @since 1.0.0
 * @package Cardifa\Bootstrap
 */
class Elementor_Bootstrap
{
    /**
     * @var HookManager
     */
    private $hook_manager;

    /**
     * ثبت المنتور
     *
     * @since 1.0.0
     */
    public function register()
    {
        if (!did_action('elementor/loaded')) {
            add_action('admin_notices', [$this, 'show_elementor_required_notice']);
            return;
        }

        $this->hook_manager = new HookManager();

        $this->init_hooks();
        $this->load_dependencies();
    }

    /**
     * راه‌اندازی هوک‌های المنتور
     *
     * @since 1.0.0
     */
    private function init_hooks()
    {
        $this->hook_manager->add_action('elementor/elements/categories_registered', [$this, 'register_widget_category']);
        $this->hook_manager->add_action('elementor/widgets/register', [$this, 'register_widgets']);
    }

    /**
     * بارگذاری وابستگی‌های المنتور
     *
     * @since 1.0.0
     */
    private function load_dependencies()
    {
        require_once CARDIFA_PATH . 'Src/Elementor/widgets-loader.php';
    }

    /**
     * ثبت دسته‌بندی ویجت‌های کاردیفا
     *
     * @param \Elementor\Elements_Manager $elements_manager
     * @since 1.0.0
     */
    public function register_widget_category($elements_manager)
    {
        $elements_manager->add_category('cardifa', [
            'title' => __('کاردیفا', 'cardifa'),
            'icon'  => 'fa fa-id-card',
        ]);
    }

    /**
     * ثبت ویجت‌های کاردیفا
     *
     * @param \Elementor\Widgets_Manager $widgets_manager
     * @since 1.0.0
     */
    public function register_widgets($widgets_manager)
    {
        // TODO: ثبت ویجت‌های سفارشی در صورت نیاز
    }

    /**
     * نمایش پیام نیاز به المنتور
     *
     * @since 1.0.0
     */
    public function show_elementor_required_notice()
    {
        echo '<div class="notice notice-warning is-dismissible"><p>';
        echo esc_html__('کاردیفا نیاز به نصب و فعال‌سازی افزونه المنتور دارد.', 'cardifa');
        echo '</p></div>';
    }
}
