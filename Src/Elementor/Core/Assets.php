<?php
/**
 * File Name:       Assets.php
 * Description:     مدیریت اسکریپت‌ها و استایل‌های المنتور کاردیفا
 * Since:           1.0.0
 * Last Modified:   2025-04-24 15:21:26
 * Author:          Kiya Holding
 * Author URI:      https://kiyaholding.com
 * License:         GPLv3 or later
 * License URI:     https://www.gnu.org/licenses/gpl-3.0.html
 * 
 * @package         Cardifa\Elementor\Core
 */

namespace Cardifa\Elementor\Core;

defined('ABSPATH') || exit;

/**
 * کلاس مدیریت فایل‌های استایل و اسکریپت
 *
 * @since      1.0.0
 * @package    Cardifa\Elementor\Core
 */
class Assets {
    /**
     * سازنده کلاس
     *
     * @since 1.0.0
     */
    public function __construct() {
        // اسکریپت‌های ویرایشگر
        add_action('elementor/editor/after_enqueue_scripts', [$this, 'enqueue_editor_scripts']);
        add_action('elementor/editor/after_enqueue_styles', [$this, 'enqueue_editor_styles']);

        // اسکریپت‌های فرانت‌اند
        add_action('elementor/frontend/after_enqueue_scripts', [$this, 'enqueue_frontend_scripts']);
        add_action('elementor/frontend/after_enqueue_styles', [$this, 'enqueue_frontend_styles']);
    }

    /**
     * افزودن اسکریپت‌های ویرایشگر
     *
     * @since 1.0.0
     */
    public function enqueue_editor_scripts() {
        wp_enqueue_script(
            'cardifa-editor',
            CARDIFA_URL . 'assets/js/elementor-editor.js',
            ['elementor-editor'],
            CARDIFA_VERSION,
            true
        );

        wp_localize_script('cardifa-editor', 'cardifaEditor', [
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce'   => wp_create_nonce('cardifa-editor'),
        ]);
    }

    /**
     * افزودن استایل‌های ویرایشگر
     *
     * @since 1.0.0
     */
    public function enqueue_editor_styles() {
        wp_enqueue_style(
            'cardifa-editor',
            CARDIFA_URL . 'assets/css/elementor-editor.css',
            [],
            CARDIFA_VERSION
        );
    }

    /**
     * افزودن اسکریپت‌های فرانت‌اند
     *
     * @since 1.0.0
     */
    public function enqueue_frontend_scripts() {
        wp_enqueue_script(
            'cardifa-frontend',
            CARDIFA_URL . 'assets/js/elementor-frontend.js',
            ['elementor-frontend'],
            CARDIFA_VERSION,
            true
        );
    }

    /**
     * افزودن استایل‌های فرانت‌اند
     *
     * @since 1.0.0
     */
    public function enqueue_frontend_styles() {
        wp_enqueue_style(
            'cardifa-frontend',
            CARDIFA_URL . 'assets/css/elementor-frontend.css',
            [],
            CARDIFA_VERSION
        );
    }
}
