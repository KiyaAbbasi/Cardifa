<?php
/**
 * File: SpacingTrait.php
 * Path: src/Elementor/Traits/
 * Description:
 *   مدیریت تنظیمات فاصله‌ها شامل:
 *   • حاشیه (Margin)
 *   • فاصله داخلی (Padding)
 *   • تنظیمات هاور
 *   • پشتیبانی از واکنش‌گرایی
 * Author: Kiya Holding
 */

namespace Cardifa\Elementor\Traits;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // جلوگیری از دسترسی مستقیم

trait SpacingTrait {

    /**
     * ثبت تنظیمات فاصله‌ها
     *
     * @param string $id شناسه کنترل
     * @param string $selector سلکتور CSS برای اعمال استایل‌ها
     */
    protected function register_spacing_controls(
        string $id = 'spacing',
        string $selector = '{{WRAPPER}}'
    ) {
        // حاشیه (Margin)
        $this->add_responsive_control(
            "{$id}_margin",
            [
                'label'      => __( 'حاشیه (Margin)', 'cardifa' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors'  => [
                    $selector => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // فاصله داخلی (Padding)
        $this->add_responsive_control(
            "{$id}_padding",
            [
                'label'      => __( 'فاصله داخلی (Padding)', 'cardifa' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors'  => [
                    $selector => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // حاشیه در حالت هاور
        $this->add_responsive_control(
            "{$id}_hover_margin",
            [
                'label'      => __( 'حاشیه در هاور', 'cardifa' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors'  => [
                    $selector . ':hover' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // فاصله داخلی در حالت هاور
        $this->add_responsive_control(
            "{$id}_hover_padding",
            [
                'label'      => __( 'فاصله داخلی در هاور', 'cardifa' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors'  => [
                    $selector . ':hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
    }
}
