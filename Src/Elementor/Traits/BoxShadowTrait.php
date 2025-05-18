<?php
/**
 * File: BoxShadowTrait.php
 * Path: src/Elementor/Traits/
 * Description:
 *   مدیریت تنظیمات سایه جعبه شامل:
 *   - افست، رنگ، شفافیت، پخش و تاری
 *   - تنظیمات هاور
 *   - پشتیبانی از واکنش‌گرایی
 * Author: Kiya Holding
 */

namespace Cardifa\Elementor\Traits;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;

if ( ! defined( 'ABSPATH' ) ) exit; // جلوگیری از دسترسی مستقیم

trait BoxShadowTrait {

    /**
     * ثبت تنظیمات سایه جعبه
     *
     * @param string $id شناسه کنترل
     * @param string $selector سلکتور CSS برای اعمال استایل‌ها
     */
    protected function register_box_shadow_controls(
        string $id = 'box_shadow',
        string $selector = '{{WRAPPER}} .cardifa-box-shadow'
    ) {
        // تنظیمات سایه
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => $id,
                'label'    => __( 'سایه جعبه', 'cardifa' ),
                'selector' => $selector,
            ]
        );

        // تنظیمات سایه در حالت هاور
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => "{$id}_hover",
                'label'    => __( 'سایه جعبه در هاور', 'cardifa' ),
                'selector' => $selector . ':hover',
            ]
        );
    }
}
