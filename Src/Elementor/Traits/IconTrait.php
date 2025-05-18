<?php
/**
 * File: IconTrait.php
 * Path: src/Elementor/Traits/
 * Description:
 *   مدیریت تنظیمات آیکون شامل:
 *   - انتخاب آیکون
 *   - اندازه و رنگ آیکون
 *   - بک‌گراند و شعاع گوشه‌ها
 *   - سایه‌ها
 *   - تنظیمات هاور (Hover)
 *   - چرخش آیکون
 * Author: Kiya Holding
 */

namespace Cardifa\Elementor\Traits;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;

if ( ! defined( 'ABSPATH' ) ) exit; // جلوگیری از دسترسی مستقیم

trait IconTrait {

    /**
     * ثبت تنظیمات آیکون
     *
     * @param string $id    شناسه کنترل
     * @param string $label لیبل نمایشی
     * @param string $selector سلکتور CSS برای اعمال استایل‌ها
     */
    protected function register_icon_controls(
        string $id = 'icon',
        string $label = '',
        string $selector = '{{WRAPPER}} .cardifa-icon'
    ) {
        // انتخاب آیکون
        $this->add_control(
            $id,
            [
                'label'   => $label ?: __( 'آیکون', 'cardifa' ),
                'type'    => Controls_Manager::ICONS,
                'default' => [ 'value' => 'fas fa-star', 'library' => 'fa-solid' ],
            ]
        );

        // اندازه آیکون (واکنش‌گرا)
        $this->add_responsive_control(
            "{$id}_size",
            [
                'label'      => __( 'اندازه آیکون', 'cardifa' ),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [ 'px' => [ 'min' => 8, 'max' => 200 ] ],
                'selectors'  => [ $selector => 'font-size: {{SIZE}}{{UNIT}};' ],
                'default'    => [ 'size' => 24, 'unit' => 'px' ],
            ]
        );

        // رنگ آیکون
        $this->add_control(
            "{$id}_color",
            [
                'label'     => __( 'رنگ آیکون', 'cardifa' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [ $selector => 'color: {{VALUE}};' ],
            ]
        );

        // بک‌گراند آیکون
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => "{$id}_background",
                'label'    => __( 'پس‌زمینه', 'cardifa' ),
                'types'    => [ 'classic', 'gradient' ],
                'selector' => $selector,
            ]
        );

        // شعاع گوشه‌ها
        $this->add_responsive_control(
            "{$id}_border_radius",
            [
                'label'      => __( 'شعاع گوشه‌ها', 'cardifa' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [ $selector => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
            ]
        );

        // سایه آیکون
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => "{$id}_box_shadow",
                'label'    => __( 'سایه آیکون', 'cardifa' ),
                'selector' => $selector,
            ]
        );

        // حالت هاور: رنگ آیکون
        $this->add_control(
            "{$id}_hover_color",
            [
                'label'     => __( 'رنگ آیکون در هاور', 'cardifa' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [ $selector . ':hover' => 'color: {{VALUE}};' ],
            ]
        );

        // حالت هاور: سایه آیکون
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => "{$id}_hover_box_shadow",
                'label'    => __( 'سایه آیکون در هاور', 'cardifa' ),
                'selector' => $selector . ':hover',
            ]
        );

        // حالت هاور: چرخش
        $this->add_control(
            "{$id}_hover_rotation",
            [
                'label'      => __( 'چرخش در هاور', 'cardifa' ),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [ 'deg' => [ 'min' => 0, 'max' => 360 ] ],
                'selectors'  => [ $selector . ':hover' => 'transform: rotate({{SIZE}}deg);' ],
            ]
        );

        // فاصله آیکون از متن
        $this->add_responsive_control(
            "{$id}_spacing",
            [
                'label'     => __( 'فاصله آیکون از متن', 'cardifa' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
                'selectors' => [ $selector => 'margin-right: {{SIZE}}{{UNIT}};' ],
            ]
        );
    }
}
