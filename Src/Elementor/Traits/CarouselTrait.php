<?php
/**
 * File: CarouselTrait.php
 * Path: src/Elementor/Traits/
 * Description:
 *   مدیریت تنظیمات کاروسل شامل:
 *   - نمایش چندگانه اسلایدها
 *   - تنظیمات فاصله بین اسلایدها
 *   - فعال‌سازی و غیرفعال‌سازی دکمه‌های حرکتی
 *   - تنظیم سرعت و جهت حرکت
 *   - پشتیبانی از واکنش‌گرایی
 * Author: Kiya Holding
 */

namespace Cardifa\Elementor\Traits;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // جلوگیری از دسترسی مستقیم

trait CarouselTrait {

    /**
     * ثبت تنظیمات کاروسل
     *
     * @param string $id شناسه کنترل
     * @param string $selector سلکتور CSS برای اعمال استایل‌ها
     */
    protected function register_carousel_controls(
        string $id = 'carousel',
        string $selector = '{{WRAPPER}} .cardifa-carousel'
    ) {
        // تعداد اسلایدهای قابل نمایش
        $this->add_responsive_control(
            "{$id}_slides_to_show",
            [
                'label'      => __( 'تعداد اسلایدها در نمایش', 'cardifa' ),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 1,
                        'max' => 10,
                        'step' => 1,
                    ],
                ],
                'default'    => [
                    'size' => 3,
                ],
                'selectors'  => [
                    $selector => 'grid-template-columns: repeat({{SIZE}}, 1fr);',
                ],
            ]
        );

        // تنظیم فاصله بین اسلایدها
        $this->add_control(
            "{$id}_slide_spacing",
            [
                'label'      => __( 'فاصله بین اسلایدها (پیکسل)', 'cardifa' ),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ],
                ],
                'default'    => [
                    'size' => 10,
                ],
                'selectors'  => [
                    $selector => 'gap: {{SIZE}}px;',
                ],
            ]
        );

        // فعال‌سازی دکمه‌های حرکتی
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

        // سرعت حرکت اسلایدها
        $this->add_control(
            "{$id}_autoplay_speed",
            [
                'label'      => __( 'سرعت حرکت (میلی‌ثانیه)', 'cardifa' ),
                'type'       => Controls_Manager::NUMBER,
                'default'    => 3000,
                'min'        => 1000,
                'max'        => 10000,
                'step'       => 500,
                'condition'  => [
                    "{$id}_autoplay" => 'yes',
                ],
            ]
        );

        // جهت حرکت اسلایدها
        $this->add_control(
            "{$id}_direction",
            [
                'label'   => __( 'جهت حرکت', 'cardifa' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'ltr' => __( 'چپ به راست', 'cardifa' ),
                    'rtl' => __( 'راست به چپ', 'cardifa' ),
                ],
                'default' => 'ltr',
            ]
        );
    }
}
