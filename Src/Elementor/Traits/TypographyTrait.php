<?php
/**
 * File: TypographyTrait.php
 * Path: src/Elementor/Traits/
 * Description:
 *   مدیریت تنظیمات تایپوگرافی شامل:
 *   - انتخاب فونت
 *   - سایز، وزن و استایل فونت
 *   - فاصله خطوط و فاصله حروف
 *   - سایه متن
 *   - تزئینات متن (مانند خط زیر متن)
 *   - تنظیمات هاور (Hover)
 *   - تنظیمات واکنش‌گرا
 * Author: KiyaAbbasi
 */

namespace Cardifa\Elementor\Traits;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;

if ( ! defined( 'ABSPATH' ) ) exit; // جلوگیری از دسترسی مستقیم

trait TypographyTrait {

    /**
     * ثبت تنظیمات تایپوگرافی
     *
     * @param string $id شناسه کنترل
     * @param string $selector سلکتور CSS برای اعمال استایل‌ها
     */
    protected function register_typography_controls(
        string $id = 'typography',
        string $selector = '{{WRAPPER}} .cardifa-text'
    ) {
        // تنظیمات فونت (Typography)
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => $id,
                'label'    => __( 'تایپوگرافی', 'cardifa' ),
                'selector' => $selector,
            ]
        );

        // رنگ متن
        $this->add_control(
            "{$id}_color",
            [
                'label'     => __( 'رنگ متن', 'cardifa' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [ $selector => 'color: {{VALUE}};' ],
            ]
        );

        // استایل فونت (Italic, Normal)
        $this->add_control(
            "{$id}_style",
            [
                'label'     => __( 'استایل فونت', 'cardifa' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    'normal' => __( 'عادی', 'cardifa' ),
                    'italic' => __( 'مورب', 'cardifa' ),
                ],
                'default'   => 'normal',
                'selectors' => [ $selector => 'font-style: {{VALUE}};' ],
            ]
        );

        // تزئینات متن (Underline, Overline, Line-Through)
        $this->add_control(
            "{$id}_text_decoration",
            [
                'label'     => __( 'تزئینات متن', 'cardifa' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    'none'         => __( 'هیچ‌کدام', 'cardifa' ),
                    'underline'    => __( 'خط زیر متن', 'cardifa' ),
                    'overline'     => __( 'خط بالای متن', 'cardifa' ),
                    'line-through' => __( 'خط روی متن', 'cardifa' ),
                ],
                'default'   => 'none',
                'selectors' => [ $selector => 'text-decoration: {{VALUE}};' ],
            ]
        );

        // سایه متن
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'     => "{$id}_text_shadow",
                'label'    => __( 'سایه متن', 'cardifa' ),
                'selector' => $selector,
            ]
        );

        // فاصله خطوط (Line Height) و فاصله حروف (Letter Spacing)
        $this->add_responsive_control(
            "{$id}_line_height",
            [
                'label'      => __( 'فاصله خطوط', 'cardifa' ),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [ 'px' => [ 'min' => 1, 'max' => 3, 'step' => 0.1 ] ],
                'selectors'  => [ $selector => 'line-height: {{SIZE}}em;' ],
                'default'    => [ 'size' => 1.5, 'unit' => 'em' ],
            ]
        );

        $this->add_responsive_control(
            "{$id}_letter_spacing",
            [
                'label'      => __( 'فاصله حروف', 'cardifa' ),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [ 'px' => [ 'min' => -5, 'max' => 20, 'step' => 0.5 ] ],
                'selectors'  => [ $selector => 'letter-spacing: {{SIZE}}{{UNIT}};' ],
                'default'    => [ 'size' => 0, 'unit' => 'px' ],
            ]
        );

        // رنگ متن در حالت هاور
        $this->add_control(
            "{$id}_hover_color",
            [
                'label'     => __( 'رنگ متن در هاور', 'cardifa' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [ $selector . ':hover' => 'color: {{VALUE}};' ],
            ]
        );

        // تزئینات متن در هاور
        $this->add_control(
            "{$id}_hover_text_decoration",
            [
                'label'     => __( 'تزئینات متن در هاور', 'cardifa' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    'none'         => __( 'هیچ‌کدام', 'cardifa' ),
                    'underline'    => __( 'خط زیر متن', 'cardifa' ),
                    'overline'     => __( 'خط بالای متن', 'cardifa' ),
                    'line-through' => __( 'خط روی متن', 'cardifa' ),
                ],
                'default'   => 'none',
                'selectors' => [ $selector . ':hover' => 'text-decoration: {{VALUE}};' ],
            ]
        );
    }
}
