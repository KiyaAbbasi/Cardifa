<?php
/**
 * 📁 control-media-style.php
 * 🎯 استایل‌دهی کامل برای تصاویر، ویدیوها، و embedها
 * 🛤 مسیر: includes/traits/controls/control-media-style.php
 */

namespace Cardifa\Traits\Controls;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Css_Filter;

if (!defined('ABSPATH')) exit;

trait Control_Media_Style {

    /**
     * 🎞 تابع استایل‌دهی به رسانه‌ها (تصویر، ویدیو و embed)
     * 
     * @param string $name شناسه تنظیمات
     * @param string $selector سلکتور المان
     */
    protected function register_media_style($name, $selector) {

        $this->start_controls_section(
            'section_media_style_' . $name,
            [
                'label' => 'استایل رسانه',
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        // 🔲 عرض و ارتفاع
        $this->add_responsive_control(
            $name . '_width',
            [
                'label' => 'عرض',
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => ['min' => 0, 'max' => 2000],
                    '%'  => ['min' => 0, 'max' => 100],
                ],
                'selectors' => [
                    '{{WRAPPER}} ' . $selector => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            $name . '_height',
            [
                'label' => 'ارتفاع',
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => ['min' => 0, 'max' => 2000],
                    '%'  => ['min' => 0, 'max' => 100],
                ],
                'selectors' => [
                    '{{WRAPPER}} ' . $selector => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // 🎨 فیلترهای CSS
        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name' => $name . '_filters',
                'selector' => '{{WRAPPER}} ' . $selector,
            ]
        );

        // 📸 انحنای گوشه
        $this->add_responsive_control(
            $name . '_border_radius',
            [
                'label' => 'انحنای حاشیه',
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} ' . $selector => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // 🧱 حاشیه
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => $name . '_border',
                'selector' => '{{WRAPPER}} ' . $selector,
            ]
        );

        // 🪞 سایه
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => $name . '_shadow',
                'selector' => '{{WRAPPER}} ' . $selector,
            ]
        );

        // 🎥 بک‌گراند (مثلاً وقتی ویدیو شفاف باشه)
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => $name . '_background',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} ' . $selector,
            ]
        );

        $this->end_controls_section();
    }
}
