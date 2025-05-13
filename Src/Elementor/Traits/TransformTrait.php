<?php
/**
 * File: TransformTrait.php
 * Path: src/Elementor/Traits/
 * Description:
 *   مدیریت تنظیمات Transform شامل:
 *   - چرخش (Rotate)
 *   - مقیاس‌دهی (Scale)
 *   - انتقال (Translate)
 *   - کج کردن (Skew)
 * Author: Kiya Holding
 */

namespace Cardifa\Elementor\Traits;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // جلوگیری از دسترسی مستقیم

trait TransformTrait {

    /**
     * ثبت تنظیمات Transform
     *
     * @param string $id شناسه کنترل
     * @param string $selector سلکتور CSS برای اعمال استایل‌ها
     */
    protected function register_transform_controls(
        string $id = 'transform',
        string $selector = '{{WRAPPER}} .cardifa-transform'
    ) {
        // چرخش (Rotate)
        $this->add_control(
            "{$id}_rotate",
            [
                'label'      => __( 'چرخش (Rotate)', 'cardifa' ),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'deg' => [
                        'min' => -360,
                        'max' => 360,
                        'step' => 1,
                    ],
                ],
                'selectors'  => [
                    $selector => 'transform: rotate({{SIZE}}deg);',
                ],
            ]
        );

        // مقیاس‌دهی (Scale)
        $this->add_control(
            "{$id}_scale",
            [
                'label'      => __( 'مقیاس‌دهی (Scale)', 'cardifa' ),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 0.1,
                        'max' => 3,
                        'step' => 0.1,
                    ],
                ],
                'selectors'  => [
                    $selector => 'transform: scale({{SIZE}});',
                ],
            ]
        );

        // انتقال افقی (Translate X)
        $this->add_control(
            "{$id}_translate_x",
            [
                'label'      => __( 'انتقال افقی (Translate X)', 'cardifa' ),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => -500,
                        'max' => 500,
                        'step' => 1,
                    ],
                ],
                'selectors'  => [
                    $selector => 'transform: translateX({{SIZE}}px);',
                ],
            ]
        );

        // انتقال عمودی (Translate Y)
        $this->add_control(
            "{$id}_translate_y",
            [
                'label'      => __( 'انتقال عمودی (Translate Y)', 'cardifa' ),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => -500,
                        'max' => 500,
                        'step' => 1,
                    ],
                ],
                'selectors'  => [
                    $selector => 'transform: translateY({{SIZE}}px);',
                ],
            ]
        );

        // کج کردن افقی (Skew X)
        $this->add_control(
            "{$id}_skew_x",
            [
                'label'      => __( 'کج کردن افقی (Skew X)', 'cardifa' ),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'deg' => [
                        'min' => -90,
                        'max' => 90,
                        'step' => 1,
                    ],
                ],
                'selectors'  => [
                    $selector => 'transform: skewX({{SIZE}}deg);',
                ],
            ]
        );

        // کج کردن عمودی (Skew Y)
        $this->add_control(
            "{$id}_skew_y",
            [
                'label'      => __( 'کج کردن عمودی (Skew Y)', 'cardifa' ),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'deg' => [
                        'min' => -90,
                        'max' => 90,
                        'step' => 1,
                    ],
                ],
                'selectors'  => [
                    $selector => 'transform: skewY({{SIZE}}deg);',
                ],
            ]
        );
    }
}
