<?php
/**
 * File: BackgroundTrait.php
 * Path: src/Elementor/Traits/
 * Description:
 *   مدیریت تنظیمات پس‌زمینه شامل:
 *   - رنگ ساده (Classic)
 *   - گرادیان (Gradient)
 *   - تصویر (Image)
 *   - ویدئو (Video)
 *   - حالت‌هاور برای پس‌زمینه
 *   - موقعیت و تکرار تصویر
 *   - فیلترهای CSS
 * Author: Kiya Holding
 */

namespace Cardifa\Elementor\Traits;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Css_Filter;

if ( ! defined( 'ABSPATH' ) ) exit; // جلوگیری از دسترسی مستقیم

trait BackgroundTrait {

    /**
     * ثبت تنظیمات پس‌زمینه
     *
     * @param string $id شناسه کنترل
     * @param string $selector سلکتور CSS برای اعمال استایل‌ها
     */
    protected function register_background_controls(
        string $id = 'background',
        string $selector = '{{WRAPPER}} .cardifa-background'
    ) {
        // پس‌زمینه معمولی
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => $id,
                'label'    => __( 'پس‌زمینه', 'cardifa' ),
                'types'    => [ 'classic', 'gradient', 'video' ],
                'selector' => $selector,
            ]
        );

        // پس‌زمینه در حالت هاور
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => "{$id}_hover",
                'label'    => __( 'پس‌زمینه در هاور', 'cardifa' ),
                'types'    => [ 'classic', 'gradient' ],
                'selector' => $selector . ':hover',
            ]
        );

        // موقعیت و تکرار تصویر
        $this->add_control(
            "{$id}_position",
            [
                'label'     => __( 'موقعیت تصویر', 'cardifa' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    'default' => __( 'پیش‌فرض', 'cardifa' ),
                    'center'  => __( 'مرکز', 'cardifa' ),
                    'top'     => __( 'بالا', 'cardifa' ),
                    'bottom'  => __( 'پایین', 'cardifa' ),
                    'left'    => __( 'چپ', 'cardifa' ),
                    'right'   => __( 'راست', 'cardifa' ),
                ],
                'default'   => 'default',
                'selectors' => [ $selector => 'background-position: {{VALUE}};' ],
            ]
        );

        $this->add_control(
            "{$id}_repeat",
            [
                'label'     => __( 'تکرار تصویر', 'cardifa' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    'no-repeat' => __( 'بدون تکرار', 'cardifa' ),
                    'repeat'    => __( 'تکرار', 'cardifa' ),
                    'repeat-x'  => __( 'تکرار افقی', 'cardifa' ),
                    'repeat-y'  => __( 'تکرار عمودی', 'cardifa' ),
                ],
                'default'   => 'no-repeat',
                'selectors' => [ $selector => 'background-repeat: {{VALUE}};' ],
            ]
        );

        // فیلترهای CSS
        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name'     => "{$id}_css_filters",
                'label'    => __( 'فیلترهای CSS', 'cardifa' ),
                'selector' => $selector,
            ]
        );

        // فیلترهای CSS در حالت هاور
        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name'     => "{$id}_hover_css_filters",
                'label'    => __( 'فیلترهای CSS در هاور', 'cardifa' ),
                'selector' => $selector . ':hover',
            ]
        );
    }
}
