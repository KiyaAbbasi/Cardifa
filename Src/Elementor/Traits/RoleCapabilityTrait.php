<?php
/**
 * File: RoleCapabilityTrait.php
 * Path: src/Elementor/Traits/
 * Description:
 *   مدیریت نقش‌ها و دسترسی‌ها شامل:
 *   • نمایش یا مخفی کردن ویجت‌ها بر اساس نقش کاربر.
 *   • تنظیم قابلیت‌های دسترسی.
 *   • پشتیبانی از نقش‌های سفارشی.
 * Author: Kiya Holding
 */

namespace Cardifa\Elementor\Traits;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // جلوگیری از دسترسی مستقیم

trait RoleCapabilityTrait {

    /**
     * ثبت تنظیمات نقش و دسترسی
     *
     * @param string $id شناسه کنترل
     */
    protected function register_role_capability_controls(string $id = 'role_capability') {
        // محدودیت بر اساس نقش کاربر
        $this->add_control(
            "{$id}_role_restriction",
            [
                'label'       => __( 'محدودیت نقش کاربر', 'cardifa' ),
                'type'        => Controls_Manager::SELECT2,
                'options'     => [
                    'administrator' => __( 'مدیر کل', 'cardifa' ),
                    'editor'        => __( 'ویرایشگر', 'cardifa' ),
                    'author'        => __( 'نویسنده', 'cardifa' ),
                    'subscriber'    => __( 'مشترک', 'cardifa' ),
                ],
                'multiple'    => true,
                'description' => __( 'انتخاب نقش‌هایی که دسترسی دارند.', 'cardifa' ),
            ]
        );

        // قابلیت‌های دسترسی سفارشی
        $this->add_control(
            "{$id}_custom_capabilities",
            [
                'label'       => __( 'قابلیت‌های سفارشی', 'cardifa' ),
                'type'        => Controls_Manager::TEXT,
                'placeholder' => __( 'مثال: manage_options', 'cardifa' ),
                'description' => __( 'اضافه کردن قابلیت‌های دسترسی.', 'cardifa' ),
            ]
        );

        // نمایش یا مخفی کردن بر اساس نقش
        $this->add_control(
            "{$id}_visibility",
            [
                'label'        => __( 'نمایش/مخفی کردن', 'cardifa' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'نمایش', 'cardifa' ),
                'label_off'    => __( 'مخفی', 'cardifa' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );
    }
}
