<?php
/**
 * File: ScrollViewTrait.php
 * Path: src/Elementor/Traits/
 * Description:
 *   مدیریت تنظیمات اسکرول ویو شامل:
 *   - افکت‌های اسکرول
 *   - سرعت اسکرول
 *   - تنظیمات ویژه برای حالت‌های مختلف
 * Author: Kiya Holding
 */

namespace Cardifa\Elementor\Traits;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // جلوگیری از دسترسی مستقیم

trait ScrollViewTrait {

    /**
     * ثبت تنظیمات اسکرول ویو
     *
     * @param string $id شناسه کنترل
     * @param string $selector سلکتور CSS برای اعمال استایل‌ها
     */
    protected function register_scroll_view_controls(
        string $id = 'scroll_view',
        string $selector = '{{WRAPPER}} .cardifa-scroll-view'
    ) {
        // انتخاب افکت اسکرول
        $this->add_control(
            "{$id}_effect",
            [
                'label'   => __( 'افکت اسکرول', 'cardifa' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'none'       => __( 'بدون افکت', 'cardifa' ),
                    'fade'       => __( 'Fade', 'cardifa' ),
                    'slide'      => __( 'Slide', 'cardifa' ),
                    'zoom'       => __( 'Zoom', 'cardifa' ),
                    'rotate'     => __( 'Rotate', 'cardifa' ),
                    'parallax'   => __( 'Parallax', 'cardifa' ),
                ],
                'default' => 'none',
                'selectors' => [
                    $selector => 'scroll-effect: {{VALUE}};',
                ],
            ]
        );

        // تنظیم سرعت اسکرول
        $this->add_control(
            "{$id}_speed",
            [
                'label'      => __( 'سرعت اسکرول (ms)', 'cardifa' ),
                'type'       => Controls_Manager::NUMBER,
                'default'    => 500,
                'min'        => 100,
                'max'        => 5000,
                'step'       => 100,
                'selectors'  => [
                    $selector => 'scroll-speed: {{SIZE}}ms;',
                ],
            ]
        );

        // فعال‌سازی پس‌زمینه ثابت در اسکرول (Parallax)
        $this->add_control(
            "{$id}_parallax",
            [
                'label'        => __( 'فعال‌سازی پارالاکس', 'cardifa' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'فعال', 'cardifa' ),
                'label_off'    => __( 'غیرفعال', 'cardifa' ),
                'return_value' => 'yes',
                'default'      => 'no',
            ]
        );

        // پیش‌نمایش اسکرول ویو
        $this->add_control(
            "{$id}_preview",
            [
                'label'        => __( 'پیش‌نمایش اسکرول', 'cardifa' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'فعال', 'cardifa' ),
                'label_off'    => __( 'غیرفعال', 'cardifa' ),
                'return_value' => 'yes',
                'default'      => 'no',
            ]
        );
    }
}
