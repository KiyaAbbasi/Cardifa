<?php
/**
 * File: LazyLoadTrait.php
 * Path: src/Elementor/Traits/
 * Description:
 *   مدیریت لودینگ تنبل شامل:
 *   • فعال‌سازی Lazy Load برای منابع.
 *   • تنظیمات واکنش‌گرا.
 *   • پشتیبانی از مرورگرهای مدرن.
 * Author: Kiya Holding
 */

namespace Cardifa\Elementor\Traits;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // جلوگیری از دسترسی مستقیم

trait LazyLoadTrait {

    /**
     * ثبت تنظیمات لودینگ تنبل
     *
     * @param string $id شناسه کنترل
     */
    protected function register_lazyload_controls(string $id = 'lazyload') {
        // فعال‌سازی لودینگ
        $this->add_control(
            $id,
            [
                'label' => __('Enable Lazy Load', 'cardifa'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'cardifa'),
                'label_off' => __('No', 'cardifa'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );
    }

    /**
     * تابعی برای اعمال تنظیمات Lazy Load
     *
     * @param array $settings تنظیمات ویجت
     */
    protected function apply_lazyload_settings(array $settings) {
        if (isset($settings['lazyload']) && 'yes' === $settings['lazyload']) {
            // اعمال تنظیمات لودینگ تنبل
            add_filter('wp_lazy_loading_enabled', '__return_true');
        }
    }
}
