<?php
/**
 * File: DynamicTagsTrait.php
 * Path: src/Elementor/Traits/
 * Description:
 *   مدیریت تگ‌های داینامیک شامل:
 *   - افزودن و تنظیم تگ‌های پویا
 *   - پشتیبانی از انواع داده‌های داینامیک (متن، لینک، تصویر و غیره)
 *   - تنظیمات پیش‌نمایش
 *   - قابلیت‌های سفارشی‌سازی داینامیک
 * Author: Kiya Holding
 */

namespace Cardifa\Elementor\Traits;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // جلوگیری از دسترسی مستقیم

trait DynamicTagsTrait {

    /**
     * ثبت تنظیمات تگ‌های داینامیک
     *
     * @param string $id شناسه کنترل
     * @param string $label عنوان کنترل
     * @param array  $options تنظیمات اختیاری برای نوع داده‌ها و پیش‌نمایش
     */
    protected function register_dynamic_tag_controls(string $id = 'dynamic_tag', string $label = 'تگ داینامیک', array $options = []) {
        // تنظیم پیش‌فرض‌ها
        $defaults = [
            'types'       => [ 'text', 'url', 'image', 'html' ], // پشتیبانی از انواع داده
            'default'     => '',
            'description' => __( 'مقدار این فیلد می‌تواند از تگ‌های داینامیک پر شود.', 'cardifa' ),
            'preview'     => true, // فعال‌سازی پیش‌نمایش
            'required'    => false, // اجباری بودن مقدار
        ];
        $settings = array_merge($defaults, $options);

        // افزودن کنترل برای انتخاب تگ داینامیک
        $this->add_control(
            "{$id}_dynamic",
            [
                'label'        => __( $label, 'cardifa' ),
                'type'         => Controls_Manager::TEXT,
                'dynamic'      => [
                    'active' => true,
                ],
                'default'      => $settings['default'],
                'description'  => $settings['description'],
                'label_block'  => true,
            ]
        );

        // انتخاب نوع داده
        if (count($settings['types']) > 1) {
            $this->add_control(
                "{$id}_type",
                [
                    'label'   => __( 'نوع داده', 'cardifa' ),
                    'type'    => Controls_Manager::SELECT,
                    'options' => array_combine($settings['types'], array_map(function($type) {
                        switch ($type) {
                            case 'text': return __( 'متن', 'cardifa' );
                            case 'url': return __( 'لینک', 'cardifa' );
                            case 'image': return __( 'تصویر', 'cardifa' );
                            case 'html': return __( 'HTML', 'cardifa' );
                            default: return ucfirst($type);
                        }
                    }, $settings['types'])),
                    'default' => $settings['types'][0],
                ]
            );
        }

        // فعال‌سازی پیش‌نمایش
        if ($settings['preview']) {
            $this->add_control(
                "{$id}_preview",
                [
                    'label'        => __( 'پیش‌نمایش تگ داینامیک', 'cardifa' ),
                    'type'         => Controls_Manager::SWITCHER,
                    'label_on'     => __( 'فعال', 'cardifa' ),
                    'label_off'    => __( 'غیرفعال', 'cardifa' ),
                    'return_value' => 'yes',
                    'default'      => 'yes',
                ]
            );
        }

        // اعتبارسنجی مقدار (اختیاری)
        if ($settings['required']) {
            $this->add_control(
                "{$id}_required",
                [
                    'type'        => Controls_Manager::HIDDEN,
                    'default'     => 'yes',
                    'dynamic'     => [
                        'active' => true,
                    ],
                ]
            );
        }
    }

    /**
     * دریافت مقدار تگ داینامیک
     *
     * @param string $id شناسه کنترل
     * @return mixed مقدار تگ
     */
    protected function get_dynamic_tag_value(string $id) {
        $value = $this->get_settings("{$id}_dynamic");
        $type = $this->get_settings("{$id}_type");

        switch ($type) {
            case 'image':
                return wp_get_attachment_image_src($value, 'full');
            case 'url':
                return esc_url($value);
            case 'html':
                return wp_kses_post($value);
            case 'text':
            default:
                return sanitize_text_field($value);
        }
    }
}
