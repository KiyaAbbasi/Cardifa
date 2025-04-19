<?php
/**
 * 📁 control-button-style.php
 * 🎯 استایل کامل برای دکمه‌ها
 * 🛤 مسیر: includes/traits/controls/control-button-style.php
 */

namespace Cardifa\Traits\Controls;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;

if (!defined('ABSPATH')) exit;

trait Control_Button_Style {

    /**
     * 🧩 استایل‌دهی کامل به دکمه‌ها
     * 
     * @param string $name شناسه یکتا
     * @param string $selector سلکتور دکمه (مثلاً .cardifa-btn)
     */
    protected function register_button_style($name, $selector) {

        $this->start_controls_section(
            'section_button_style_' . $name,
            [
                'label' => 'استایل دکمه',
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        // 🔠 تایپوگرافی
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => $name . '_typography',
                'selector' => '{{WRAPPER}} ' . $selector,
            ]
        );

        // 🎨 رنگ متن و پس‌زمینه
        $this->add_control(
            $name . '_color',
            [
                'label' => 'رنگ متن',
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $selector => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            $name . '_bg_color',
            [
                'label' => 'رنگ پس‌زمینه',
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $selector => 'background-color: {{VALUE}}',
                ],
            ]
        );

        // 🟦 حاشیه و شعاع گوشه‌ها
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => $name . '_border',
                'selector' => '{{WRAPPER}} ' . $selector,
            ]
        );

        $this->add_responsive_control(
            $name . '_border_radius',
            [
                'label' => 'انحنای گوشه‌ها',
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} ' . $selector => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // 📏 فاصله‌ها
        $this->add_responsive_control(
            $name . '_padding',
            [
                'label' => 'پدینگ داخلی',
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} ' . $selector => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // 🌫 سایه
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => $name . '_box_shadow',
                'selector' => '{{WRAPPER}} ' . $selector,
            ]
        );

        // 🌀 ترنزیشن
        $this->add_control(
            $name . '_transition',
            [
                'label' => 'مدت ترنزیشن',
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => ['min' => 0, 'max' => 3, 'step' => 0.1],
                ],
                'selectors' => [
                    '{{WRAPPER}} ' . $selector => 'transition: all {{SIZE}}s ease-in-out;',
                ],
            ]
        );

        // 🔁 هاور استایل
        $this->start_controls_tabs('tabs_button_hover_' . $name);

        $this->start_controls_tab('tab_button_hover_normal_' . $name, [
            'label' => 'عادی',
        ]);

        $this->end_controls_tab();

        $this->start_controls_tab('tab_button_hover_hover_' . $name, [
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
            $name . '_hover_bg_color',
            [
                'label' => 'رنگ پس‌زمینه هاور',
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $selector . ':hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => $name . '_hover_box_shadow',
                'selector' => '{{WRAPPER}} ' . $selector . ':hover',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();
    }

}
