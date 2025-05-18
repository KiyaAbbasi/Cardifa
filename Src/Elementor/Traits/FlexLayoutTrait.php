<?php
/**
 * File: FlexLayoutTrait.php
 * Path: src/Elementor/Traits/
 * Description:
 *   مدیریت تنظیمات چیدمان فلکس شامل:
 *   • چینش آیتم‌ها در محور اصلی و فرعی
 *   • فاصله بین آیتم‌ها
 *   • ترتیب نمایش آیتم‌ها
 *   • تنظیمات واکنش‌گرا
 * Author: Kiya Holding
 */

namespace Cardifa\Elementor\Traits;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // جلوگیری از دسترسی مستقیم

trait FlexLayoutTrait {

    /**
     * ثبت تنظیمات چیدمان فلکس
     *
     * @param string $id شناسه کنترل
     * @param string $selector سلکتور CSS برای اعمال استایل‌ها
     */
    protected function register_flex_layout_controls(
        string $id = 'flex_layout',
        string $selector = '{{WRAPPER}} .cardifa-flex'
    ) {
        // جهت فلکس
        $this->add_control(
            "{$id}_direction",
            [
                'label'   => __( 'جهت فلکس', 'cardifa' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'row'        => __( 'ردیف (Row)', 'cardifa' ),
                    'row-reverse'=> __( 'ردیف معکوس (Row Reverse)', 'cardifa' ),
                    'column'     => __( 'ستون (Column)', 'cardifa' ),
                    'column-reverse'=> __( 'ستون معکوس (Column Reverse)', 'cardifa' ),
                ],
                'default' => 'row',
                'selectors' => [
                    $selector => 'flex-direction: {{VALUE}};',
                ],
            ]
        );

        // فاصله بین آیتم‌ها
        $this->add_control(
            "{$id}_justify_content",
            [
                'label'   => __( 'فاصله بین آیتم‌ها', 'cardifa' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'flex-start'    => __( 'شروع (Start)', 'cardifa' ),
                    'center'        => __( 'مرکز (Center)', 'cardifa' ),
                    'flex-end'      => __( 'پایان (End)', 'cardifa' ),
                    'space-between' => __( 'فضای بین (Space Between)', 'cardifa' ),
                    'space-around'  => __( 'فضای اطراف (Space Around)', 'cardifa' ),
                ],
                'default' => 'flex-start',
                'selectors' => [
                    $selector => 'justify-content: {{VALUE}};',
                ],
            ]
        );

        // چینش در محور متقاطع
        $this->add_control(
            "{$id}_align_items",
            [
                'label'   => __( 'چینش در محور متقاطع', 'cardifa' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'flex-start' => __( 'شروع (Start)', 'cardifa' ),
                    'center'     => __( 'مرکز (Center)', 'cardifa' ),
                    'flex-end'   => __( 'پایان (End)', 'cardifa' ),
                    'stretch'    => __( 'کشیده (Stretch)', 'cardifa' ),
                ],
                'default' => 'stretch',
                'selectors' => [
                    $selector => 'align-items: {{VALUE}};',
                ],
            ]
        );
    }
}
