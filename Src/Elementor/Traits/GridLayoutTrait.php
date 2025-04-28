<?php
/**
 * File: GridLayoutTrait.php
 * Path: src/Elementor/Traits/
 * Description:
 *   مدیریت تنظیمات چیدمان شبکه‌ای شامل:
 *   • تعداد ستون‌ها و ردیف‌ها
 *   • فاصله بین ستون‌ها و ردیف‌ها
 *   • چینش آیتم‌ها
 *   • تنظیمات واکنش‌گرا
 * Author: Kiya Holding
 */

namespace Cardifa\Elementor\Traits;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // جلوگیری از دسترسی مستقیم

trait GridLayoutTrait {

    /**
     * ثبت تنظیمات چیدمان شبکه‌ای
     *
     * @param string $id شناسه کنترل
     * @param string $selector سلکتور CSS برای اعمال استایل‌ها
     */
    protected function register_grid_layout_controls(
        string $id = 'grid_layout',
        string $selector = '{{WRAPPER}} .cardifa-grid'
    ) {
        // تعداد ستون‌ها
        $this->add_responsive_control(
            "{$id}_columns",
            [
                'label'      => __( 'تعداد ستون‌ها', 'cardifa' ),
                'type'       => Controls_Manager::NUMBER,
                'default'    => 3,
                'min'        => 1,
                'max'        => 12,
                'selectors'  => [
                    $selector => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
                ],
            ]
        );

        // فاصله بین ستون‌ها
        $this->add_responsive_control(
            "{$id}_column_gap",
            [
                'label'      => __( 'فاصله بین ستون‌ها', 'cardifa' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', '%' ],
                'range'      => [
                    'px' => [ 'min' => 0, 'max' => 100, 'step' => 1 ],
                ],
                'selectors'  => [
                    $selector => 'grid-column-gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // تعداد ردیف‌ها
        $this->add_responsive_control(
            "{$id}_rows",
            [
                'label'      => __( 'تعداد ردیف‌ها', 'cardifa' ),
                'type'       => Controls_Manager::NUMBER,
                'default'    => 2,
                'min'        => 1,
                'max'        => 12,
                'selectors'  => [
                    $selector => 'grid-template-rows: repeat({{VALUE}}, auto);',
                ],
            ]
        );

        // فاصله بین ردیف‌ها
        $this->add_responsive_control(
            "{$id}_row_gap",
            [
                'label'      => __( 'فاصله بین ردیف‌ها', 'cardifa' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', '%' ],
                'range'      => [
                    'px' => [ 'min' => 0, 'max' => 100, 'step' => 1 ],
                ],
                'selectors'  => [
                    $selector => 'grid-row-gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // چینش آیتم‌ها
        $this->add_control(
            "{$id}_alignment",
            [
                'label'   => __( 'چینش آیتم‌ها', 'cardifa' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'start'  => __( 'شروع (Start)', 'cardifa' ),
                    'center' => __( 'مرکز (Center)', 'cardifa' ),
                    'end'    => __( 'پایان (End)', 'cardifa' ),
                    'stretch'=> __( 'کشیده (Stretch)', 'cardifa' ),
                ],
                'default' => 'start',
                'selectors' => [
                    $selector => 'align-items: {{VALUE}};',
                ],
            ]
        );
    }
}
