<?php
/**
 * File: FilterTrait.php
 * Path: src/Elementor/Traits/
 * Description:
 *   مدیریت تنظیمات فیلترهای CSS شامل:
 *   • تاری (Blur)
 *   • روشنایی (Brightness)
 *   • کنتراست (Contrast)
 *   • اشباع (Saturation)
 *   • خاکستری (Grayscale)
 *   • فیلترهای هاور
 *   • پشتیبانی از واکنش‌گرایی
 * Author: Kiya Holding
 */

namespace Cardifa\Elementor\Traits;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Css_Filter;

if ( ! defined( 'ABSPATH' ) ) exit; // جلوگیری از دسترسی مستقیم

trait FilterTrait {

    /**
     * ثبت تنظیمات فیلترهای CSS
     *
     * @param string $id شناسه کنترل
     * @param string $selector سلکتور CSS برای اعمال استایل‌ها
     */
    protected function register_filter_controls(
        string $id = 'filter',
        string $selector = '{{WRAPPER}} img, {{WRAPPER}}'
    ) {
        // فیلترهای معمولی
        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name'     => $id,
                'label'    => __( 'فیلترهای CSS', 'cardifa' ),
                'selector' => $selector,
            ]
        );

        // فیلترهای هاور
        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name'     => "{$id}_hover",
                'label'    => __( 'فیلترهای CSS در هاور', 'cardifa' ),
                'selector' => $selector . ':hover',
            ]
        );
    }
}
