<?php
/**
 * 📁 control-box-shadow-style.php
 * 🎯 کنترل سایه بیرونی (Box Shadow) برای المنت‌ها
 * 🛤 مسیر: includes/traits/controls/control-box-shadow-style.php
 */

namespace Cardifa\Traits\Controls;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;

if (!defined('ABSPATH')) exit;

trait Control_Box_Shadow_Style {

    /**
     * 📦 افزودن تنظیمات سایه برای المنت مورد نظر
     * 
     * @param string $name شناسه یکتا برای تنظیمات
     * @param string $selector سلکتور CSS المنت هدف
     * @param string $label عنوان بخش در پنل تنظیمات
     */
    protected function register_box_shadow_style($name, $selector, $label = 'سایه باکس') {
        $this->start_controls_section(
            'section_box_shadow_' . $name,
            [
                'label' => $label,
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        // گروه کنترل سایه باکس (کامل‌ترین نوع تنظیمات سایه)
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => $name . '_box_shadow',
                'label' => 'سایه',
                'selector' => '{{WRAPPER}} ' . $selector,
            ]
        );

        $this->end_controls_section();
    }

}
