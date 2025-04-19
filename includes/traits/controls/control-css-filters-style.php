<?php
/**
 * 📁 control-css-filters-style.php
 * 🎯 فیلترهای CSS برای افکت‌های تصویری
 * 🛤 مسیر: includes/traits/controls/control-css-filters-style.php
 */

namespace Cardifa\Traits\Controls;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Css_Filter;

if (!defined('ABSPATH')) exit;

trait Control_CSS_Filters_Style {

    /**
     * 📦 ثبت تنظیمات فیلترهای CSS برای یک ویجت خاص
     *
     * @param string $name     نام اختصاصی کنترل‌ها
     * @param string $selector سلکتور CSS برای اعمال فیلترها
     */
    protected function register_css_filters_style($name, $selector) {

        $this->start_controls_section(
            'section_css_filters_' . $name,
            [
                'label' => 'فیلترهای CSS',
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name'     => 'css_filters_' . $name,
                'selector' => '{{WRAPPER}} ' . $selector,
            ]
        );

        $this->add_responsive_control(
            'mix_blend_mode_' . $name,
            [
                'label' => 'Blend Mode (ترکیب رنگ)',
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => 'پیش‌فرض',
                    'normal' => 'Normal',
                    'multiply' => 'Multiply',
                    'screen' => 'Screen',
                    'overlay' => 'Overlay',
                    'darken' => 'Darken',
                    'lighten' => 'Lighten',
                    'color-dodge' => 'Color Dodge',
                    'color-burn' => 'Color Burn',
                    'hard-light' => 'Hard Light',
                    'soft-light' => 'Soft Light',
                    'difference' => 'Difference',
                    'exclusion' => 'Exclusion',
                    'hue' => 'Hue',
                    'saturation' => 'Saturation',
                    'color' => 'Color',
                    'luminosity' => 'Luminosity',
                ],
                'selectors' => [
                    '{{WRAPPER}} ' . $selector => 'mix-blend-mode: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }
}
