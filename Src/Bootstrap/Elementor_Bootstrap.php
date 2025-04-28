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

namespace Cardifa\Bootstrap; // ← اصلاح شد

use Cardifa\Services\AssetManager;
use Elementor\Plugin as Elementor;

defined('ABSPATH') || exit;

class Elementor_Bootstrap
{
    /**
     * ثبت هوک‌ها و categories المنتور
     *
     * @since 1.0.0
     */
    public static function register(): void
    {
        // دسته‌بندی اختصاصی
        Elementor::instance()->elements_manager->add_category(
            'cardifa',
            ['title' => __('Cardifa','cardifa'),'icon'=>'fa fa-id-card']
        );

        // لود خودکار ویجت‌ها
        foreach (glob(CARDIFA_PATH . 'Src/Elementor/Widgets/*.php') as $file) {
            require_once $file;
        }
        foreach (get_declared_classes() as $class) {
            if (strpos($class, 'Cardifa\\Elementor\\Widgets\\') === 0) {
                $widget = new $class();
                Elementor::instance()->widgets_manager->register_widget_type($widget);
            }
        }

        // enqueue CSS/JS ادیتور فقط در CPT cardifa
        add_action('elementor/editor/before_enqueue_scripts', function() {
            if (get_post_type() === 'cardifa') {
                wp_enqueue_style(
                    'cardifa-elementor-editor',
                    CARDIFA_URL . 'Assets/Elementor/Css/Editor.css',
                    [],
                    CARDIFA_VERSION
                );
                wp_enqueue_script(
                    'cardifa-elementor-editor',
                    CARDIFA_URL . 'Assets/Elementor/Js/Editor.js',
                    [],
                    CARDIFA_VERSION,
                    true
                );
            }
        });
    }
}
