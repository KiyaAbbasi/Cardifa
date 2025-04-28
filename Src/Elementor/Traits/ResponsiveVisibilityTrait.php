<?php
/**
 * File: ResponsiveVisibilityTrait.php
 * Path: src/Elementor/Traits/
 * Description:
 *   مدیریت نمایش و مخفی کردن المان‌ها بر اساس تنظیمات واکنش‌گرایی.
 *   • مخفی کردن در دسکتاپ، تبلت، موبایل.
 *   • تنظیمات پیشرفته برای وضعیت‌های مختلف.
 *   • پشتیبانی از کلاس‌های CSS برای مدیریت نمایش.
 * Author: Kiya Holding
 */

namespace Cardifa\Elementor\Traits;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // جلوگیری از دسترسی مستقیم

trait ResponsiveVisibilityTrait {

    /**
     * ثبت تنظیمات نمایش واکنش‌گرا
     *
     * @param string $id شناسه کنترل
     */
    protected function register_responsive_visibility_controls(string $id = 'responsive_visibility') {
        // نمایش در دسکتاپ
        $this->add_control(
            "{$id}_desktop",
            [
                'label'        => __( 'نمایش در دسکتاپ', 'cardifa' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'فعال', 'cardifa' ),
                'label_off'    => __( 'غیرفعال', 'cardifa' ),
                'return_value' => 'yes',
                'default'      => 'yes',
                'prefix_class' => 'cardifa-visibility-desktop-',
            ]
        );

        // نمایش در تبلت
        $this->add_control(
            "{$id}_tablet",
            [
                'label'        => __( 'نمایش در تبلت', 'cardifa' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'فعال', 'cardifa' ),
                'label_off'    => __( 'غیرفعال', 'cardifa' ),
                'return_value' => 'yes',
                'default'      => 'yes',
                'prefix_class' => 'cardifa-visibility-tablet-',
            ]
        );

        // نمایش در موبایل
        $this->add_control(
            "{$id}_mobile",
            [
                'label'        => __( 'نمایش در موبایل', 'cardifa' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'فعال', 'cardifa' ),
                'label_off'    => __( 'غیرفعال', 'cardifa' ),
                'return_value' => 'yes',
                'default'      => 'yes',
                'prefix_class' => 'cardifa-visibility-mobile-',
            ]
        );

        // تنظیمات پیشرفته برای وضعیت‌های نمایش
        $this->add_control(
            "{$id}_custom_class",
            [
                'label'       => __( 'کلاس‌های سفارشی', 'cardifa' ),
                'type'        => Controls_Manager::TEXT,
                'description' => __( 'کلاس‌های CSS سفارشی برای مدیریت نمایش.', 'cardifa' ),
                'dynamic'     => [ 'active' => true ],
            ]
        );
    }
}
