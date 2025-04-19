<?php
/**
 * 📁 فایل: control-spacing-style.php
 * 🎯 تعریف تنظیمات فاصله داخلی و خارجی برای ویجت‌های کاردیفا
 * 📍 مسیر: includes/traits/controls/
 */

namespace Cardifa\Traits\Controls;

use Elementor\Controls_Manager;

if (!defined('ABSPATH')) exit;

trait Control_Spacing_Style {

    /**
     * 🧩 تعریف کنترل‌های کامل برای فاصله داخلی و خارجی
     * @param string $name نام یکتا برای کنترل‌ها
     * @param string $selector سلکتور هدف برای CSS
     * @param bool $hover اگر true باشه روی حالت هاور هم اعمال میشه
     * @param bool $important اگر true باشه `!important` به CSS اضافه میشه
     */
    protected function register_spacing_style($name, $selector, $hover = false, $important = false) {
        $suffix = $hover ? ':hover' : '';
        $important_suffix = $important ? ' !important' : '';

        // 🧊 فاصله داخلی (Padding)
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

        // 📏 فاصله خارجی (Margin)
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
