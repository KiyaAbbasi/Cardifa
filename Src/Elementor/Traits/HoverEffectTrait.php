<?php
/**
 * File: HoverEffectTrait.php
 * Path: src/Elementor/Traits/
 * Description:
 *   مدیریت تنظیمات افکت‌های هاور شامل:
 *   - تغییر رنگ و پس‌زمینه
 *   - مقیاس (Scale)
 *   - چرخش (Rotation)
 *   - شفافیت (Opacity)
 *   - تنظیمات Transition
 * Author: Kiya Holding
 */

namespace Cardifa\Elementor\Traits;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // جلوگیری از دسترسی مستقیم

trait HoverEffectTrait {

    /**
     * ثبت تنظیمات افکت‌های هاور
     *
     * @param string $id شناسه کنترل
     * @param string $selector سلکتور CSS برای اعمال استایل‌ها
     */
    protected function register_hover_effect_controls(
        string $id = 'hover_effect',
        string $selector = '{{WRAPPER}} .cardifa-hoverable'
    ) {
        // تغییر رنگ در هاور
        $this->add_control(
            "{$id}_hover_color",
            [
                'label'     => __( 'رنگ در هاور', 'cardifa' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [ $selector . ':hover' => 'color: {{VALUE}};' ],
            ]
        );

        // تغییر پس‌زمینه در هاور
        $this->add_control(
            "{$id}_hover_background",
            [
                'label'     => __( 'پس‌زمینه در هاور', 'cardifa' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [ $selector . ':hover' => 'background-color: {{VALUE}};' ],
            ]
        );

        // افکت مقیاس (Scale)
        $this->add_control(
            "{$id}_hover_scale",
            [
                'label'      => __( 'مقیاس در هاور', 'cardifa' ),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [ 'em' => [ 'min' => 0.5, 'max' => 2, 'step' => 0.1 ] ],
                'selectors'  => [ $selector . ':hover' => 'transform: scale({{SIZE}});' ],
                'default'    => [ 'size' => 1, 'unit' => '' ],
            ]
        );

        // افکت چرخش (Rotation)
        $this->add_control(
            "{$id}_hover_rotation",
            [
                'label'      => __( 'چرخش در هاور', 'cardifa' ),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [ 'deg' => [ 'min' => 0, 'max' => 360 ] ],
                'selectors'  => [ $selector . ':hover' => 'transform: rotate({{SIZE}}deg);' ],
                'default'    => [ 'size' => 0, 'unit' => 'deg' ],
            ]
        );

        // افکت شفافیت (Opacity)
        $this->add_control(
            "{$id}_hover_opacity",
            [
                'label'      => __( 'شفافیت در هاور', 'cardifa' ),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [ 'px' => [ 'min' => 0, 'max' => 1, 'step' => 0.1 ] ],
                'selectors'  => [ $selector . ':hover' => 'opacity: {{SIZE}};' ],
            ]
        );

        // تنظیمات Transition
        $this->add_control(
            "{$id}_transition_duration",
            [
                'label'      => __( 'مدت‌زمان Transition', 'cardifa' ),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [ 's' => [ 'min' => 0, 'max' => 5, 'step' => 0.1 ] ],
                'selectors'  => [ $selector => 'transition-duration: {{SIZE}}s;' ],
            ]
        );

        $this->add_control(
            "{$id}_transition_timing",
            [
                'label'     => __( 'نوع Transition', 'cardifa' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    'ease'       => __( 'Ease', 'cardifa' ),
                    'ease-in'    => __( 'Ease-In', 'cardifa' ),
                    'ease-out'   => __( 'Ease-Out', 'cardifa' ),
                    'ease-in-out'=> __( 'Ease-In-Out', 'cardifa' ),
                    'linear'     => __( 'Linear', 'cardifa' ),
                ],
                'default'   => 'ease',
                'selectors' => [ $selector => 'transition-timing-function: {{VALUE}};' ],
            ]
        );

        $this->add_control(
            "{$id}_transition_delay",
            [
                'label'      => __( 'تأخیر Transition', 'cardifa' ),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [ 's' => [ 'min' => 0, 'max' => 5, 'step' => 0.1 ] ],
                'selectors'  => [ $selector => 'transition-delay: {{SIZE}}s;' ],
            ]
        );
    }
}
