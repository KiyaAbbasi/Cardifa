<?php
/**
 * File: SEOOptimizationTrait.php
 * Path: src/Elementor/Traits/
 * Description:
 *   مدیریت تنظیمات سئو شامل:
 *   • افزودن توضیحات متا.
 *   • تنظیم متن جایگزین تصاویر.
 *   • پشتیبانی از اسکیما مارک‌آپ.
 * Author: Kiya Holding
 */

namespace Cardifa\Elementor\Traits;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // جلوگیری از دسترسی مستقیم

trait SEOOptimizationTrait {

    /**
     * ثبت تنظیمات سئو
     *
     * @param string $id شناسه کنترل
     * @param string $selector سلکتور HTML برای اعمال تنظیمات
     */
    protected function register_seo_optimization_controls(
        string $id = 'seo_optimization',
        string $selector = '{{WRAPPER}}'
    ) {
        // تنظیم متن جایگزین برای تصاویر
        $this->add_control(
            "{$id}_alt_text",
            [
                'label'       => __( 'متن جایگزین تصاویر', 'cardifa' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => __( 'متن جایگزین پیش‌فرض', 'cardifa' ),
                'dynamic'     => [ 'active' => true ],
                'description' => __( 'متن جایگزین تصاویر برای بهبود سئو.', 'cardifa' ),
            ]
        );

        // افزودن توضیحات متا
        $this->add_control(
            "{$id}_meta_description",
            [
                'label'       => __( 'توضیحات متا', 'cardifa' ),
                'type'        => Controls_Manager::TEXTAREA,
                'placeholder' => __( 'توضیحات کوتاه برای موتورهای جستجو...', 'cardifa' ),
                'dynamic'     => [ 'active' => true ],
                'description' => __( 'بهینه‌سازی توضیحات متا برای سئو.', 'cardifa' ),
            ]
        );

        // تنظیم اسکیما مارک‌آپ
        $this->add_control(
            "{$id}_schema_markup",
            [
                'label'       => __( 'اسکیما مارک‌آپ', 'cardifa' ),
                'type'        => Controls_Manager::TEXTAREA,
                'placeholder' => __( '{ "type": "WebPage", "name": "Example" }', 'cardifa' ),
                'description' => __( 'افزودن اسکیما مارک‌آپ برای موتورهای جستجو.', 'cardifa' ),
            ]
        );
    }
}
