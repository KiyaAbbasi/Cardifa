<?php
/**
 * File Name:       Public_Bootstrap.php
 * Description:     مدیریت راه‌اندازی و پیکربندی بخش عمومی سایت کاردیفا
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
 * کلاس راه‌اندازی بخش عمومی کاردیفا
 *
 * @since      1.0.0
 * @package    Cardifa\Bootstrap
 */
class Public_Bootstrap
{
    /**
     * @var HookManager
     */
    private $hook_manager;

    /**
     * @var AssetManager
     */
    private $asset_manager;

    /**
     * راه‌اندازی عمومی
     *
     * @since 1.0.0
     */
    
    public function register()
    {
        $this->hook_manager = new \Cardifa\Src\Services\HookManager();
        $this->asset_manager = new \Cardifa\Src\Services\AssetManager();

        $this->init_hooks();
        $this->register_shortcodes();
    }
    
    /**
     * مقداردهی اولیه هوک‌ها
     *
     * @since 1.0.0
     */
    private function init_hooks()
    {
        $this->hook_manager->add_action('wp_enqueue_scripts', [$this->asset_manager, 'load_assets']);
        $this->hook_manager->add_filter('body_class', [$this, 'add_body_classes']);
    }

    /**
     * ثبت شورتکدهای کاردیفا
     *
     * @since 1.0.0
     */
    private function register_shortcodes()
    {
        add_shortcode('cardifa_card', [$this, 'render_card_shortcode']);
        add_shortcode('cardifa_profile', [$this, 'render_profile_shortcode']);
    }

    /**
     * اضافه کردن کلاس به body tag
     *
     * @param array $classes
     * @return array
     */
    public function add_body_classes($classes)
    {
        $classes[] = 'cardifa-active';
        return $classes;
    }

    /**
     * رندر کردن شورتکد کارت
     *
     * @param array $atts
     * @return string
     */
    public function render_card_shortcode($atts)
    {
        // TODO: اینجا خروجی HTML کارت ساخته میشه
        return '<div class="cardifa-card">' . esc_html__('Cardifa Card Placeholder', 'cardifa') . '</div>';
    }

    /**
     * رندر کردن شورتکد پروفایل
     *
     * @param array $atts
     * @return string
     */
    public function render_profile_shortcode($atts)
    {
        // TODO: اینجا خروجی HTML پروفایل ساخته میشه
        return '<div class="cardifa-profile">' . esc_html__('Cardifa Profile Placeholder', 'cardifa') . '</div>';
    }
}
