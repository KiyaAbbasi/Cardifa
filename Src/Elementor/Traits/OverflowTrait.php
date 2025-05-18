<?php
/**
 * File: OverflowTrait.php
 * Path: src/Elementor/Traits/
 * Description:
 *   مدیریت تنظیمات Overflow شامل:
 *   - کنترل Overflow افقی و عمودی
 *   - پیش‌نمایش رفتار Overflow
 * Author: Kiya Holding
 */

namespace Cardifa\Elementor\Traits;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // جلوگیری از دسترسی مستقیم

trait OverflowTrait {

    /**
     * ثبت تنظیمات Overflow
     *
     * @param string $id شناسه کنترل
     * @param string $selector سلکتور CSS برای اعمال استایل‌ها
     */
    protected function register_overflow_controls(
        string $id = 'overflow',
        string $selector = '{{WRAPPER}} .cardifa-overflow'
    ) {
        // تنظیم Overflow افقی
        $this->add_control(
            "{$id}_horizontal",
            [
                'label'   => __( 'کنترل Overflow افقی', 'cardifa' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'visible' => __( 'نمایش (Visible)', 'cardifa' ),
                    'hidden'  => __( 'مخفی (Hidden)', 'cardifa' ),
                    'scroll'  => __( 'اسکرول (Scroll)', 'cardifa' ),
                    'auto'    => __( 'اتوماتیک (Auto)', 'cardifa' ),
                ],
                'default' => 'visible',
                'selectors' => [
                    $selector => 'overflow-x: {{VALUE}};',
                ],
            ]
        );

        // تنظیم Overflow عمودی
        $this->add_control(
            "{$id}_vertical",
            [
                'label'   => __( 'کنترل Overflow عمودی', 'cardifa' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'visible' => __( 'نمایش (Visible)', 'cardifa' ),
                    'hidden'  => __( 'مخفی (Hidden)', 'cardifa' ),
                    'scroll'  => __( 'اسکرول (Scroll)', 'cardifa' ),
                    'auto'    => __( 'اتوماتیک (Auto)', 'cardifa' ),
                ],
                'default' => 'visible',
                'selectors' => [
                    $selector => 'overflow-y: {{VALUE}};',
                ],
            ]
        );

        // تنظیم Overflow کلی (برای هر دو محور)
        $this->add_control(
            "{$id}_both",
            [
                'label'     => __( 'کنترل Overflow کلی', 'cardifa' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    'visible' => __( 'نمایش (Visible)', 'cardifa' ),
                    'hidden'  => __( 'مخفی (Hidden)', 'cardifa' ),
                    'scroll'  => __( 'اسکرول (Scroll)', 'cardifa' ),
                    'auto'    => __( 'اتوماتیک (Auto)', 'cardifa' ),
                ],
                'default'   => 'visible',
                'selectors' => [
                    $selector => 'overflow: {{VALUE}};',
                ],
            ]
        );

        // پیش‌نمایش رفتار Overflow
        $this->add_control(
            "{$id}_preview",
            [
                'label'        => __( 'پیش‌نمایش Overflow', 'cardifa' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'فعال', 'cardifa' ),
                'label_off'    => __( 'غیرفعال', 'cardifa' ),
                'return_value' => 'yes',
                'default'      => 'no',
            ]
        );
    }
}
