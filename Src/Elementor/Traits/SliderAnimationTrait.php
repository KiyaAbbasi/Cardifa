<?php
/**
 * File: SliderAnimationTrait.php
 * Path: src/Elementor/Traits/
 * Description:
 *   مدیریت تنظیمات انیمیشن‌های اسلایدر شامل:
 *   - تنظیم افکت انیمیشن‌های ورودی و خروجی
 *   - تنظیم مدت زمان انیمیشن
 *   - تنظیم تأخیر انیمیشن
 * Author: Kiya Holding
 */

namespace Cardifa\Elementor\Traits;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // جلوگیری از دسترسی مستقیم

trait SliderAnimationTrait {

    /**
     * ثبت تنظیمات انیمیشن اسلایدر
     *
     * @param string $id شناسه کنترل
     * @param string $selector سلکتور CSS برای اعمال استایل‌ها
     */
    protected function register_slider_animation_controls(
        string $id = 'slider_animation',
        string $selector = '{{WRAPPER}} .cardifa-slider-animation'
    ) {
        // افکت انیمیشن ورودی
        $this->add_control(
            "{$id}_entry_effect",
            [
                'label'   => __( 'افکت انیمیشن ورودی', 'cardifa' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'fade'       => __( 'Fade', 'cardifa' ),
                    'slide-up'   => __( 'Slide Up', 'cardifa' ),
                    'slide-down' => __( 'Slide Down', 'cardifa' ),
                    'zoom-in'    => __( 'Zoom In', 'cardifa' ),
                    'zoom-out'   => __( 'Zoom Out', 'cardifa' ),
                    'flip'       => __( 'Flip', 'cardifa' ),
                ],
                'default' => 'fade',
            ]
        );

        // افکت انیمیشن خروجی
        $this->add_control(
            "{$id}_exit_effect",
            [
                'label'   => __( 'افکت انیمیشن خروجی', 'cardifa' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'fade'       => __( 'Fade', 'cardifa' ),
                    'slide-up'   => __( 'Slide Up', 'cardifa' ),
                    'slide-down' => __( 'Slide Down', 'cardifa' ),
                    'zoom-in'    => __( 'Zoom In', 'cardifa' ),
                    'zoom-out'   => __( 'Zoom Out', 'cardifa' ),
                    'flip'       => __( 'Flip', 'cardifa' ),
                ],
                'default' => 'fade',
            ]
        );

        // مدت زمان انیمیشن
        $this->add_control(
            "{$id}_duration",
            [
                'label'      => __( 'مدت زمان انیمیشن (میلی‌ثانیه)', 'cardifa' ),
                'type'       => Controls_Manager::NUMBER,
                'default'    => 500,
                'min'        => 100,
                'max'        => 5000,
                'step'       => 100,
            ]
        );

        // تأخیر انیمیشن
        $this->add_control(
            "{$id}_delay",
            [
                'label'      => __( 'تأخیر در شروع انیمیشن (میلی‌ثانیه)', 'cardifa' ),
                'type'       => Controls_Manager::NUMBER,
                'default'    => 0,
                'min'        => 0,
                'max'        => 5000,
                'step'       => 100,
            ]
        );

        // تکرار انیمیشن
        $this->add_control(
            "{$id}_repeat",
            [
                'label'        => __( 'تکرار انیمیشن', 'cardifa' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'فعال', 'cardifa' ),
                'label_off'    => __( 'غیرفعال', 'cardifa' ),
                'return_value' => 'yes',
                'default'      => 'no',
            ]
        );
    }
}
