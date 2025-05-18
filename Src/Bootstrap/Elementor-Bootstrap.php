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

use Elementor\Plugin as ElementorPlugin;

defined('ABSPATH') || exit;

class Elementor_Bootstrap
{
    public static function register(): void
    {
        // 1) enqueue CSS/JS ادیتور
        add_action('elementor/editor/before_enqueue_styles',  [__CLASS__, 'enqueue_editor_styles']);
        add_action('elementor/editor/after_enqueue_scripts', [__CLASS__, 'enqueue_editor_scripts']);

        // 2) ثبت دسته‌بندی ویجت‌ها
        add_action('elementor/elements/categories_registered', [__CLASS__, 'register_category']);

        // 3) ثبت همهٔ ویجت‌ها
        add_action('elementor/widgets/widgets_registered',   [__CLASS__, 'register_widgets']);
    }

    public static function enqueue_editor_styles(): void
    {
        wp_enqueue_style(
            'cardifa-elementor-editor',
            CARDIFA_URL . 'Assets/Elementor/Css/Editor.css',
            [],
            CARDIFA_VERSION
        );
    }

    public static function enqueue_editor_scripts(): void
    {
        wp_enqueue_script(
            'cardifa-elementor-editor',
            CARDIFA_URL . 'Assets/Elementor/Js/Editor.js',
            ['jquery'],
            CARDIFA_VERSION,
            true
        );
    }

    public static function register_category( $elements_manager ): void
    {
        $elements_manager->add_category(
            'cardifa',
            [
                'title' => __('کاردیفا', 'cardifa'),
                'icon'  => 'fa fa-id-card',
            ]
        );
    }

    public static function register_widgets(): void
    {
        $widgets_files = glob( CARDIFA_PATH . 'Src/Elementor/Widgets/*.php' );
        foreach ( $widgets_files as $file ) {
            require_once $file;
            $class = 'Cardifa\\Elementor\\Widgets\\' . pathinfo( $file, PATHINFO_FILENAME );
            if ( class_exists( $class ) ) {
                ElementorPlugin::instance()
                    ->widgets_manager
                    ->register_widget_type( new $class() );
            }
        }
    }
}
