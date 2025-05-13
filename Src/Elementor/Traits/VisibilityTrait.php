<?php
/**
 * File: VisibilityTrait.php
 * Path: src/Elementor/Traits/
 * Description:
 *   مدیریت تنظیمات نمایش شامل:
 *   • نمایش در دستگاه‌های مختلف
 *   • نمایش بر اساس نقش کاربر
 *   • نمایش بر اساس تاریخ و زمان
 *   • نمایش در حالت‌هاور یا کلیک
 * Author: Kiya Holding
 */

namespace Cardifa\Elementor\Traits;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // جلوگیری از دسترسی مستقیم

trait VisibilityTrait {

    /**
     * ثبت تنظیمات نمایش
     *
     * @param string $id شناسه کنترل
     * @param string $selector سلکتور CSS برای اعمال استایل‌ها
     */
    protected function register_visibility_controls(
        string $id = 'visibility',
        string $selector = '{{WRAPPER}}'
    ) {
        // نمایش در دستگاه‌های مختلف
        $this->add_control(
            "{$id}_device_visibility",
            [
                'label'   => __( 'نمایش در دستگاه‌ها', 'cardifa' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    ''        => __( 'همه دستگاه‌ها', 'cardifa' ),
                    'desktop' => __( 'فقط دسکتاپ', 'cardifa' ),
                    'tablet'  => __( 'فقط تبلت', 'cardifa' ),
                    'mobile'  => __( 'فقط موبایل', 'cardifa' ),
                ],
                'default' => '',
                'prefix_class' => 'cardifa-visibility-',
            ]
        );

        // نمایش بر اساس نقش کاربر
        $this->add_control(
            "{$id}_user_role",
            [
                'label'   => __( 'نمایش برای نقش کاربر', 'cardifa' ),
                'type'    => Controls_Manager::SELECT2,
                'options' => [
                    'all'       => __( 'همه کاربران', 'cardifa' ),
                    'administrator' => __( 'مدیر', 'cardifa' ),
                    'editor'    => __( 'ویرایشگر', 'cardifa' ),
                    'author'    => __( 'نویسنده', 'cardifa' ),
                    'subscriber' => __( 'مشترک', 'cardifa' ),
                ],
                'default' => 'all',
                'multiple' => true,
                'label_block' => true,
            ]
        );

        // نمایش بر اساس تاریخ و زمان
        $this->add_control(
            "{$id}_schedule_visibility",
            [
                'label' => __( 'نمایش بر اساس زمان', 'cardifa' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __( 'فعال', 'cardifa' ),
                'label_off' => __( 'غیرفعال', 'cardifa' ),
                'return_value' => 'yes',
                'default' => '',
            ]
        );

        $this->add_control(
            "{$id}_start_date",
            [
                'label' => __( 'تاریخ شروع', 'cardifa' ),
                'type' => Controls_Manager::DATE_TIME,
                'condition' => [
                    "{$id}_schedule_visibility" => 'yes',
                ],
            ]
        );

        $this->add_control(
            "{$id}_end_date",
            [
                'label' => __( 'تاریخ پایان', 'cardifa' ),
                'type' => Controls_Manager::DATE_TIME,
                'condition' => [
                    "{$id}_schedule_visibility" => 'yes',
                ],
            ]
        );

        // نمایش در حالت‌هاور
        $this->add_control(
            "{$id}_hover_visibility",
            [
                'label' => __( 'نمایش در هاور', 'cardifa' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __( 'فعال', 'cardifa' ),
                'label_off' => __( 'غیرفعال', 'cardifa' ),
                'return_value' => 'yes',
                'default' => '',
                'selectors' => [
                    $selector . ':hover' => 'visibility: visible;',
                    $selector => 'visibility: hidden;',
                ],
            ]
        );
    }
}
