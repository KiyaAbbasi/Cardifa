<?php
/**
 * File: DevToolsTrait.php
 * Path: src/Elementor/Traits/
 * Description:
 *   ابزارهای توسعه و دیباگ شامل:
 *   • فعال‌سازی حالت دیباگ.
 *   • نمایش لاگ‌ها و اطلاعات داخلی.
 *   • پروفایلینگ زمان بارگذاری.
 * Author: Kiya Holding
 */

namespace Cardifa\Elementor\Traits;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // جلوگیری از دسترسی مستقیم

trait DevToolsTrait {

    /**
     * ثبت تنظیمات ابزارهای توسعه
     *
     * @param string $id شناسه کنترل
     */
    protected function register_devtools_controls(string $id = 'devtools') {
        // فعال‌سازی حالت دیباگ
        $this->add_control(
            "{$id}_debug_mode",
            [
                'label'        => __( 'فعال‌سازی حالت دیباگ', 'cardifa' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'فعال', 'cardifa' ),
                'label_off'    => __( 'غیرفعال', 'cardifa' ),
                'return_value' => 'yes',
                'default'      => 'no',
            ]
        );

        // نمایش لاگ‌ها
        $this->add_control(
            "{$id}_logs",
            [
                'label'       => __( 'نمایش لاگ‌ها', 'cardifa' ),
                'type'        => Controls_Manager::TEXTAREA,
                'description' => __( 'لاگ‌های داخلی ویجت.', 'cardifa' ),
                'condition'   => [
                    "{$id}_debug_mode" => 'yes',
                ],
            ]
        );

        // پروفایلینگ زمان بارگذاری
        $this->add_control(
            "{$id}_profiling",
            [
                'label'        => __( 'پروفایلینگ زمان بارگذاری', 'cardifa' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'فعال', 'cardifa' ),
                'label_off'    => __( 'غیرفعال', 'cardifa' ),
                'return_value' => 'yes',
                'default'      => 'no',
                'condition'    => [
                    "{$id}_debug_mode" => 'yes',
                ],
            ]
        );
    }
}
