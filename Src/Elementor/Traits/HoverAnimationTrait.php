<?php
/**
 * File: HoverAnimationTrait.php
 * Path: src/Elementor/Traits/
 * Description:
 *   مدیریت تنظیمات انیمیشن‌های هاور شامل:
 *   - افکت‌های هاور
 *   - مدت زمان و تأخیر انیمیشن
 *   - پیش‌نمایش انیمیشن
 * Author: Kiya Holding
 */

namespace Cardifa\Elementor\Traits;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // جلوگیری از دسترسی مستقیم

trait HoverAnimationTrait {

    /**
     * ثبت تنظیمات انیمیشن‌های هاور
     *
     * @param string $id شناسه کنترل
     * @param string $selector سلکتور CSS برای اعمال استایل‌ها
     */
    protected function register_hover_animation_controls(
        string $id = 'hover_animation',
        string $selector = '{{WRAPPER}} .cardifa-hover-animation'
    ) {
        // انتخاب افکت هاور
        $this->add_control(
            "{$id}_effect",
            [
                'label'   => __( 'افکت هاور', 'cardifa' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'none'       => __( 'بدون افکت', 'cardifa' ),
                    'grow'       => __( 'بزرگ شدن (Grow)', 'cardifa' ),
                    'shrink'     => __( 'کوچک شدن (Shrink)', 'cardifa' ),
                    'pulse'      => __( 'پالس (Pulse)', 'cardifa' ),
                    'float'      => __( 'شناور شدن (Float)', 'cardifa' ),
                    'sink'       => __( 'فرو رفتن (Sink)', 'cardifa' ),
                    'bob'        => __( 'حرکت بالا و پایین (Bob)', 'cardifa' ),
                    'skew'       => __( 'کج شدن (Skew)', 'cardifa' ),
                    'rotate'     => __( 'چرخش (Rotate)', 'cardifa' ),
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
                'default'    => 300,
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
