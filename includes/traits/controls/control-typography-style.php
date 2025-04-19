<?php
/**
 * 📁 control-typography-style.php
 * 🎯 استایل‌دهی کامل تایپوگرافی برای متن‌ها
 * 🛤 مسیر: includes/traits/controls/control-typography-style.php
 */

namespace Cardifa\Traits\Controls;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;

if (!defined('ABSPATH')) exit;

trait Control_Typography_Style {

    /**
     * 🧠 استایل تایپوگرافی + رنگ + سایه + فاصله برای متن
     * 
     * @param string $name    شناسه یکتا
     * @param string $selector سلکتور المنت مورد نظر (مثلاً: .cardifa-text)
     */
    protected function register_typography_style($name, $selector) {

        $this->start_controls_section(
            'section_typography_' . $name,
            [
                'label' => 'تایپوگرافی',
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        // 🔤 تایپوگرافی اصلی
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => $name . '_typography',
                'selector' => '{{WRAPPER}} ' . $selector,
            ]
        );

        // 🎨 رنگ متن
        $this->add_control(
            $name . '_color',
            [
                'label'     => 'رنگ متن',
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $selector => 'color: {{VALUE}}',
                ],
            ]
        );

        // 🌫 سایه متن
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'     => $name . '_text_shadow',
                'selector' => '{{WRAPPER}} ' . $selector,
            ]
        );

        // 📐 فاصله داخلی (Padding)
        $this->add_responsive_control(
            $name . '_padding',
            [
                'label'      => 'فاصله داخلی',
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} ' . $selector => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // 📏 فاصله خارجی (Margin)
        $this->add_responsive_control(
            $name . '_margin',
            [
                'label'      => 'فاصله خارجی',
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} ' . $selector => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // ➕ ویژگی‌های تکمیلی تایپوگرافی (آپشن‌های دستی بیشتر)
        $this->add_responsive_control(
            $name . '_line_height',
            [
                'label' => 'فاصله بین خطوط',
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'em' => [
                        'min' => 0.5,
                        'max' => 4,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} ' . $selector => 'line-height: {{SIZE}}em;',
                ],
            ]
        );

        $this->add_responsive_control(
            $name . '_letter_spacing',
            [
                'label' => 'فاصله بین حروف',
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -5,
                        'max' => 20,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} ' . $selector => 'letter-spacing: {{SIZE}}px;',
                ],
            ]
        );

        $this->end_controls_section();
    }
}
