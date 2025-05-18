<?php
/**
 * File: ImageSliderTrait.php
 * Path: src/Elementor/Traits/
 * Description:
 *   مدیریت تنظیمات اسلایدر تصاویر شامل:
 *   - فعال‌سازی و غیرفعال‌سازی Lazy Load
 *   - انتخاب Aspect Ratio
 *   - امکان اضافه کردن Thumbnail
 *   - تنظیمات Navigation و Pagination
 *   - فعال‌سازی افکت‌های Transition
 *   - تنظیمات Breakpoints برای واکنش‌گرایی
 * Author: Kiya Holding
 */

namespace Cardifa\Elementor\Traits;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // جلوگیری از دسترسی مستقیم

trait ImageSliderTrait {

    /**
     * ثبت تنظیمات اسلایدر تصویر
     *
     * @param string $id شناسه کنترل
     * @param string $selector سلکتور CSS برای اعمال استایل‌ها
     */
    protected function register_image_slider_controls(
        string $id = 'image_slider',
        string $selector = '{{WRAPPER}} .cardifa-image-slider'
    ) {
        // فعال‌سازی Lazy Load
        $this->add_control(
            "{$id}_lazyload",
            [
                'label'        => __( 'فعال‌سازی Lazy Load', 'cardifa' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'فعال', 'cardifa' ),
                'label_off'    => __( 'غیرفعال', 'cardifa' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        // انتخاب Aspect Ratio
        $this->add_control(
            "{$id}_aspect_ratio",
            [
                'label'       => __( 'نسبت تصویر (Aspect Ratio)', 'cardifa' ),
                'type'        => Controls_Manager::SELECT,
                'options'     => [
                    '16:9' => __( '16:9', 'cardifa' ),
                    '4:3'  => __( '4:3', 'cardifa' ),
                    '1:1'  => __( '1:1', 'cardifa' ),
                    'custom' => __( 'دلخواه', 'cardifa' ),
                ],
                'default'     => '16:9',
                'description' => __( 'نسبت تصویر اسلایدر را مشخص کنید.', 'cardifa' ),
            ]
        );

        // تنظیمات Thumbnail
        $this->add_control(
            "{$id}_thumbnail",
            [
                'label'        => __( 'نمایش Thumbnail', 'cardifa' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'فعال', 'cardifa' ),
                'label_off'    => __( 'غیرفعال', 'cardifa' ),
                'return_value' => 'yes',
                'default'      => 'no',
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

        // انتخاب افکت Transition
        $this->add_control(
            "{$id}_transition_effect",
            [
                'label'       => __( 'افکت Transition', 'cardifa' ),
                'type'        => Controls_Manager::SELECT,
                'options'     => [
                    'slide'  => __( 'Slide', 'cardifa' ),
                    'fade'   => __( 'Fade', 'cardifa' ),
                    'zoom'   => __( 'Zoom', 'cardifa' ),
                    'flip'   => __( 'Flip', 'cardifa' ),
                ],
                'default'     => 'slide',
                'description' => __( 'افکت نمایشی اسلایدر را انتخاب کنید.', 'cardifa' ),
            ]
        );

        // تنظیمات واکنش‌گرایی (Breakpoints)
        $this->add_responsive_control(
            "{$id}_breakpoints",
            [
                'label'      => __( 'تعداد تصاویر در هر نمایش', 'cardifa' ),
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
