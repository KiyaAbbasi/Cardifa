<?php
/**
 * File: BorderAndShadowTrait.php
 * Path: src/Elementor/Traits/
 * Description:
 *   مدیریت تنظیمات حاشیه و سایه شامل:
 *   • عرض، رنگ، و استایل حاشیه
 *   • شعاع گوشه‌ها (Border Radius)
 *   • سایه (Box Shadow)
 *   • تنظیمات هاور
 *   • پشتیبانی از واکنش‌گرایی
 * Author: Kiya Holding
 */

namespace Cardifa\Elementor\Traits;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

if ( ! defined( 'ABSPATH' ) ) exit; // جلوگیری از دسترسی مستقیم

trait BorderAndShadowTrait {

    /**
     * ثبت تنظیمات حاشیه و سایه
     *
     * @param string $id شناسه کنترل
     * @param string $selector سلکتور CSS برای اعمال استایل‌ها
     */
    protected function register_border_and_shadow_controls(
        string $id = 'border_shadow',
        string $selector = '{{WRAPPER}}'
    ) {
        // حاشیه
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => "{$id}_border",
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

        // سایه
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => "{$id}_shadow",
                'label'    => __( 'سایه', 'cardifa' ),
                'selector' => $selector,
            ]
        );

        // حاشیه در هاور
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => "{$id}_hover_border",
                'label'    => __( 'حاشیه در هاور', 'cardifa' ),
                'selector' => $selector . ':hover',
            ]
        );

        // سایه در هاور
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => "{$id}_hover_shadow",
                'label'    => __( 'سایه در هاور', 'cardifa' ),
                'selector' => $selector . ':hover',
            ]
        );
    }
}
