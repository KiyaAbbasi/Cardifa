<?php
/**
 * File: PositionTrait.php
 * Path: src/Elementor/Traits/
 * Description:
 *   مدیریت تنظیمات موقعیت عناصر شامل:
 *   - موقعیت مطلق و نسبی
 *   - تنظیمات Z-Index
 *   - تراز عمودی و افقی
 *   - کنترل Offsets (Top, Bottom, Left, Right)
 * Author: Kiya Holding
 */

namespace Cardifa\Elementor\Traits;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // جلوگیری از دسترسی مستقیم

trait PositionTrait {

    /**
     * ثبت تنظیمات موقعیت
     *
     * @param string $id شناسه کنترل
     * @param string $selector سلکتور CSS برای اعمال استایل‌ها
     */
    protected function register_position_controls(
        string $id = 'position',
        string $selector = '{{WRAPPER}} .cardifa-position'
    ) {
        // انتخاب نوع موقعیت
        $this->add_control(
            "{$id}_type",
            [
                'label'   => __( 'نوع موقعیت', 'cardifa' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'static'   => __( 'Static', 'cardifa' ),
                    'relative' => __( 'Relative', 'cardifa' ),
                    'absolute' => __( 'Absolute', 'cardifa' ),
                    'fixed'    => __( 'Fixed', 'cardifa' ),
                    'sticky'   => __( 'Sticky', 'cardifa' ),
                ],
                'default' => 'static',
            ]
        );

        // تنظیم Z-Index
        $this->add_control(
            "{$id}_z_index",
            [
                'label'      => __( 'Z-Index', 'cardifa' ),
                'type'       => Controls_Manager::NUMBER,
                'default'    => 0,
                'min'        => -999,
                'max'        => 9999,
                'step'       => 1,
            ]
        );

        // تراز افقی
        $this->add_control(
            "{$id}_horizontal_align",
            [
                'label'   => __( 'تراز افقی', 'cardifa' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'left'   => __( 'چپ', 'cardifa' ),
                    'center' => __( 'وسط', 'cardifa' ),
                    'right'  => __( 'راست', 'cardifa' ),
                ],
                'default' => 'left',
                'selectors' => [
                    $selector => 'text-align: {{VALUE}};',
                ],
            ]
        );

        // تراز عمودی
        $this->add_control(
            "{$id}_vertical_align",
            [
                'label'   => __( 'تراز عمودی', 'cardifa' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'top'    => __( 'بالا', 'cardifa' ),
                    'middle' => __( 'وسط', 'cardifa' ),
                    'bottom' => __( 'پایین', 'cardifa' ),
                ],
                'default' => 'top',
            ]
        );

        // کنترل Offset (Top)
        $this->add_control(
            "{$id}_top",
            [
                'label'      => __( 'فاصله از بالا', 'cardifa' ),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => -500,
                        'max' => 500,
                        'step' => 1,
                    ],
                ],
                'selectors'  => [
                    $selector => 'top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // کنترل Offset (Bottom)
        $this->add_control(
            "{$id}_bottom",
            [
                'label'      => __( 'فاصله از پایین', 'cardifa' ),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => -500,
                        'max' => 500,
                        'step' => 1,
                    ],
                ],
                'selectors'  => [
                    $selector => 'bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // کنترل Offset (Left)
        $this->add_control(
            "{$id}_left",
            [
                'label'      => __( 'فاصله از چپ', 'cardifa' ),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => -500,
                        'max' => 500,
                        'step' => 1,
                    ],
                ],
                'selectors'  => [
                    $selector => 'left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // کنترل Offset (Right)
        $this->add_control(
            "{$id}_right",
            [
                'label'      => __( 'فاصله از راست', 'cardifa' ),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => -500,
                        'max' => 500,
                        'step' => 1,
                    ],
                ],
                'selectors'  => [
                    $selector => 'right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
    }
}
