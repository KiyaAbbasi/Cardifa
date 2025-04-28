<?php
/**
 * File: ResponsiveTrait.php
 * Path: src/Elementor/Traits/
 * Description:
 *   مدیریت تنظیمات واکنش‌گرایی مانند:
 *   - تنظیمات نمایش در دسکتاپ، تبلت و موبایل
 * Author: Kiya Holding
 */

namespace Cardifa\Elementor\Traits;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // جلوگیری از دسترسی مستقیم

trait ResponsiveTrait {

    /**
     * ثبت تنظیمات واکنش‌گرایی
     *
     * @param string $id شناسه کنترل
     * @param string $selector سلکتور CSS برای اعمال استایل‌ها
     */
    protected function register_responsive_controls(
        string $id = 'responsive',
        string $selector = '{{WRAPPER}} .cardifa-responsive'
    ) {
        // نمایش در دستگاه‌ها
        $this->add_control(
            "{$id}_visibility",
            [
                'label'   => __( 'نمایش در دستگاه‌ها', 'cardifa' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    ''        => __( 'همه دستگاه‌ها', 'cardifa' ),
                    'desktop' => __( 'فقط دسکتاپ', 'cardifa' ),
                    'tablet'  => __( 'فقط تبلت', 'cardifa' ),
                    'mobile'  => __( 'فقط موبایل', 'cardifa' ),
                ],
                'prefix_class' => 'cardifa-visibility-',
            ]
        );
    }
}
