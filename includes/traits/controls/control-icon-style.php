<?php
/**
 * 📁 control-icon-style.php
 * --------------------------
 * 🎯 کنترل‌های استایل آیکون برای ویجت‌های المنتور
 * 🛤 مسیر: includes/controls/control-icon-style.php
 */

namespace Cardifa\Traits\Controls;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;

if (!defined('ABSPATH')) exit;

trait Control_Icon_Style {

    /**
     * 🎨 افزودن تنظیمات استایل آیکون
     * @param string $name شناسه تنظیم
     * @param string $selector سلکتور CSS
     */
    protected function register_icon_style($name, $selector) {
        // تب اصلی استایل آیکون
        $this->start_controls_section(
            $name . '_icon_style_section',
            [
                'label' => 'استایل آیکون',
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs($name . '_icon_tabs');

        // 👕 حالت عادی
        $this->start_controls_tab($name . '_icon_normal_tab', [
            'label' => 'عادی',
        ]);

        // رنگ آیکون
        $this->add_control(
            $name . '_icon_color',
            [
                'label' => 'رنگ آیکون',
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $selector => 'color: {{VALUE}}',
                ],
            ]
        );

        // اندازه آیکون
        $this->add_responsive_control(
            $name . '_icon_size',
            [
                'label' => 'سایز آیکون',
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => ['min' => 10, 'max' => 200],
                ],
                'selectors' => [
                    '{{WRAPPER}} ' . $selector => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // فاصله داخلی
        $this->add_responsive_control(
            $name . '_icon_padding',
            [
                'label' => 'فاصله داخلی',
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} ' . $selector => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // پس‌زمینه
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => $name . '_icon_background',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} ' . $selector,
            ]
        );

        // مرز
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => $name . '_icon_border',
                'selector' => '{{WRAPPER}} ' . $selector,
            ]
        );

        // انحنای مرز
        $this->add_responsive_control(
            $name . '_icon_border_radius',
            [
                'label' => 'انحنای حاشیه',
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} ' . $selector => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // سایه
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => $name . '_icon_shadow',
                'selector' => '{{WRAPPER}} ' . $selector,
            ]
        );

        $this->end_controls_tab();

        // ✨ حالت هاور
        $this->start_controls_tab($name . '_icon_hover_tab', [
            'label' => 'هاور',
        ]);

        $this->add_control(
            $name . '_icon_hover_color',
            [
                'label' => 'رنگ هاور آیکون',
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $selector . ':hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            $name . '_icon_hover_background',
            [
                'label' => 'پس‌زمینه هاور',
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $selector . ':hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => $name . '_icon_hover_shadow',
                'selector' => '{{WRAPPER}} ' . $selector . ':hover',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }
}
