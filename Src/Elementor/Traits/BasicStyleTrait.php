<?php
/**
 * File: BasicStyleTrait.php
 * Location: src/Elementor/Traits/
 * Desc: گروه کنترل‌های استایل پایه شامل:
 *   • Typography (فونت، اندازه، وزن، فاصله خطوط/حروف)
 *   • Text Color
 *   • Background (Classic, Gradient, Video)
 *   • Border (width, style, color)
 *   • Border Radius (هر گوشه جداگانه)
 *   • Box Shadow
 *   • Text Shadow
 *   • CSS Filters (blur, brightness, contrast، …)
 *   • Transition (duration, delay, property, timing-function)
 *   • Hover States برای همهٔ موارد بالا
 * Author: Kiya Holding
 */

namespace Cardifa\Elementor\Traits;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Css_Filter;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

trait BasicStyleTrait {

    /**
     * ثبت همهٔ کنترل‌های استایل پایه
     */
    protected function register_basic_style_controls() {
        // Typography
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'typography',
                'label'    => __( 'تایپوگرافی', 'cardifa' ),
                'selector' => '{{WRAPPER}}',
            ]
        );

        // Text Color
        $this->add_control(
            'text_color',
            [
                'label'     => __( 'رنگ متن', 'cardifa' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Background
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'background',
                'label'    => __( 'پس‌زمینه', 'cardifa' ),
                'types'    => [ 'classic', 'gradient', 'video' ],
                'selector' => '{{WRAPPER}}',
            ]
        );

        // Border
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'border',
                'label'    => __( 'حاشیه', 'cardifa' ),
                'selector' => '{{WRAPPER}}',
            ]
        );

        // Border Radius
        $this->add_responsive_control(
            'border_radius',
            [
                'label'      => __( 'شعاع حاشیه', 'cardifa' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors'  => [
                    '{{WRAPPER}}' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Box Shadow
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'box_shadow',
                'label'    => __( 'سایه جعبه', 'cardifa' ),
                'selector' => '{{WRAPPER}}',
            ]
        );

        // Text Shadow
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'     => 'text_shadow',
                'label'    => __( 'سایه متن', 'cardifa' ),
                'selector' => '{{WRAPPER}}',
            ]
        );

        // CSS Filters
        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name'     => 'css_filters',
                'label'    => __( 'فیلترهای CSS', 'cardifa' ),
                'selector' => '{{WRAPPER}} img, {{WRAPPER}}',
            ]
        );

        // Transition
        $this->add_control(
            'transition_duration',
            [
                'label'   => __( 'مدت انتقال (ثانیه)', 'cardifa' ),
                'type'    => Controls_Manager::SLIDER,
                'default' => [ 'size' => 0.3 ],
                'range'   => [ 'px' => [ 'min' => 0, 'max' => 5, 'step' => 0.1 ] ],
                'selectors' => [ '{{WRAPPER}}' => 'transition-duration: {{SIZE}}s;' ],
            ]
        );

        $this->add_control(
            'transition_timing_function',
            [
                'label'     => __( 'نوع انتقال', 'cardifa' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    'ease'       => __( 'Ease', 'cardifa' ),
                    'ease-in'    => __( 'Ease-In', 'cardifa' ),
                    'ease-out'   => __( 'Ease-Out', 'cardifa' ),
                    'ease-in-out'=> __( 'Ease-In-Out', 'cardifa' ),
                    'linear'     => __( 'Linear', 'cardifa' ),
                ],
                'default'   => 'ease',
                'selectors' => [ '{{WRAPPER}}' => 'transition-timing-function: {{VALUE}};' ],
            ]
        );

        $this->add_control(
            'transition_property',
            [
                'label'     => __( 'ویژگی انتقال', 'cardifa' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => 'all',
                'selectors' => [ '{{WRAPPER}}' => 'transition-property: {{VALUE}};' ],
            ]
        );

        $this->add_control(
            'transition_delay',
            [
                'label'   => __( 'تأخیر انتقال (ثانیه)', 'cardifa' ),
                'type'    => Controls_Manager::SLIDER,
                'default' => [ 'size' => 0 ],
                'range'   => [ 'px' => [ 'min' => 0, 'max' => 5, 'step' => 0.1 ] ],
                'selectors' => [ '{{WRAPPER}}' => 'transition-delay: {{SIZE}}s;' ],
            ]
        );
    }
}
