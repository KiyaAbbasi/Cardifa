<?php
/**
 * 🧱 فایل: control-border-style.php
 * 🎯 تعریف تنظیمات حرفه‌ای حاشیه، انحنای گوشه و سایه برای ویجت‌های کاردیفا
 * 📍 مسیر: includes/traits/controls/
 */

namespace Cardifa\Traits\Controls;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

if (!defined('ABSPATH')) exit;

trait Control_Border_Style {

    /**
     * 📦 تابع ثبت تنظیمات کامل حاشیه و سایه‌ها
     * @param string $name نام یکتا برای کنترل
     * @param string $selector سلکتور المنت
     * @param bool $hover اگر true باشه برای حالت hover تنظیم می‌سازه
     * @param bool $important اگر true باشه !important به CSS اضافه می‌کنه
     */
    protected function register_border_style($name, $selector, $hover = false, $important = false) {
        $suffix = $hover ? ':hover' : '';
        $important_suffix = $important ? ' !important' : '';

        // 🧱 نوع و ضخامت و رنگ حاشیه
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => $name . '_border',
                'selector' => '{{WRAPPER}} ' . $selector . $suffix,
            ]
        );

        // 🌀 شعاع گوشه‌ها (border radius)
        $this->add_responsive_control(
            $name . '_border_radius',
            [
                'label' => 'انحنای گوشه‌ها',
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} ' . $selector . $suffix => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}' . $important_suffix . ';',
                ],
            ]
        );

        // 🌫 سایه کادر
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => $name . '_box_shadow',
                'selector' => '{{WRAPPER}} ' . $selector . $suffix,
            ]
        );

        // ✨ فاصله داخلی (اختیاری)
        $this->add_responsive_control(
            $name . '_padding',
            [
                'label' => 'فاصله داخلی',
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} ' . $selector . $suffix => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}' . $important_suffix . ';',
                ],
            ]
        );

        // 🚧 فاصله خارجی
        $this->add_responsive_control(
            $name . '_margin',
            [
                'label' => 'فاصله خارجی',
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} ' . $selector . $suffix => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}' . $important_suffix . ';',
                ],
            ]
        );
    }
}
