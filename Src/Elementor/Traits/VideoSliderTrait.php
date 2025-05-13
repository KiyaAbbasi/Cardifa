<?php
/**
 * File: VideoSliderTrait.php
 * Path: src/Elementor/Traits/
 * Description:
 *   مدیریت تنظیمات اسلایدر ویدئویی شامل:
 *   - فعال‌سازی و غیرفعال‌سازی Autoplay
 *   - کنترل‌های Mute و Loop
 *   - انتخاب تصویر جایگزین (Fallback Image)
 *   - فعال‌سازی Thumbnail برای ویدیوها
 *   - تنظیمات Transition و Aspect Ratio
 *   - پشتیبانی از واکنش‌گرایی
 * Author: Kiya Holding
 */

namespace Cardifa\Elementor\Traits;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // جلوگیری از دسترسی مستقیم

trait VideoSliderTrait {

    /**
     * ثبت تنظیمات اسلایدر ویدئویی
     *
     * @param string $id شناسه کنترل
     * @param string $selector سلکتور CSS برای اعمال استایل‌ها
     */
    protected function register_video_slider_controls(
        string $id = 'video_slider',
        string $selector = '{{WRAPPER}} .cardifa-video-slider'
    ) {
        // فعال‌سازی Autoplay
        $this->add_control(
            "{$id}_autoplay",
            [
                'label'        => __( 'فعال‌سازی Autoplay', 'cardifa' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'فعال', 'cardifa' ),
                'label_off'    => __( 'غیرفعال', 'cardifa' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        // فعال‌سازی Mute
        $this->add_control(
            "{$id}_mute",
            [
                'label'        => __( 'فعال‌سازی Mute', 'cardifa' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'فعال', 'cardifa' ),
                'label_off'    => __( 'غیرفعال', 'cardifa' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        // فعال‌سازی Loop
        $this->add_control(
            "{$id}_loop",
            [
                'label'        => __( 'فعال‌سازی Loop', 'cardifa' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'فعال', 'cardifa' ),
                'label_off'    => __( 'غیرفعال', 'cardifa' ),
                'return_value' => 'yes',
                'default'      => 'no',
            ]
        );

        // انتخاب تصویر جایگزین (Fallback Image)
        $this->add_control(
            "{$id}_fallback_image",
            [
                'label'   => __( 'تصویر جایگزین (Fallback Image)', 'cardifa' ),
                'type'    => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Controls_Manager::get_placeholder_image_src(),
                ],
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

        // Aspect Ratio
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
            ]
        );

        // افکت Transition
        $this->add_control(
            "{$id}_transition_effect",
            [
                'label'   => __( 'افکت Transition', 'cardifa' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'slide'  => __( 'Slide', 'cardifa' ),
                    'fade'   => __( 'Fade', 'cardifa' ),
                    'zoom'   => __( 'Zoom', 'cardifa' ),
                    'flip'   => __( 'Flip', 'cardifa' ),
                ],
                'default' => 'slide',
            ]
        );

        // تنظیمات واکنش‌گرایی (Breakpoints)
        $this->add_responsive_control(
            "{$id}_breakpoints",
            [
                'label'      => __( 'تعداد ویدیوها در هر نمایش', 'cardifa' ),
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
