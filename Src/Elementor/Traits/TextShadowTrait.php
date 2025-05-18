<?php
/**
 * File: TextShadowTrait.php
 * Path: src/Elementor/Traits/
 * Description:
 *   مدیریت تنظیمات سایه متن شامل:
 *   - رنگ سایه
 *   - میزان تاری
 *   - زاویه سایه
 *   - فاصله افقی و عمودی
 * Author: Kiya Holding
 */

namespace Cardifa\Elementor\Traits;

use Elementor\Group_Control_Text_Shadow;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // جلوگیری از دسترسی مستقیم

trait TextShadowTrait {

    /**
     * ثبت تنظیمات سایه متن
     *
     * @param string $id شناسه کنترل
     * @param string $selector سلکتور CSS برای اعمال استایل‌ها
     */
    protected function register_text_shadow_controls(
        string $id = 'text_shadow',
        string $selector = '{{WRAPPER}} .cardifa-text-shadow'
    ) {
        // فعال‌سازی سایه متن
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'     => "{$id}_control",
                'label'    => __( 'سایه متن', 'cardifa' ),
                'selector' => $selector,
            ]
        );

        // رنگ سایه
        $this->add_control(
            "{$id}_color",
            [
                'label'     => __( 'رنگ سایه', 'cardifa' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    $selector => 'text-shadow: {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} {{VALUE}};',
                ],
            ]
        );

        // میزان تاری سایه
        $this->add_control(
            "{$id}_blur",
            [
                'label'      => __( 'میزان تاری سایه', 'cardifa' ),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ],
                ],
                'selectors'  => [
                    $selector => 'text-shadow: 0px 0px {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // زاویه سایه
        $this->add_control(
            "{$id}_angle",
            [
                'label'      => __( 'زاویه سایه (درجه)', 'cardifa' ),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'deg' => [
                        'min' => 0,
                        'max' => 360,
                        'step' => 1,
                    ],
                ],
                'selectors'  => [
                    $selector => 'filter: drop-shadow({{SIZE}}{{UNIT}});',
                ],
            ]
        );

        // فاصله افقی سایه
        $this->add_control(
            "{$id}_horizontal_offset",
            [
                'label'      => __( 'فاصله افقی سایه (پیکسل)', 'cardifa' ),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => -50,
                        'max' => 50,
                        'step' => 1,
                    ],
                ],
                'selectors'  => [
                    $selector => 'text-shadow: {{SIZE}}{{UNIT}} 0px;',
                ],
            ]
        );

        // فاصله عمودی سایه
        $this->add_control(
            "{$id}_vertical_offset",
            [
                'label'      => __( 'فاصله عمودی سایه (پیکسل)', 'cardifa' ),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => -50,
                        'max' => 50,
                        'step' => 1,
                    ],
                ],
                'selectors'  => [
                    $selector => 'text-shadow: 0px {{SIZE}}{{UNIT}};',
                ],
            ]
        );
    }
}
