<?php
/**
 * File: GlobalSettingsTrait.php
 * Path: src/Elementor/Traits/
 * Description:
 *   مدیریت تنظیمات سراسری شامل:
 *   - تایپوگرافی کامل
 *   - رنگ‌ها و شفافیت
 *   - فواصل (Padding & Margin)
 *   - خطوط (Borders)
 *   - سایه‌ها (Shadows)
 *   - تنظیمات واکنش‌گرا (Responsive Settings)
 *   - زمینه‌های پیشرفته (Background Settings)
 *   - انیمیشن‌های سراسری
 * Author: Kiya Holding
 */

namespace Cardifa\Elementor\Traits;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // جلوگیری از دسترسی مستقیم

trait GlobalSettingsTrait {

    /**
     * ثبت تنظیمات سراسری
     *
     * @param string $id شناسه کنترل
     */
    protected function register_global_settings_controls(string $id = 'global_settings') {
        // ========================
        // تایپوگرافی کامل
        // ========================
        $this->add_control(
            "{$id}_font_family",
            [
                'label'   => __( 'فونت', 'cardifa' ),
                'type'    => Controls_Manager::FONT,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}}' => 'font-family: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            "{$id}_font_size",
            [
                'label'      => __( 'اندازه فونت', 'cardifa' ),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 8,
                        'max' => 72,
                        'step' => 1,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}}' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            "{$id}_line_height",
            [
                'label'      => __( 'فاصله بین خطوط', 'cardifa' ),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'em' => [
                        'min' => 0.8,
                        'max' => 3,
                        'step' => 0.1,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}}' => 'line-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            "{$id}_letter_spacing",
            [
                'label'      => __( 'فاصله بین حروف', 'cardifa' ),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => -5,
                        'max' => 20,
                        'step' => 0.1,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}}' => 'letter-spacing: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            "{$id}_font_style",
            [
                'label'   => __( 'استایل فونت', 'cardifa' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'normal'  => __( 'عادی', 'cardifa' ),
                    'italic'  => __( 'ایتالیک', 'cardifa' ),
                    'oblique' => __( 'کج', 'cardifa' ),
                ],
                'default' => 'normal',
                'selectors' => [
                    '{{WRAPPER}}' => 'font-style: {{VALUE}};',
                ],
            ]
        );

        // ========================
        // رنگ‌ها و شفافیت
        // ========================
        $this->add_control(
            "{$id}_primary_color",
            [
                'label'     => __( 'رنگ اصلی', 'cardifa' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#000000',
                'selectors' => [
                    '{{WRAPPER}}' => '--primary-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            "{$id}_background_color",
            [
                'label'     => __( 'رنگ پس‌زمینه', 'cardifa' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#FFFFFF',
                'selectors' => [
                    '{{WRAPPER}}' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            "{$id}_opacity",
            [
                'label'      => __( 'شفافیت (Opacity)', 'cardifa' ),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 1,
                        'step' => 0.1,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}}' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        // ========================
        // فواصل (Padding & Margin)
        // ========================
        $this->add_responsive_control(
            "{$id}_padding",
            [
                'label'      => __( 'فاصله داخلی (Padding)', 'cardifa' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors'  => [
                    '{{WRAPPER}}' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            "{$id}_margin",
            [
                'label'      => __( 'فاصله خارجی (Margin)', 'cardifa' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors'  => [
                    '{{WRAPPER}}' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // ========================
        // خطوط (Borders)
        // ========================
        $this->add_group_control(
            "{$id}_border",
            [
                'label'    => __( 'خطوط (Borders)', 'cardifa' ),
                'type'     => Controls_Manager::BORDER,
                'selector' => '{{WRAPPER}}',
            ]
        );

        $this->add_control(
            "{$id}_border_radius",
            [
                'label'      => __( 'گوشه‌ها (Border Radius)', 'cardifa' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'selectors'  => [
                    '{{WRAPPER}}' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // ========================
        // سایه‌ها (Shadows)
        // ========================
        $this->add_group_control(
            "{$id}_box_shadow",
            [
                'label'    => __( 'سایه‌ها', 'cardifa' ),
                'type'     => Controls_Manager::BOX_SHADOW,
                'selector' => '{{WRAPPER}}',
            ]
        );

        // ========================
        // زمینه‌های پیشرفته
        // ========================
        $this->add_group_control(
            "{$id}_background",
            [
                'label'    => __( 'زمینه', 'cardifa' ),
                'type'     => Controls_Manager::BACKGROUND,
                'selector' => '{{WRAPPER}}',
            ]
        );

        // ========================
        // انیمیشن‌های سراسری
        // ========================
        $this->add_control(
            "{$id}_animation_duration",
            [
                'label'      => __( 'مدت زمان انیمیشن', 'cardifa' ),
                'type'       => Controls_Manager::NUMBER,
                'default'    => 500,
                'min'        => 100,
                'max'        => 5000,
                'step'       => 100,
                'selectors'  => [
                    '{{WRAPPER}}' => 'animation-duration: {{SIZE}}ms;',
                ],
            ]
        );
    }
}
