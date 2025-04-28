<?php
/**
 * File: SliderNavigationTrait.php
 * Path: src/Elementor/Traits/
 * Description:
 *   مدیریت تنظیمات ناوبری اسلایدر شامل:
 *   - فعال‌سازی و غیرفعال‌سازی دکمه‌های ناوبری
 *   - تنظیم موقعیت دکمه‌ها
 *   - استایل‌دهی به دکمه‌ها
 *   - رفتار ناوبری (مانند کلیک یا هاور)
 * Author: Kiya Holding
 */

namespace Cardifa\Elementor\Traits;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // جلوگیری از دسترسی مستقیم

trait SliderNavigationTrait {

    /**
     * ثبت تنظیمات ناوبری اسلایدر
     *
     * @param string $id شناسه کنترل
     * @param string $selector سلکتور CSS برای اعمال استایل‌ها
     */
    protected function register_slider_navigation_controls(
        string $id = 'slider_navigation',
        string $selector = '{{WRAPPER}} .cardifa-slider-navigation'
    ) {
        // فعال‌سازی دکمه‌های ناوبری
        $this->add_control(
            "{$id}_enable",
            [
                'label'        => __( 'فعال‌سازی دکمه‌های ناوبری', 'cardifa' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'فعال', 'cardifa' ),
                'label_off'    => __( 'غیرفعال', 'cardifa' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        // موقعیت دکمه‌ها
        $this->add_control(
            "{$id}_position",
            [
                'label'   => __( 'موقعیت دکمه‌ها', 'cardifa' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'inside'  => __( 'داخل اسلایدر', 'cardifa' ),
                    'outside' => __( 'خارج از اسلایدر', 'cardifa' ),
                ],
                'default' => 'inside',
            ]
        );

        // استایل دکمه‌ها
        $this->add_control(
            "{$id}_style",
            [
                'label'   => __( 'استایل دکمه‌ها', 'cardifa' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'default' => __( 'پیش‌فرض', 'cardifa' ),
                    'rounded' => __( 'گرد', 'cardifa' ),
                    'square'  => __( 'مربع', 'cardifa' ),
                ],
                'default' => 'default',
            ]
        );

        // رفتار دکمه‌ها
        $this->add_control(
            "{$id}_behavior",
            [
                'label'   => __( 'رفتار دکمه‌ها', 'cardifa' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'click' => __( 'کلیک', 'cardifa' ),
                    'hover' => __( 'هاور', 'cardifa' ),
                ],
                'default' => 'click',
            ]
        );

        // فاصله دکمه‌ها از اسلایدر
        $this->add_control(
            "{$id}_spacing",
            [
                'label'      => __( 'فاصله دکمه‌ها از اسلایدر (پیکسل)', 'cardifa' ),
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
                    $selector => 'margin: {{SIZE}}px;',
                ],
            ]
        );

        // رنگ دکمه‌ها
        $this->add_control(
            "{$id}_color",
            [
                'label'     => __( 'رنگ دکمه‌ها', 'cardifa' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    $selector => 'color: {{VALUE}};',
                ],
            ]
        );

        // رنگ پس‌زمینه دکمه‌ها
        $this->add_control(
            "{$id}_background_color",
            [
                'label'     => __( 'رنگ پس‌زمینه', 'cardifa' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    $selector => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // رنگ دکمه‌ها در حالت هاور
        $this->add_control(
            "{$id}_hover_color",
            [
                'label'     => __( 'رنگ دکمه‌ها در هاور', 'cardifa' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    "{$selector}:hover" => 'color: {{VALUE}};',
                ],
            ]
        );

        // رنگ پس‌زمینه در حالت هاور
        $this->add_control(
            "{$id}_hover_background_color",
            [
                'label'     => __( 'رنگ پس‌زمینه در هاور', 'cardifa' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    "{$selector}:hover" => 'background-color: {{VALUE}};',
                ],
            ]
        );
    }
}
