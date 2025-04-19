<?php
/**
 * 📁 control-animation-style.php
 * 🎯 کنترل کامل انیمیشن ورود و transition برای المان‌ها
 * 🛤 مسیر: includes/traits/controls/control-animation-style.php
 */

namespace Cardifa\Traits\Controls;

use Elementor\Controls_Manager;

if (!defined('ABSPATH')) exit;

trait Control_Animation_Style {

    /**
     * 🧠 تابع اضافه کردن تنظیمات انیمیشن به المنت مشخص
     * 
     * @param string $name    شناسه یکتا
     * @param string $selector سلکتور المنت مورد نظر
     */
    protected function register_animation_style($name, $selector) {

        $this->start_controls_section(
            'section_animation_' . $name,
            [
                'label' => 'انیمیشن ورود',
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        // 🎞 انتخاب نوع انیمیشن
        $this->add_control(
            $name . '_animation_effect',
            [
                'label'   => 'افکت ورود',
                'type'    => Controls_Manager::ANIMATION,
                'default' => '',
                'prefix_class' => 'animated ',
            ]
        );

        // ⏱ تاخیر در اجرا
        $this->add_control(
            $name . '_animation_delay',
            [
                'label' => 'تاخیر در شروع (ثانیه)',
                'type'  => Controls_Manager::SLIDER,
                'range' => [
                    's' => [
                        'min' => 0,
                        'max' => 10,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} ' . $selector => 'animation-delay: {{SIZE}}s;',
                ],
            ]
        );

        // 🚀 مدت زمان اجرا
        $this->add_control(
            $name . '_animation_duration',
            [
                'label' => 'مدت زمان انیمیشن (ثانیه)',
                'type'  => Controls_Manager::SLIDER,
                'range' => [
                    's' => [
                        'min' => 0.1,
                        'max' => 10,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} ' . $selector => 'animation-duration: {{SIZE}}s;',
                ],
            ]
        );

        // 📉 سرعت انتقال (Transition)
        $this->add_control(
            $name . '_transition_speed',
            [
                'label' => 'سرعت انتقال عمومی (Transition)',
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    's' => [
                        'min' => 0,
                        'max' => 5,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} ' . $selector => 'transition-duration: {{SIZE}}s;',
                ],
            ]
        );

        // ⚡ حالت تکرار
        $this->add_control(
            $name . '_animation_repeat',
            [
                'label' => 'تکرار انیمیشن',
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'none' => 'هیچ‌کدام',
                    'infinite' => 'بی‌نهایت',
                    'initial' => 'فقط یک‌بار',
                ],
                'default' => 'initial',
                'selectors' => [
                    '{{WRAPPER}} ' . $selector => 'animation-iteration-count: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }
}
