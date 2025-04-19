<?php
/**
 * 📁 control-hover-style.php
 * 🎯 کنترل حالت هاور برای استایل‌دهی پویا
 * 🛤 مسیر: includes/traits/controls/control-hover-style.php
 */

namespace Cardifa\Traits\Controls;

use Elementor\Controls_Manager;

if (!defined('ABSPATH')) exit;

trait Control_Hover_Style {

    /**
     * 🔧 افزودن تنظیمات کامل هاور برای یک المنت
     * 
     * @param string $name نام یکتای کنترل
     * @param string $selector سلکتور هدف (مثلاً .cardifa-button)
     */
    protected function register_hover_style($name, $selector) {
        $this->start_controls_section(
            'section_hover_style_' . $name,
            [
                'label' => 'حالت هاور',
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('tabs_hover_' . $name);

        // 🟢 حالت عادی
        $this->start_controls_tab('tab_hover_normal_' . $name, [
            'label' => 'عادی',
        ]);

        $this->add_control(
            $name . '_normal_color',
            [
                'label' => 'رنگ متن',
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $selector => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            $name . '_normal_bg',
            [
                'label' => 'پس‌زمینه',
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $selector => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        // 🟣 حالت هاور
        $this->start_controls_tab('tab_hover_hover_' . $name, [
            'label' => 'هاور',
        ]);

        $this->add_control(
            $name . '_hover_color',
            [
                'label' => 'رنگ متن هاور',
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $selector . ':hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            $name . '_hover_bg',
            [
                'label' => 'رنگ پس‌زمینه هاور',
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $selector . ':hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            $name . '_hover_border_color',
            [
                'label' => 'رنگ بوردر هاور',
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $selector . ':hover' => 'border-color: {{VALUE}}',
                ],
                'condition' => [
                    $name . '_has_border' => 'yes'
                ]
            ]
        );

        $this->add_control(
            $name . '_transition_duration',
            [
                'label' => 'مدت انیمیشن (ثانیه)',
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 5,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} ' . $selector => 'transition: all {{SIZE}}s ease-in-out;',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();
    }

}
