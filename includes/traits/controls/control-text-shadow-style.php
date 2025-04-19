<?php
/**
 * 📁 control-text-shadow-style.php
 * 🎯 کنترل سایه متن برای المنت‌ها
 * 🛤 مسیر: includes/traits/controls/control-text-shadow-style.php
 */

namespace Cardifa\Traits\Controls;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Text_Shadow;

if (!defined('ABSPATH')) exit;

trait Control_Text_Shadow_Style {

    /**
     * 📦 افزودن تنظیمات سایه متن برای یک المنت خاص
     * 
     * @param string $name شناسه یکتا برای تنظیمات
     * @param string $selector سلکتور CSS هدف
     * @param string $label عنوان بخش تنظیمات در پنل
     */
    protected function register_text_shadow_style($name, $selector, $label = 'سایه متن') {
        $this->start_controls_section(
            'section_text_shadow_' . $name,
            [
                'label' => $label,
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        // گروه کنترل سایه متن با تمام گزینه‌ها
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name' => $name . '_text_shadow',
                'selector' => '{{WRAPPER}} ' . $selector,
            ]
        );

        $this->end_controls_section();
    }

}
