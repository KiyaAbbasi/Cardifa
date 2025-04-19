<?php
/**
 * 🎛️ کنترل‌های مربوط به چیدمان و موقعیت‌دهی
 * 🗂️ استفاده در ویجت‌ها برای تنظیم موقعیت، فاصله، اندازه و چینش
 */

namespace Cardifa\Traits\Controls;

if (!defined('ABSPATH')) exit;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Responsive;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;

trait Control_Layout_Style {

    protected function register_layout_style($name, $selector, $important = false) {
        $imp = $important ? '!important' : '';

        // 📏 فاصله داخلی (Padding)
        $this->add_responsive_control(
            "{$name}_padding",
            [
                'label' => __('فاصله داخلی', 'cardifa'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    "{{WRAPPER}} {$selector}" => "padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}{$imp};",
                ],
            ]
        );

        // 📐 فاصله خارجی (Margin)
        $this->add_responsive_control(
            "{$name}_margin",
            [
                'label' => __('فاصله خارجی', 'cardifa'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    "{{WRAPPER}} {$selector}" => "margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}{$imp};",
                ],
            ]
        );

        // 🧭 ترازبندی افقی (Alignment)
        $this->add_responsive_control(
            "{$name}_text_align",
            [
                'label' => __('چینش افقی', 'cardifa'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('چپ', 'cardifa'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('وسط', 'cardifa'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __('راست', 'cardifa'),
                        'icon' => 'eicon-text-align-right',
                    ],
                    'justify' => [
                        'title' => __('تراز', 'cardifa'),
                        'icon' => 'eicon-text-align-justify',
                    ],
                ],
                'selectors' => [
                    "{{WRAPPER}} {$selector}" => "text-align: {{VALUE}}{$imp};",
                ],
            ]
        );

        // ➕ عرض و ارتفاع
        $this->add_responsive_control(
            "{$name}_width",
            [
                'label' => __('عرض', 'cardifa'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => ['min' => 0, 'max' => 1200],
                    '%' => ['min' => 0, 'max' => 100],
                ],
                'selectors' => [
                    "{{WRAPPER}} {$selector}" => "width: {{SIZE}}{{UNIT}}{$imp};",
                ],
            ]
        );

        $this->add_responsive_control(
            "{$name}_height",
            [
                'label' => __('ارتفاع', 'cardifa'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => ['min' => 0, 'max' => 1000],
                    '%' => ['min' => 0, 'max' => 100],
                ],
                'selectors' => [
                    "{{WRAPPER}} {$selector}" => "height: {{SIZE}}{{UNIT}}{$imp};",
                ],
            ]
        );

        // 🧱 Display و Flex
        $this->add_control(
            "{$name}_display",
            [
                'label' => __('نمایش', 'cardifa'),
                'type' => Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    '' => 'پیش‌فرض',
                    'block' => 'Block',
                    'inline-block' => 'Inline Block',
                    'inline' => 'Inline',
                    'flex' => 'Flex',
                    'inline-flex' => 'Inline Flex',
                ],
                'selectors' => [
                    "{{WRAPPER}} {$selector}" => "display: {{VALUE}}{$imp};",
                ],
            ]
        );
    }
}
