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

namespace Cardifa\Bootstrap;

use Cardifa\Services\AssetManager;
use Elementor\Plugin as Elementor;

defined('ABSPATH') || exit;

class Elementor_Bootstrap
{
    /**
     * ثبت هوک‌های المنتور
     *
     * @since 1.0.0
     */
    public static function register(): void
    {
        // ابتدا وقتی المنتور فعال شد دسته‌بندی خودمون رو اضافه می‌کنیم
        add_action('elementor/init', [__CLASS__, 'init_category']);

        // بعد از بارگذاری ویجت‌ها، ویجت‌های خودمون رو register می‌کنیم
        add_action('elementor/widgets/widgets_registered', [__CLASS__, 'register_widgets'], 20);

        // enqueue CSS/JS ادیتور فقط در ادیتور CPT cardifa
        add_action('elementor/editor/before_enqueue_scripts', [__CLASS__, 'enqueue_editor_assets']);
    }

    /**
     * ایجاد دسته‌بندی سفارشی المنتور
     *
     * @since 1.0.0
     */
    public static function init_category(): void
    {
        if (null !== Elementor::instance()->elements_manager) {
            Elementor::instance()->elements_manager->add_category(
                'cardifa',
                ['title' => __('Cardifa', 'cardifa'), 'icon' => 'fa fa-id-card']
            );
        }
    }

    /**
     * لود و ثبت ویجت‌های Cardifa
     *
     * @since 1.0.0
     */
    public static function register_widgets(): void
    {
        foreach (glob(CARDIFA_PATH . 'Src/Elementor/Widgets/*.php') as $file) {
            require_once $file;
        }
        foreach (get_declared_classes() as $class) {
            if (0 === strpos($class, 'Cardifa\\Elementor\\Widgets\\')) {
                $widget = new $class();
                Elementor::instance()->widgets_manager->register_widget_type($widget);
            }
        }
    }

    /**
     * enqueue استایل و اسکریپت ادیتور المنتور
     *
     * @since 1.0.0
     */
    public static function enqueue_editor_assets(): void
    {
        if ('cardifa' === get_post_type()) {
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
    }
}
