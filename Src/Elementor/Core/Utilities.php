<?php
/**
 * File Name:       Utilities.php
 * Description:     توابع کمکی و تنظیمات المنتور کاردیفا
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
 * کلاس توابع کمکی
 *
 * @since      1.0.0
 * @package    Cardifa\Elementor\Core
 */
class Utilities {
    /**
     * سازنده کلاس
     *
     * @since 1.0.0
     */
    public function __construct() {
        // غیرفعال‌سازی Font Awesome
        add_action('elementor/frontend/after_register_styles', [$this, 'disable_font_awesome'], 20);
        
        // اضافه کردن فیلترهای کمکی
        add_filter('cardifa_elementor_widget_args', [$this, 'filter_widget_args'], 10, 2);
    }

    /**
     * غیرفعال‌سازی Font Awesome
     *
     * @since 1.0.0
     */
    public function disable_font_awesome() {
        foreach(['font-awesome', 'font-awesome-5-free', 'font-awesome-4-shim'] as $style) {
            wp_deregister_style($style);
            wp_dequeue_style($style);
        }
    }

    /**
     * فیلتر آرگومان‌های ویجت
     *
     * @param array  $args   آرگومان‌های ویجت
     * @param string $widget نام ویجت
     * @return array
     * @since 1.0.0
     */
    public function filter_widget_args($args, $widget) {
        // اعمال فیلترهای مورد نیاز
        return $args;
    }

    /**
     * تبدیل آرایه به تگ‌های HTML
     *
     * @param array $attributes آرایه ویژگی‌ها
     * @return string
     * @since 1.0.0
     */
    public static function array_to_attributes($attributes) {
        $html = [];
        
        foreach ($attributes as $key => $value) {
            if (is_bool($value)) {
                if ($value) {
                    $html[] = esc_attr($key);
                }
            } else {
                $html[] = sprintf('%s="%s"', esc_attr($key), esc_attr($value));
            }
        }
        
        return implode(' ', $html);
    }
}
