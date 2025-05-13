<?php
/**
 * File: EntranceAnimationTrait.php
 * Path: src/Elementor/Traits/
 * Description:
 *   مدیریت تنظیمات انیمیشن‌های ورودی شامل:
 *   - افکت‌های ورودی
 *   - مدت زمان و تأخیر انیمیشن
 *   - پیش‌نمایش انیمیشن
 * Author: Kiya Holding
 */

namespace Cardifa\Elementor\Traits;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // جلوگیری از دسترسی مستقیم

trait EntranceAnimationTrait {

    /**
     * ثبت تنظیمات انیمیشن‌های ورودی
     *
     * @param string $id شناسه کنترل
     * @param string $selector سلکتور CSS برای اعمال استایل‌ها
     */
    protected function register_entrance_animation_controls(
        string $id = 'entrance_animation',
        string $selector = '{{WRAPPER}} .cardifa-entrance-animation'
    ) {
        // انتخاب افکت انیمیشن ورودی
        $this->add_control(
            "{$id}_effect",
            [
                'label'   => __( 'افکت انیمیشن ورودی', 'cardifa' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'none'       => __( 'بدون افکت', 'cardifa' ),
                    'fade-in'    => __( 'Fade In', 'cardifa' ),
                    'slide-up'   => __( 'Slide Up', 'cardifa' ),
                    'slide-down' => __( 'Slide Down', 'cardifa' ),
                    'slide-left' => __( 'Slide Left', 'cardifa' ),
                    'slide-right'=> __( 'Slide Right', 'cardifa' ),
                    'zoom-in'    => __( 'Zoom In', 'cardifa' ),
                    'zoom-out'   => __( 'Zoom Out', 'cardifa' ),
                    'rotate'     => __( 'Rotate', 'cardifa' ),
                ],
                'default' => 'none',
                'selectors' => [
                    $selector => 'animation-name: {{VALUE}};',
                ],
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
                'selectors'  => [
                    $selector => 'animation-duration: {{SIZE}}ms;',
                ],
            ]
        );

        // تأخیر در شروع انیمیشن
        $this->add_control(
            "{$id}_delay",
            [
                'label'      => __( 'تأخیر در شروع انیمیشن (میلی‌ثانیه)', 'cardifa' ),
                'type'       => Controls_Manager::NUMBER,
                'default'    => 0,
                'min'        => 0,
                'max'        => 5000,
                'step'       => 100,
                'selectors'  => [
                    $selector => 'animation-delay: {{SIZE}}ms;',
                ],
            ]
        );

        // پیش‌نمایش انیمیشن
        $this->add_control(
            "{$id}_preview",
            [
                'label'        => __( 'پیش‌نمایش انیمیشن', 'cardifa' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'فعال', 'cardifa' ),
                'label_off'    => __( 'غیرفعال', 'cardifa' ),
                'return_value' => 'yes',
                'default'      => 'no',
            ]
        );
    }
}
