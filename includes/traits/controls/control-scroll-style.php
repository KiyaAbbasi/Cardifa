<?php
/**
 * 📁 control-scroll-style.php
 * 🎯 تنظیمات اسکرول و Overflow برای ویجت‌ها
 * 🛤 مسیر: includes/traits/controls/control-scroll-style.php
 */

namespace Cardifa\Traits\Controls;

use Elementor\Controls_Manager;

if (!defined('ABSPATH')) exit;

trait Control_Scroll_Style {

    /**
     * 🧠 افزودن تنظیمات اسکرول و Overflow برای ویجت
     *
     * @param string $name     نام اختصاصی کنترل‌ها
     * @param string $selector سلکتور CSS برای اعمال تنظیمات
     */
    protected function register_scroll_style($name, $selector) {
        $this->start_controls_section(
            'scroll_section_' . $name,
            [
                'label' => 'اسکرول و Overflow',
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'overflow_' . $name,
            [
                'label' => 'وضعیت Overflow',
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'visible' => 'نمایان',
                    'hidden'  => 'مخفی',
                    'scroll'  => 'دارای اسکرول',
                    'auto'    => 'خودکار',
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} ' . $selector => 'overflow: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'overflow_x_' . $name,
            [
                'label' => 'اسکرول افقی (X)',
                'type' => Controls_Manager::SELECT,
                'options' => [
                    ''         => 'پیش‌فرض',
                    'visible'  => 'نمایان',
                    'hidden'   => 'مخفی',
                    'scroll'   => 'دارای اسکرول',
                    'auto'     => 'خودکار',
                ],
                'selectors' => [
                    '{{WRAPPER}} ' . $selector => 'overflow-x: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'overflow_y_' . $name,
            [
                'label' => 'اسکرول عمودی (Y)',
                'type' => Controls_Manager::SELECT,
                'options' => [
                    ''         => 'پیش‌فرض',
                    'visible'  => 'نمایان',
                    'hidden'   => 'مخفی',
                    'scroll'   => 'دارای اسکرول',
                    'auto'     => 'خودکار',
                ],
                'selectors' => [
                    '{{WRAPPER}} ' . $selector => 'overflow-y: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'scroll_behavior_' . $name,
            [
                'label' => 'رفتار اسکرول',
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => 'پیش‌فرض',
                    'smooth' => 'نرم',
                    'auto' => 'خودکار',
                ],
                'selectors' => [
                    '{{WRAPPER}} ' . $selector => 'scroll-behavior: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }
}
