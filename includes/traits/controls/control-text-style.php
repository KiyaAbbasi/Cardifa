<?php
/**
 * 🎨 Trait: کنترل‌های استایل متن
 * 📁 مسیر: includes/traits/controls/control-text-style.php
 * 📦 استفاده در ویجت‌ها برای افزودن استایل‌های حرفه‌ای به متن (معادل Elementor Pro)
 */

namespace Cardifa\Traits\Controls;

if (!defined('ABSPATH')) exit;

trait Control_Text_Style {

    /**
     * 🎯 تنظیمات استایل کامل برای متن
     * @param string $name نام کنترل برای سوییچ تنظیمات
     * @param string $selector سلکتور CSS برای استایل‌دهی
     * @param bool $align آیا تنظیمات align نمایش داده شود یا نه
     * @param bool $important آیا از !important در استایل‌ها استفاده شود؟
     */
    protected function register_text_style($name, $selector, $align = true, $important = false) {
        $important = $important ? ' !important' : '';

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => $name . '_typography',
                'selector' => '{{WRAPPER}} ' . $selector,
            ]
        );

        if ($align) {
            $this->add_responsive_control(
                $name . '_alignment',
                [
                    'label' => 'چینش',
                    'type' => \Elementor\Controls_Manager::CHOOSE,
                    'options' => [
                        'left' => [ 'title' => 'چپ', 'icon' => 'eicon-text-align-left' ],
                        'center' => [ 'title' => 'وسط', 'icon' => 'eicon-text-align-center' ],
                        'right' => [ 'title' => 'راست', 'icon' => 'eicon-text-align-right' ],
                        'justify' => [ 'title' => 'تراز', 'icon' => 'eicon-text-align-justify' ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} ' . $selector => 'text-align: {{VALUE}}' . $important . ';',
                    ],
                ]
            );
        }

        $this->add_control(
            $name . '_color',
            [
                'label' => 'رنگ متن',
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $selector => 'color: {{VALUE}}' . $important . ';',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Text_Shadow::get_type(),
            [
                'name' => $name . '_text_shadow',
                'selector' => '{{WRAPPER}} ' . $selector,
            ]
        );

        $this->add_responsive_control(
            $name . '_padding',
            [
                'label' => 'فاصله داخلی',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} ' . $selector => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}' . $important . ';',
                ],
            ]
        );

        $this->add_responsive_control(
            $name . '_margin',
            [
                'label' => 'فاصله خارجی',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} ' . $selector => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}' . $important . ';',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => $name . '_background',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} ' . $selector,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => $name . '_border',
                'selector' => '{{WRAPPER}} ' . $selector,
            ]
        );

        $this->add_responsive_control(
            $name . '_border_radius',
            [
                'label' => 'انحنای گوشه‌ها',
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} ' . $selector => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}' . $important . ';',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => $name . '_box_shadow',
                'selector' => '{{WRAPPER}} ' . $selector,
            ]
        );

        // ⏱ انیمیشن
        $this->add_responsive_control(
            $name . '_animation_duration',
            [
                'label' => 'مدت زمان ترنزیشن',
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => ['min' => 0, 'max' => 10, 'step' => 0.1],
                ],
                'selectors' => [
                    '{{WRAPPER}} ' . $selector => 'transition-duration: {{SIZE}}s' . $important . ';',
                ],
            ]
        );
    }
}
