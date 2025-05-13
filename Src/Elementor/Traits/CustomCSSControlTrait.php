<?php
/**
 * File: CustomCSSControlTrait.php
 * Path: src/Elementor/Traits/
 * Description:
 *   مدیریت کنترل‌های CSS سفارشی شامل:
 *   - افزودن CSS دلخواه
 *   - پیش‌نمایش استایل‌ها
 *   - پشتیبانی از متغیرهای داینامیک
 * Author: Kiya Holding
 */

namespace Cardifa\Elementor\Traits;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // جلوگیری از دسترسی مستقیم

trait CustomCSSControlTrait {

    /**
     * ثبت تنظیمات CSS سفارشی
     *
     * @param string $id شناسه کنترل
     */
    protected function register_custom_css_controls(string $id = 'custom_css') {
        // افزودن فیلد CSS سفارشی
        $this->add_control(
            "{$id}_enabled",
            [
                'label'        => __( 'فعال‌سازی CSS سفارشی', 'cardifa' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'فعال', 'cardifa' ),
                'label_off'    => __( 'غیرفعال', 'cardifa' ),
                'return_value' => 'yes',
                'default'      => 'no',
            ]
        );

        $this->add_control(
            "{$id}_code",
            [
                'label'       => __( 'CSS سفارشی', 'cardifa' ),
                'type'        => Controls_Manager::CODE,
                'language'    => 'css',
                'default'     => '',
                'description' => __( 'CSS دلخواه خود را اینجا وارد کنید. از {{WRAPPER}} برای هدف‌گیری المان استفاده کنید.', 'cardifa' ),
                'condition'   => [
                    "{$id}_enabled" => 'yes',
                ],
            ]
        );

        // پیش‌نمایش زنده استایل‌ها
        $this->add_control(
            "{$id}_preview",
            [
                'label'        => __( 'پیش‌نمایش زنده', 'cardifa' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'فعال', 'cardifa' ),
                'label_off'    => __( 'غیرفعال', 'cardifa' ),
                'return_value' => 'yes',
                'default'      => 'yes',
                'description'  => __( 'فعال‌سازی پیش‌نمایش زنده برای CSS سفارشی.', 'cardifa' ),
            ]
        );
    }

    /**
     * اعمال CSS سفارشی
     *
     * @param string $id شناسه کنترل
     */
    protected function apply_custom_css(string $id = 'custom_css') {
        $custom_css = $this->get_settings("{$id}_code");

        if ( ! empty($custom_css) ) {
            echo '<style>';
            echo str_replace('{{WRAPPER}}', $this->get_unique_selector(), $custom_css);
            echo '</style>';
        }
    }
}
