<?php
/**
 * File: BorderTrait.php
 * Path: src/Elementor/Traits/
 * Description:
 *   مدیریت تنظیمات حاشیه شامل:
 *   - عرض، رنگ و استایل حاشیه
 *   - شعاع گوشه‌ها
 *   - تنظیمات هاور
 *   - پشتیبانی از واکنش‌گرایی
 * Author: Kiya Holding
 */

namespace Cardifa\Elementor\Traits;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) exit; // جلوگیری از دسترسی مستقیم

trait BorderTrait {

    /**
     * ثبت تنظیمات حاشیه
     *
     * @param string $id شناسه کنترل
     * @param string $selector سلکتور CSS برای اعمال استایل‌ها
     */
    protected function register_border_controls(
        string $id = 'border',
        string $selector = '{{WRAPPER}} .cardifa-border'
    ) {
        // تنظیمات حاشیه
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => $id,
                'label'    => __( 'حاشیه', 'cardifa' ),
                'selector' => $selector,
            ]
        );

        // شعاع گوشه‌ها
        $this->add_responsive_control(
            "{$id}_radius",
            [
                'label'      => __( 'شعاع گوشه‌ها', 'cardifa' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors'  => [
                    $selector => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // رنگ حاشیه در حالت هاور
        $this->add_control(
            "{$id}_hover_color",
            [
                'label'     => __( 'رنگ حاشیه در هاور', 'cardifa' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [ $selector . ':hover' => 'border-color: {{VALUE}};' ],
            ]
        );

        // عرض حاشیه در حالت هاور
        $this->add_responsive_control(
            "{$id}_hover_width",
            [
                'label'      => __( 'عرض حاشیه در هاور', 'cardifa' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors'  => [
                    $selector . ':hover' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // استایل حاشیه در حالت هاور
        $this->add_control(
            "{$id}_hover_style",
            [
                'label'     => __( 'استایل حاشیه در هاور', 'cardifa' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    'solid'  => __( 'خط صاف', 'cardifa' ),
                    'dotted' => __( 'نقطه‌چین', 'cardifa' ),
                    'dashed' => __( 'خط‌چین', 'cardifa' ),
                    'double' => __( 'دوتایی', 'cardifa' ),
                    'groove' => __( 'حاشیه فرو رفته', 'cardifa' ),
                ],
                'default'   => 'solid',
                'selectors' => [ $selector . ':hover' => 'border-style: {{VALUE}};' ],
            ]
        );
    }
}
