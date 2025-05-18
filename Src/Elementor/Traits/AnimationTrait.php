<?php
/**
 * File: AnimationTrait.php
 * Path: src/Elementor/Traits/
 * Description:
 *   مدیریت تنظیمات انیمیشن شامل:
 *   • نوع انیمیشن
 *   • مدت زمان (Duration)
 *   • تأخیر (Delay)
 *   • تعداد دفعات اجرا
 *   • حالت انیمیشن (Timing Function)
 *   • پشتیبانی از انیمیشن‌های استاندارد CSS و کتابخانه‌های خارجی
 * Author: Kiya Holding
 */

namespace Cardifa\Elementor\Traits;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // جلوگیری از دسترسی مستقیم

trait AnimationTrait {

    /**
     * ثبت تنظیمات انیمیشن
     *
     * @param string $id شناسه کنترل
     * @param string $selector سلکتور CSS برای اعمال استایل‌ها
     */
    protected function register_animation_controls(
        string $id = 'animation',
        string $selector = '{{WRAPPER}}'
    ) {
        // نوع انیمیشن
        $this->add_control(
            "{$id}_type",
            [
                'label'   => __( 'نوع انیمیشن', 'cardifa' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    ''            => __( 'بدون انیمیشن', 'cardifa' ),
                    'fade-in'     => __( 'ظاهر شدن (Fade In)', 'cardifa' ),
                    'fade-out'    => __( 'ناپدید شدن (Fade Out)', 'cardifa' ),
                    'slide-up'    => __( 'لغزش به بالا (Slide Up)', 'cardifa' ),
                    'slide-down'  => __( 'لغزش به پایین (Slide Down)', 'cardifa' ),
                    'slide-left'  => __( 'لغزش به چپ (Slide Left)', 'cardifa' ),
                    'slide-right' => __( 'لغزش به راست (Slide Right)', 'cardifa' ),
                    'bounce'      => __( 'پرش (Bounce)', 'cardifa' ),
                    'zoom-in'     => __( 'بزرگ‌نمایی (Zoom In)', 'cardifa' ),
                    'zoom-out'    => __( 'کوچک‌نمایی (Zoom Out)', 'cardifa' ),
                ],
                'default' => '',
                'selectors' => [
                    $selector => 'animation-name: {{VALUE}};',
                ],
            ]
        );

        // مدت زمان انیمیشن
        $this->add_control(
            "{$id}_duration",
            [
                'label'      => __( 'مدت زمان انیمیشن (ثانیه)', 'cardifa' ),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    's' => [ 'min' => 0.1, 'max' => 10, 'step' => 0.1 ],
                ],
                'default'    => [ 'size' => 1, 'unit' => 's' ],
                'selectors'  => [
                    $selector => 'animation-duration: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // تأخیر انیمیشن
        $this->add_control(
            "{$id}_delay",
            [
                'label'      => __( 'تأخیر انیمیشن (ثانیه)', 'cardifa' ),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    's' => [ 'min' => 0, 'max' => 5, 'step' => 0.1 ],
                ],
                'default'    => [ 'size' => 0, 'unit' => 's' ],
                'selectors'  => [
                    $selector => 'animation-delay: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // تعداد دفعات اجرا
        $this->add_control(
            "{$id}_iteration",
            [
                'label'   => __( 'تعداد دفعات اجرا', 'cardifa' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'infinite' => __( 'بی‌نهایت', 'cardifa' ),
                    '1'        => __( 'یک بار', 'cardifa' ),
                    '2'        => __( 'دو بار', 'cardifa' ),
                    '3'        => __( 'سه بار', 'cardifa' ),
                ],
                'default' => '1',
                'selectors' => [
                    $selector => 'animation-iteration-count: {{VALUE}};',
                ],
            ]
        );

        // حالت انیمیشن (Timing Function)
        $this->add_control(
            "{$id}_timing_function",
            [
                'label'   => __( 'حالت انیمیشن', 'cardifa' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'ease'       => __( 'Ease', 'cardifa' ),
                    'linear'     => __( 'Linear', 'cardifa' ),
                    'ease-in'    => __( 'Ease-In', 'cardifa' ),
                    'ease-out'   => __( 'Ease-Out', 'cardifa' ),
                    'ease-in-out'=> __( 'Ease-In-Out', 'cardifa' ),
                ],
                'default' => 'ease',
                'selectors' => [
                    $selector => 'animation-timing-function: {{VALUE}};',
                ],
            ]
        );

        // پشتیبانی از کتابخانه‌های خارجی (مانند Lottie)
        $this->add_control(
            "{$id}_lottie_url",
            [
                'label'   => __( 'آدرس فایل Lottie', 'cardifa' ),
                'type'    => Controls_Manager::URL,
                'dynamic' => [ 'active' => true ],
                'description' => __( 'لینک فایل Lottie برای اضافه کردن انیمیشن سفارشی', 'cardifa' ),
            ]
        );
    }
}
