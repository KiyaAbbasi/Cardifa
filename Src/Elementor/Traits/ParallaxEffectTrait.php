<?php
/**
 * File: ParallaxEffectTrait.php
 * Path: src/Elementor/Traits/
 * Description:
 *   مدیریت تنظیمات افکت پارالاکس شامل:
 *   • افکت پارالاکس روی تصاویر و پس‌زمینه‌ها.
 *   • تنظیم سرعت حرکت پارالاکس.
 *   • پشتیبانی از واکنش‌گرایی.
 * Author: Kiya Holding
 */

namespace Cardifa\Elementor\Traits;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // جلوگیری از دسترسی مستقیم

trait ParallaxEffectTrait {

    /**
     * ثبت تنظیمات افکت پارالاکس
     *
     * @param string $id شناسه کنترل
     * @param string $selector سلکتور CSS برای اعمال استایل‌ها
     */
    protected function register_parallax_effect_controls(
        string $id = 'parallax_effect',
        string $selector = '{{WRAPPER}} .cardifa-parallax'
    ) {
        // فعال‌سازی افکت پارالاکس
        $this->add_control(
            "{$id}_enable",
            [
                'label'        => __( 'فعال‌سازی افکت پارالاکس', 'cardifa' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'فعال', 'cardifa' ),
                'label_off'    => __( 'غیرفعال', 'cardifa' ),
                'return_value' => 'yes',
                'default'      => 'no',
                'prefix_class' => 'cardifa-parallax-',
            ]
        );

        // تنظیم سرعت پارالاکس
        $this->add_control(
            "{$id}_speed",
            [
                'label'      => __( 'سرعت پارالاکس', 'cardifa' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ '%' ],
                'range'      => [
                    '%' => [ 'min' => 0, 'max' => 100, 'step' => 1 ],
                ],
                'default'    => [ 'unit' => '%', 'size' => 50 ],
                'selectors'  => [
                    $selector => '--parallax-speed: {{SIZE}}{{UNIT}};',
                ],
                'condition'  => [
                    "{$id}_enable" => 'yes',
                ],
            ]
        );
    }
}
