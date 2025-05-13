<?php
/**
 * File: FormValidationTrait.php
 * Path: src/Elementor/Traits/
 * Description:
 *   مدیریت اعتبارسنجی فرم:
 *   • اعتبارسنجی فیلدهای فرم.
 *   • نمایش پیام‌های خطا.
 *   • تنظیمات پیشرفته.
 * Author: Kiya Holding
 */

namespace Cardifa\Elementor\Traits;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // جلوگیری از دسترسی مستقیم

trait FormValidationTrait {

    /**
     * ثبت تنظیمات اعتبارسنجی فرم‌ها
     *
     * @param string $id شناسه کنترل
     */
    protected function register_form_validation_controls(string $id = 'form_validation') {
        // فعال‌سازی اعتبارسنجی
        $this->add_control(
            "{$id}_enable_validation",
            [
                'label'        => __( 'فعال‌سازی اعتبارسنجی', 'cardifa' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'فعال', 'cardifa' ),
                'label_off'    => __( 'غیرفعال', 'cardifa' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        // پیام خطای ایمیل
        $this->add_control(
            "{$id}_email_error",
            [
                'label'       => __( 'پیام خطای ایمیل', 'cardifa' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => __( 'لطفاً یک ایمیل معتبر وارد کنید.', 'cardifa' ),
                'condition'   => [
                    "{$id}_enable_validation" => 'yes',
                ],
            ]
        );

        // پیام خطای شماره تماس
        $this->add_control(
            "{$id}_phone_error",
            [
                'label'       => __( 'پیام خطای شماره تماس', 'cardifa' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => __( 'لطفاً یک شماره تماس معتبر وارد کنید.', 'cardifa' ),
                'condition'   => [
                    "{$id}_enable_validation" => 'yes',
                ],
            ]
        );
    }
}
