<?php
/**
 * File Name:       Icons.php
 * Description:     مدیریت آیکون‌های اختصاصی کاردیفا در المنتور
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
 * کلاس مدیریت آیکون‌ها
 *
 * @since      1.0.0
 * @package    Cardifa\Elementor\Core
 */
class Icons {
    /**
     * سازنده کلاس
     *
     * @since 1.0.0
     */
    public function __construct() {
        add_filter('elementor/icons_manager/native', [$this, 'register_cardifa_icons']);
        add_action('elementor/editor/after_enqueue_scripts', [$this, 'enqueue_editor_icons']);
        add_action('elementor/frontend/after_enqueue_styles', [$this, 'enqueue_frontend_icons']);
    }

    /**
     * ثبت آیکون‌های کاردیفا
     *
     * @param array $icons آیکون‌های موجود
     * @return array
     * @since 1.0.0
     */
    public function register_cardifa_icons($icons) {
        $cardifa_icons = [
            'cardifa-icon-1' => __('آیکون 1', 'cardifa'),
            'cardifa-icon-2' => __('آیکون 2', 'cardifa'),
            'cardifa-icon-3' => __('آیکون 3', 'cardifa'),
            // سایر آیکون‌ها
        ];

        return array_merge($icons, [
            'cardifa-icons' => [
                'name'          => 'cardifa-icons',
                'label'         => __('آیکون‌های کاردیفا', 'cardifa'),
                'prefix'        => 'cardifa-',
                'displayPrefix' => 'ci',
                'labelIcon'     => 'cardifa-icon-1',
                'icons'         => $cardifa_icons,
                'ver'           => CARDIFA_VERSION,
            ]
        ]);
    }

    /**
     * افزودن فایل‌های آیکون به ویرایشگر
     *
     * @since 1.0.0
     */
    public function enqueue_editor_icons() {
        wp_enqueue_style(
            'cardifa-icons',
            CARDIFA_URL . 'assets/css/icons.css',
            [],
            CARDIFA_VERSION
        );
    }

    /**
     * افزودن فایل‌های آیکون به فرانت‌اند
     *
     * @since 1.0.0
     */
    public function enqueue_frontend_icons() {
        wp_enqueue_style(
            'cardifa-icons',
            CARDIFA_URL . 'assets/css/icons.css',
            [],
            CARDIFA_VERSION
        );
    }
}
