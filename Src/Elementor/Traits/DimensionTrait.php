<?php
/**
 * File: DimensionTrait.php
 * Path: src/Elementor/Traits/
 * Description:
 *   مدیریت تنظیمات ابعاد شامل:
 *   - Margin و Padding (واکنش‌گرا)
 *   - عرض و ارتفاع
 *   - حداقل و حداکثر عرض و ارتفاع
 *   - تنظیمات هاور
 * Author: Kiya Holding
 */

namespace Cardifa\Elementor\Traits;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // جلوگیری از دسترسی مستقیم

trait DimensionTrait {

    /**
     * ثبت تنظیمات ابعاد
     *
     * @param string $id شناسه کنترل
     * @param string $selector سلکتور CSS برای اعمال استایل‌ها
     */
    protected function register_dimension_controls(
        string $id = 'dimension',
        string $selector = '{{WRAPPER}} .cardifa-dimension'
    ) {
        // Margin (واکنش‌گرا)
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

        // Padding (واکنش‌گرا)
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

        // Width (واکنش‌گرا)
        $this->add_responsive_control(
            "{$id}_width",
            [
                'label'      => __( 'عرض', 'cardifa' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em' ],
                'range'      => [
                    'px' => [ 'min' => 0, 'max' => 2000, 'step' => 1 ],
                    '%'  => [ 'min' => 0, 'max' => 100, 'step' => 1 ],
                ],
                'selectors'  => [ $selector => 'width: {{SIZE}}{{UNIT}};' ],
            ]
        );

        // Max Width
        $this->add_control(
            "{$id}_max_width",
            [
                'label'      => __( 'حداکثر عرض', 'cardifa' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em' ],
                'range'      => [
                    'px' => [ 'min' => 0, 'max' => 2000, 'step' => 1 ],
                    '%'  => [ 'min' => 0, 'max' => 100, 'step' => 1 ],
                ],
                'selectors'  => [ $selector => 'max-width: {{SIZE}}{{UNIT}};' ],
            ]
        );

        // Height (واکنش‌گرا)
        $this->add_responsive_control(
            "{$id}_height",
            [
                'label'      => __( 'ارتفاع', 'cardifa' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em' ],
                'range'      => [
                    'px' => [ 'min' => 0, 'max' => 2000, 'step' => 1 ],
                    '%'  => [ 'min' => 0, 'max' => 100, 'step' => 1 ],
                ],
                'selectors'  => [ $selector => 'height: {{SIZE}}{{UNIT}};' ],
            ]
        );

        // Max Height
        $this->add_control(
            "{$id}_max_height",
            [
                'label'      => __( 'حداکثر ارتفاع', 'cardifa' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em' ],
                'range'      => [
                    'px' => [ 'min' => 0, 'max' => 2000, 'step' => 1 ],
                    '%'  => [ 'min' => 0, 'max' => 100, 'step' => 1 ],
                ],
                'selectors'  => [ $selector => 'max-height: {{SIZE}}{{UNIT}};' ],
            ]
        );

        // Margin در حالت هاور
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

        // Padding در حالت هاور
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
