<?php
/**
 * File: AccessibilityTrait.php
 * Path: src/Elementor/Traits/
 * Description:
 *   مدیریت دسترسی‌پذیری شامل:
 *   - افزودن ویژگی‌های ARIA
 *   - مدیریت تگ‌های دسترسی‌پذیری
 * Author: Kiya Holding
 */

namespace Cardifa\Elementor\Traits;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // جلوگیری از دسترسی مستقیم

trait AccessibilityTrait {

    /**
     * ثبت تنظیمات دسترسی‌پذیری
     *
     * @param string $id شناسه کنترل
     */
    protected function register_accessibility_controls(string $id = 'accessibility') {
        // افزودن کنترل برای توضیحات
        $this->add_control(
            "{$id}_aria_label",
            [
                'label'       => __( 'توضیح ARIA', 'cardifa' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => '',
                'description' => __( 'توضیحی که به منظور دسترسی‌پذیری برای این عنصر استفاده می‌شود.', 'cardifa' ),
                'label_block' => true,
            ]
        );

        // افزودن نقش (Role)
        $this->add_control(
            "{$id}_role",
            [
                'label'   => __( 'نقش (Role)', 'cardifa' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'button'    => __( 'دکمه', 'cardifa' ),
                    'link'      => __( 'لینک', 'cardifa' ),
                    'heading'   => __( 'عنوان (Heading)', 'cardifa' ),
                    'banner'    => __( 'بنر', 'cardifa' ),
                    'navigation'=> __( 'ناوبری', 'cardifa' ),
                    'none'      => __( 'بدون نقش', 'cardifa' ),
                ],
                'default' => 'none',
            ]
        );

        // افزودن tabindex
        $this->add_control(
            "{$id}_tabindex",
            [
                'label'       => __( 'Tab Index', 'cardifa' ),
                'type'        => Controls_Manager::NUMBER,
                'default'     => '',
                'description' => __( 'ترتیب فوکوس عنصر در هنگام استفاده از Tab.', 'cardifa' ),
            ]
        );
    }

    /**
     * اعمال ویژگی‌های دسترسی‌پذیری
     *
     * @param array $attributes ویژگی‌های دسترسی‌پذیری
     */
    protected function apply_accessibility_attributes(array $attributes = []) {
        foreach ($attributes as $key => $value) {
            if ( ! empty($value) ) {
                echo sprintf(' %s="%s"', esc_attr($key), esc_attr($value));
            }
        }
    }
}
