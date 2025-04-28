<?php
/**
 * File: StickyTrait.php
 * Path: src/Elementor/Traits/
 * Description:
 *   مدیریت تنظیمات چسبندگی شامل:
 *   • تنظیم موقعیت چسبندگی.
 *   • فعال‌سازی در دستگاه‌های مختلف.
 *   • پشتیبانی از واکنش‌گرایی.
 * Author: Kiya Holding
 */

namespace Cardifa\Elementor\Traits;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // جلوگیری از دسترسی مستقیم

trait StickyTrait {

    /**
     * ثبت تنظیمات چسبندگی
     *
     * @param string $id شناسه کنترل
     * @param string $selector سلکتور CSS برای اعمال استایل‌ها
     */
    protected function register_sticky_controls(
        string $id = 'sticky',
        string $selector = '{{WRAPPER}} .cardifa-sticky'
    ) {
        // فعال‌سازی چسبندگی
        $this->add_control(
            "{$id}_enable",
            [
                'label'        => __( 'فعال‌سازی چسبندگی', 'cardifa' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'فعال', 'cardifa' ),
                'label_off'    => __( 'غیرفعال', 'cardifa' ),
                'return_value' => 'yes',
                'default'      => 'no',
                'prefix_class' => 'cardifa-sticky-',
            ]
        );

        // تنظیم موقعیت چسبندگی
        $this->add_control(
            "{$id}_position",
            [
                'label'   => __( 'موقعیت چسبندگی', 'cardifa' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'top'    => __( 'بالا (Top)', 'cardifa' ),
                    'bottom' => __( 'پایین (Bottom)', 'cardifa' ),
                    'left'   => __( 'چپ (Left)', 'cardifa' ),
                    'right'  => __( 'راست (Right)', 'cardifa' ),
                ],
                'default' => 'top',
                'selectors' => [
                    $selector => 'position: sticky; {{VALUE}}: 0;',
                ],
                'condition' => [
                    "{$id}_enable" => 'yes',
                ],
            ]
        );

        // تنظیم چسبندگی در دستگاه‌های مختلف
        $this->add_responsive_control(
            "{$id}_responsive",
            [
                'label'        => __( 'واکنش‌گرایی', 'cardifa' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'فعال', 'cardifa' ),
                'label_off'    => __( 'غیرفعال', 'cardifa' ),
                'return_value' => 'yes',
                'default'      => 'yes',
                'condition'    => [
                    "{$id}_enable" => 'yes',
                ],
            ]
        );
    }
}
