<?php
/**
 * File: DataBindingTrait.php
 * Path: src/Elementor/Traits/
 * Description:
 *   مدیریت اتصال داده‌ها شامل:
 *   • اتصال به منابع داده داینامیک.
 *   • مدیریت JSON، API و دیتابیس.
 *   • بروزرسانی خودکار داده‌ها.
 * Author: Kiya Holding
 */

namespace Cardifa\Elementor\Traits;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // جلوگیری از دسترسی مستقیم

trait DataBindingTrait {

    /**
     * ثبت تنظیمات اتصال داده‌ها
     *
     * @param string $id شناسه کنترل
     */
    protected function register_data_binding_controls(string $id = 'data_binding') {
        // منبع داده
        $this->add_control(
            "{$id}_source",
            [
                'label'   => __( 'منبع داده', 'cardifa' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'json'  => __( 'JSON', 'cardifa' ),
                    'api'   => __( 'API', 'cardifa' ),
                    'db'    => __( 'دیتابیس', 'cardifa' ),
                ],
                'default' => 'json',
            ]
        );

        // آدرس منبع داده
        $this->add_control(
            "{$id}_source_url",
            [
                'label'       => __( 'آدرس منبع داده', 'cardifa' ),
                'type'        => Controls_Manager::TEXT,
                'placeholder' => __( 'https://example.com/data.json', 'cardifa' ),
                'condition'   => [
                    "{$id}_source" => [ 'json', 'api' ],
                ],
            ]
        );

        // بروزرسانی خودکار
        $this->add_control(
            "{$id}_auto_update",
            [
                'label'        => __( 'بروزرسانی خودکار', 'cardifa' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'فعال', 'cardifa' ),
                'label_off'    => __( 'غیرفعال', 'cardifa' ),
                'return_value' => 'yes',
                'default'      => 'no',
            ]
        );
    }
}
