<?php
/**
 * File: SliderTrait.php
 * Path: src/Elementor/Traits/
 * Description:
 *   مدیریت تنظیمات کامل اسلایدر شامل:
 *   - فعال/غیرفعال کردن Loop
 *   - تنظیم سرعت
 *   - فعال‌سازی Autoplay
 *   - کنترل‌های Pause و Resume
 *   - Navigation و Pagination
 *   - افکت‌های Transition
 *   - پشتیبانی از Breakpoints
 * Author: Kiya Holding
 */

namespace Cardifa\Elementor\Traits;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // جلوگیری از دسترسی مستقیم

trait SliderTrait {

    /**
     * ثبت تنظیمات اسلایدر
     *
     * @param string $id شناسه کنترل
     * @param string $selector سلکتور CSS برای اعمال استایل‌ها
     */
    protected function register_slider_controls(
        string $id = 'slider',
        string $selector = '{{WRAPPER}} .cardifa-slider'
    ) {
        // فعال‌سازی Loop
        $this->add_control(
            "{$id}_loop",
            [
                'label'        => __( 'فعال‌سازی Loop', 'cardifa' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'فعال', 'cardifa' ),
                'label_off'    => __( 'غیرفعال', 'cardifa' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        // سرعت اسلایدر
        $this->add_control(
            "{$id}_speed",
            [
                'label'   => __( 'سرعت اسلایدر (میلی‌ثانیه)', 'cardifa' ),
                'type'    => Controls_Manager::NUMBER,
                'default' => 500,
                'min'     => 100,
                'max'     => 5000,
                'step'    => 100,
            ]
        );

        // فعال‌سازی Autoplay
        $this->add_control(
            "{$id}_autoplay",
            [
                'label'        => __( 'فعال‌سازی Autoplay', 'cardifa' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'فعال', 'cardifa' ),
                'label_off'    => __( 'غیرفعال', 'cardifa' ),
                'return_value' => 'yes',
                'default'      => 'no',
            ]
        );

        // زمان توقف Autoplay
        $this->add_control(
            "{$id}_autoplay_delay",
            [
                'label'     => __( 'زمان توقف Autoplay (میلی‌ثانیه)', 'cardifa' ),
                'type'      => Controls_Manager::NUMBER,
                'default'   => 3000,
                'min'       => 1000,
                'max'       => 10000,
                'step'      => 500,
                'condition' => [
                    "{$id}_autoplay" => 'yes',
                ],
            ]
        );

        // توقف روی Hover
        $this->add_control(
            "{$id}_pause_on_hover",
            [
                'label'        => __( 'توقف روی هاور', 'cardifa' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'فعال', 'cardifa' ),
                'label_off'    => __( 'غیرفعال', 'cardifa' ),
                'return_value' => 'yes',
                'default'      => 'no',
                'condition'    => [
                    "{$id}_autoplay" => 'yes',
                ],
            ]
        );

        // تنظیمات Navigation
        $this->add_control(
            "{$id}_navigation",
            [
                'label'        => __( 'فعال‌سازی Navigation', 'cardifa' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'فعال', 'cardifa' ),
                'label_off'    => __( 'غیرفعال', 'cardifa' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        // تنظیمات Pagination
        $this->add_control(
            "{$id}_pagination",
            [
                'label'        => __( 'فعال‌سازی Pagination', 'cardifa' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'فعال', 'cardifa' ),
                'label_off'    => __( 'غیرفعال', 'cardifa' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        // افکت Transition
        $this->add_control(
            "{$id}_transition_effect",
            [
                'label'   => __( 'افکت Transition', 'cardifa' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'slide' => __( 'Slide', 'cardifa' ),
                    'fade'  => __( 'Fade', 'cardifa' ),
                    'cube'  => __( 'Cube', 'cardifa' ),
                    'coverflow' => __( 'Coverflow', 'cardifa' ),
                ],
                'default' => 'slide',
            ]
        );

        // پشتیبانی از Breakpoints
        $this->add_responsive_control(
            "{$id}_breakpoints_items",
            [
                'label'      => __( 'تعداد آیتم‌ها در Breakpoints', 'cardifa' ),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 1,
                        'max' => 10,
                        'step' => 1,
                    ],
                ],
                'selectors'  => [
                    $selector => 'grid-template-columns: repeat({{SIZE}}, 1fr);',
                ],
            ]
        );
    }
}
