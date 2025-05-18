<?php
/**
 * File: BasicCardifaElement.php
 * Path: src/Elementor/Traits/
 * Description:
 *   مدیریت تنظیمات پایه ویجت‌ها شامل:
 *   • تنظیمات عنوان و توضیحات
 *   • تنظیمات استایل (تایپوگرافی، رنگ متن، حاشیه، پس‌زمینه، سایه)
 *   • تنظیمات واکنش‌گرایی
 * Author: Kiya Holding
 */

namespace Cardifa\Elementor\Traits;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

if ( ! defined( 'ABSPATH' ) ) exit; // جلوگیری از دسترسی مستقیم

trait BasicCardifaElement {

    /**
     * ثبت تنظیمات پایه ویجت
     */
    protected function register_basic_widget_controls() {
        // تنظیمات عنوان
        $this->add_control(
            'title',
            [
                'label'   => __( 'عنوان', 'cardifa' ),
                'type'    => Controls_Manager::TEXT,
                'default' => __( 'عنوان پیش‌فرض', 'cardifa' ),
                'dynamic' => [ 'active' => true ],
            ]
        );

        // تنظیمات توضیحات
        $this->add_control(
            'description',
            [
                'label'   => __( 'توضیحات', 'cardifa' ),
                'type'    => Controls_Manager::TEXTAREA,
                'default' => __( 'توضیحات پیش‌فرض', 'cardifa' ),
                'dynamic' => [ 'active' => true ],
            ]
        );

        // تایپوگرافی عنوان
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'title_typography',
                'label'    => __( 'تایپوگرافی عنوان', 'cardifa' ),
                'selector' => '{{WRAPPER}} .cardifa-title',
            ]
        );

        // رنگ عنوان
        $this->add_control(
            'title_color',
            [
                'label'     => __( 'رنگ عنوان', 'cardifa' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .cardifa-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        // تایپوگرافی توضیحات
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'description_typography',
                'label'    => __( 'تایپوگرافی توضیحات', 'cardifa' ),
                'selector' => '{{WRAPPER}} .cardifa-description',
            ]
        );

        // رنگ توضیحات
        $this->add_control(
            'description_color',
            [
                'label'     => __( 'رنگ توضیحات', 'cardifa' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#666666',
                'selectors' => [
                    '{{WRAPPER}} .cardifa-description' => 'color: {{VALUE}};',
                ],
            ]
        );

        // پس‌زمینه
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'widget_background',
                'label'    => __( 'پس‌زمینه', 'cardifa' ),
                'types'    => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}}',
            ]
        );

        // حاشیه
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'widget_border',
                'label'    => __( 'حاشیه', 'cardifa' ),
                'selector' => '{{WRAPPER}}',
            ]
        );

        // سایه
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'widget_box_shadow',
                'label'    => __( 'سایه', 'cardifa' ),
                'selector' => '{{WRAPPER}}',
            ]
        );

        // حاشیه داخلی (Padding)
        $this->add_responsive_control(
            'widget_padding',
            [
                'label'      => __( 'فاصله داخلی (Padding)', 'cardifa' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors'  => [
                    '{{WRAPPER}}' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // حاشیه بیرونی (Margin)
        $this->add_responsive_control(
            'widget_margin',
            [
                'label'      => __( 'فاصله بیرونی (Margin)', 'cardifa' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors'  => [
                    '{{WRAPPER}}' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
    }
}
