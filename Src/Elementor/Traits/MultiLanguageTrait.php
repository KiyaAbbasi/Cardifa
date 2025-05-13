<?php
/**
 * File: MultiLanguageTrait.php
 * Path: src/Elementor/Traits/
 * Description:
 *   مدیریت تنظیمات چندزبانه شامل:
 *   • پشتیبانی از پلاگین‌های WPML و Polylang.
 *   • ترجمه رشته‌ها.
 *   • تنظیمات زبان برای ویجت‌ها.
 *   • قابلیت ترجمه متون دلخواه.
 * Author: Kiya Holding
 */

namespace Cardifa\Elementor\Traits;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // جلوگیری از دسترسی مستقیم

trait MultiLanguageTrait {

    /**
     * ثبت تنظیمات چندزبانه
     *
     * @param string $id شناسه کنترل
     */
    protected function register_multilanguage_controls(string $id = 'multilanguage') {
        // فعال‌سازی چندزبانه
        $this->add_control(
            "{$id}_enable",
            [
                'label'        => __( 'فعال‌سازی چندزبانه', 'cardifa' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'فعال', 'cardifa' ),
                'label_off'    => __( 'غیرفعال', 'cardifa' ),
                'return_value' => 'yes',
                'default'      => 'no',
            ]
        );

        // انتخاب زبان
        $this->add_control(
            "{$id}_language",
            [
                'label'   => __( 'انتخاب زبان', 'cardifa' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'default'  => __( 'پیش‌فرض', 'cardifa' ),
                    'en'       => __( 'انگلیسی', 'cardifa' ),
                    'fa'       => __( 'فارسی', 'cardifa' ),
                ],
                'default' => 'default',
                'condition' => [
                    "{$id}_enable" => 'yes',
                ],
            ]
        );

        // ترجمه رشته‌ها
        $this->add_control(
            "{$id}_translations",
            [
                'label'       => __( 'ترجمه رشته‌ها', 'cardifa' ),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => [
                    [
                        'name'        => 'key',
                        'label'       => __( 'کلید', 'cardifa' ),
                        'type'        => Controls_Manager::TEXT,
                        'placeholder' => __( 'مثال: text_1', 'cardifa' ),
                    ],
                    [
                        'name'        => 'translation',
                        'label'       => __( 'ترجمه', 'cardifa' ),
                        'type'        => Controls_Manager::TEXT,
                        'placeholder' => __( 'ترجمه متن...', 'cardifa' ),
                    ],
                ],
                'title_field' => '{{{ key }}}: {{{ translation }}}',
                'condition'   => [
                    "{$id}_enable" => 'yes',
                ],
            ]
        );

        // فعال‌سازی WPML
        $this->add_control(
            "{$id}_wpml_enable",
            [
                'label'        => __( 'فعال‌سازی WPML', 'cardifa' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'فعال', 'cardifa' ),
                'label_off'    => __( 'غیرفعال', 'cardifa' ),
                'return_value' => 'yes',
                'default'      => 'no',
            ]
        );

        // فعال‌سازی Polylang
        $this->add_control(
            "{$id}_polylang_enable",
            [
                'label'        => __( 'فعال‌سازی Polylang', 'cardifa' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'فعال', 'cardifa' ),
                'label_off'    => __( 'غیرفعال', 'cardifa' ),
                'return_value' => 'yes',
                'default'      => 'no',
            ]
        );

        // ترجمه متن دلخواه برای ویجت‌ها
        $this->add_control(
            "{$id}_translate_texts",
            [
                'label'       => __( 'ترجمه متون دلخواه', 'cardifa' ),
                'type'        => Controls_Manager::TEXTAREA,
                'description' => __( 'متون قابل ترجمه برای هر زبان.', 'cardifa' ),
                'dynamic'     => [ 'active' => true ],
                'condition'   => [
                    "{$id}_enable" => 'yes',
                ],
            ]
        );
    }
}
