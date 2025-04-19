<?php
/**
 * 📁 control-position-style.php
 * 🎯 استایل‌دهی موقعیت مکانی المان‌ها (absolute, relative, fixed و...)
 * 🛤 مسیر: includes/traits/controls/control-position-style.php
 */

namespace Cardifa\Traits\Controls;

use Elementor\Controls_Manager;

if (!defined('ABSPATH')) exit;

trait Control_Position_Style {

    /**
     * 📌 ثبت تنظیمات موقعیت‌یابی برای المان
     *
     * @param string $name نام اختصاصی
     * @param string $selector سلکتور CSS
     */
    protected function register_position_style($name, $selector) {

        $this->start_controls_section(
            'section_position_style_' . $name,
            [
                'label' => 'موقعیت عنصر',
                'tab'   => Controls_Manager::TAB_ADVANCED,
            ]
        );

        // نوع موقعیت (نسبی، مطلق، ثابت)
        $this->add_control(
            $name . '_position_type',
            [
                'label' => 'نوع موقعیت',
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'static'   => 'Static (پیش‌فرض)',
                    'relative' => 'Relative (نسبی)',
                    'absolute' => 'Absolute (مطلق)',
                    'fixed'    => 'Fixed (ثابت)',
                ],
                'default' => 'static',
                'selectors' => [
                    '{{WRAPPER}} ' . $selector => 'position: {{VALUE}};',
                ],
            ]
        );

        // مکان‌یابی از چهار جهت
        foreach (['top', 'right', 'bottom', 'left'] as $side) {
            $this->add_responsive_control(
                $name . '_position_' . $side,
                [
                    'label' => ucfirst($side),
                    'type' => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => ['min' => -2000, 'max' => 2000],
                        '%'  => ['min' => -200, 'max' => 200],
                        'vw' => ['min' => -200, 'max' => 200],
                        'vh' => ['min' => -200, 'max' => 200],
                        'em' => ['min' => -100, 'max' => 100],
                        'rem'=> ['min' => -100, 'max' => 100],
                    ],
                    'size_units' => ['px', '%', 'vw', 'vh', 'em', 'rem'],
                    'selectors' => [
                        '{{WRAPPER}} ' . $selector => $side . ': {{SIZE}}{{UNIT}};',
                    ],
                    'condition' => [
                        $name . '_position_type!' => 'static'
                    ]
                ]
            );
        }

        // Z-Index
        $this->add_control(
            $name . '_z_index',
            [
                'label' => 'Z-Index',
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 9999,
                'selectors' => [
                    '{{WRAPPER}} ' . $selector => 'z-index: {{VALUE}};',
                ],
                'condition' => [
                    $name . '_position_type!' => 'static'
                ]
            ]
        );

        // نمایش فلکس در حالت absolute برای کنترل راحت‌تر محتوا
        $this->add_control(
            $name . '_display_flex',
            [
                'label' => 'فعال‌سازی Flex برای موقعیت مطلق',
                'type' => Controls_Manager::SWITCHER,
                'label_on' => 'بله',
                'label_off' => 'خیر',
                'return_value' => 'flex',
                'selectors' => [
                    '{{WRAPPER}} ' . $selector => 'display: {{VALUE}};',
                ],
                'condition' => [
                    $name . '_position_type' => 'absolute'
                ]
            ]
        );

        // ترنسفورم اختیاری (مثلاً جابجایی دستی، چرخش و...)
        $this->add_control(
            $name . '_transform',
            [
                'label' => 'تبدیل (Transform)',
                'type' => Controls_Manager::TEXT,
                'description' => 'مثال: translateX(-50%) rotate(10deg)',
                'selectors' => [
                    '{{WRAPPER}} ' . $selector => 'transform: {{VALUE}};',
                ],
                'condition' => [
                    $name . '_position_type!' => 'static'
                ]
            ]
        );

        $this->end_controls_section();
    }
}
