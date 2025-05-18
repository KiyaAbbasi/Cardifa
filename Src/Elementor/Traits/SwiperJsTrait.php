<?php
/**
 * File: SwiperJsTrait.php
 * Path: src/Elementor/Traits/
 * Description:
 *   مدیریت تنظیمات پیشرفته Swiper.js شامل:
 *   - تنظیمات Loop، Autoplay و Speed
 *   - افکت‌های Transition پیچیده (Cube, Coverflow, Flip)
 *   - کنترل‌های Navigation و Pagination
 *   - پشتیبانی از Breakpoints برای واکنش‌گرایی
 *   - تنظیمات Scrollbar و Mousewheel
 * Author: Kiya Holding
 */

namespace Cardifa\Elementor\Traits;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // جلوگیری از دسترسی مستقیم

trait SwiperJsTrait {

    /**
     * ثبت تنظیمات Swiper.js
     *
     * @param string $id شناسه کنترل
     * @param string $selector سلکتور CSS برای اعمال استایل‌ها
     */
    protected function register_swiper_controls(
        string $id = 'swiper',
        string $selector = '{{WRAPPER}} .cardifa-swiper'
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

        // سرعت حرکت اسلایدر
        $this->add_control(
            "{$id}_speed",
            [
                'label'   => __( 'سرعت حرکت (میلی‌ثانیه)', 'cardifa' ),
                'type'    => Controls_Manager::NUMBER,
                'default' => 400,
                'min'     => 100,
                'max'     => 5000,
                'step'    => 100,
            ]
        );

        // افکت‌های Transition
        $this->add_control(
            "{$id}_effect",
            [
                'label'   => __( 'افکت Transition', 'cardifa' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'slide'     => __( 'Slide', 'cardifa' ),
                    'fade'      => __( 'Fade', 'cardifa' ),
                    'cube'      => __( 'Cube', 'cardifa' ),
                    'coverflow' => __( 'Coverflow', 'cardifa' ),
                    'flip'      => __( 'Flip', 'cardifa' ),
                ],
                'default' => 'slide',
            ]
        );

        // فعال‌سازی Navigation
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

        // فعال‌سازی Pagination
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

        // فعال‌سازی Scrollbar
        $this->add_control(
            "{$id}_scrollbar",
            [
                'label'        => __( 'فعال‌سازی Scrollbar', 'cardifa' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'فعال', 'cardifa' ),
                'label_off'    => __( 'غیرفعال', 'cardifa' ),
                'return_value' => 'yes',
                'default'      => 'no',
            ]
        );

        // فعال‌سازی Mousewheel
        $this->add_control(
            "{$id}_mousewheel",
            [
                'label'        => __( 'فعال‌سازی Mousewheel', 'cardifa' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'فعال', 'cardifa' ),
                'label_off'    => __( 'غیرفعال', 'cardifa' ),
                'return_value' => 'yes',
                'default'      => 'no',
            ]
        );

        // تنظیمات واکنش‌گرایی (Breakpoints)
        $this->add_responsive_control(
            "{$id}_breakpoints",
            [
                'label'      => __( 'تعداد آیتم‌ها در هر نمایش', 'cardifa' ),
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
