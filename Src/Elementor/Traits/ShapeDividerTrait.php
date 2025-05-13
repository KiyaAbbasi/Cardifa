<?php
/**
 * File: ShapeDividerTrait.php
 * Path: src/Elementor/Traits/
 * Description:
 *   مدیریت تنظیمات Shape Divider شامل:
 *   - انتخاب نوع جداکننده
 *   - رنگ جداکننده
 *   - اندازه و موقعیت
 * Author: Kiya Holding
 */

namespace Cardifa\Elementor\Traits;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // جلوگیری از دسترسی مستقیم

trait ShapeDividerTrait {

    /**
     * ثبت تنظیمات Shape Divider
     *
     * @param string $id شناسه کنترل
     * @param string $selector سلکتور CSS برای اعمال استایل‌ها
     */
    protected function register_shape_divider_controls(
        string $id = 'shape_divider',
        string $selector = '{{WRAPPER}} .cardifa-shape-divider'
    ) {
        // فعال‌سازی Shape Divider
        $this->add_control(
            "{$id}_enabled",
            [
                'label'        => __( 'فعال‌سازی Shape Divider', 'cardifa' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'فعال', 'cardifa' ),
                'label_off'    => __( 'غیرفعال', 'cardifa' ),
                'return_value' => 'yes',
                'default'      => 'no',
            ]
        );

        // انتخاب نوع جداکننده
        $this->add_control(
            "{$id}_type",
            [
                'label'   => __( 'نوع جداکننده', 'cardifa' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'none'        => __( 'بدون جداکننده', 'cardifa' ),
                    'waves'       => __( 'امواج (Waves)', 'cardifa' ),
                    'mountains'   => __( 'کوه‌ها (Mountains)', 'cardifa' ),
                    'zigzag'      => __( 'زیگزاگ (Zigzag)', 'cardifa' ),
                    'curve'       => __( 'منحنی (Curve)', 'cardifa' ),
                    'arrow'       => __( 'فلش (Arrow)', 'cardifa' ),
                ],
                'default' => 'none',
            ]
        );

        // رنگ جداکننده
        $this->add_control(
            "{$id}_color",
            [
                'label'     => __( 'رنگ جداکننده', 'cardifa' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#CCCCCC',
                'selectors' => [
                    $selector => 'fill: {{VALUE}};',
                ],
            ]
        );

        // اندازه جداکننده
        $this->add_control(
            "{$id}_size",
            [
                'label'      => __( 'اندازه جداکننده', 'cardifa' ),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 500,
                        'step' => 1,
                    ],
                ],
                'selectors'  => [
                    $selector => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // موقعیت جداکننده
        $this->add_control(
            "{$id}_position",
            [
                'label'   => __( 'موقعیت جداکننده', 'cardifa' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'top'    => __( 'بالا', 'cardifa' ),
                    'bottom' => __( 'پایین', 'cardifa' ),
                ],
                'default' => 'top',
            ]
        );

        // پیش‌نمایش Shape Divider
        $this->add_control(
            "{$id}_preview",
            [
                'label'        => __( 'پیش‌نمایش Shape Divider', 'cardifa' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'فعال', 'cardifa' ),
                'label_off'    => __( 'غیرفعال', 'cardifa' ),
                'return_value' => 'yes',
                'default'      => 'no',
            ]
        );
    }
}
