<?php
/**
 * 📁 control-display-style.php
 * 📌 استایل‌دهی نمایش یا عدم نمایش المان در دستگاه‌های مختلف
 * 🛤 مسیر: includes/traits/controls/control-display-style.php
 */

namespace Cardifa\Traits\Controls;

use Elementor\Controls_Manager;

if (!defined('ABSPATH')) exit;

trait Control_Display_Style {

    /**
     * 🔧 ثبت تنظیمات نمایش المان در حالت‌های مختلف
     *
     * @param string $name نام اختصاصی برای تنظیمات
     * @param string $selector سلکتور CSS
     */
    protected function register_display_style($name, $selector) {

        $this->start_controls_section(
            'section_display_style_' . $name,
            [
                'label' => 'نمایش / عدم نمایش',
                'tab'   => Controls_Manager::TAB_ADVANCED,
            ]
        );

        // نمایش یا عدم نمایش در دستگاه‌های مختلف
        $this->add_responsive_control(
            $name . '_display',
            [
                'label' => 'وضعیت نمایش',
                'type' => Controls_Manager::SELECT,
                'options' => [
                    ''          => 'پیش‌فرض',
                    'block'     => 'Block',
                    'inline'    => 'Inline',
                    'inline-block' => 'Inline Block',
                    'flex'      => 'Flex',
                    'inline-flex' => 'Inline Flex',
                    'grid'      => 'Grid',
                    'none'      => 'مخفی',
                ],
                'selectors' => [
                    '{{WRAPPER}} ' . $selector => 'display: {{VALUE}};',
                ],
            ]
        );

        // تنظیم قابلیت کش‌ آمدن یا مخفی شدن در دستگاه‌ها
        $this->add_control(
            $name . '_responsive_visibility',
            [
                'label' => 'مخفی‌سازی در دستگاه‌ها',
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'label_block' => true,
                'options' => [
                    'hide-mobile'  => 'مخفی در موبایل',
                    'hide-tablet'  => 'مخفی در تبلت',
                    'hide-desktop' => 'مخفی در دسکتاپ',
                ],
                'selectors' => [
                    '{{WRAPPER}} ' . $selector . '.hide-mobile'  => '@media(max-width: 767px) { display: none !important; }',
                    '{{WRAPPER}} ' . $selector . '.hide-tablet'  => '@media(min-width: 768px) and (max-width: 1024px) { display: none !important; }',
                    '{{WRAPPER}} ' . $selector . '.hide-desktop' => '@media(min-width: 1025px) { display: none !important; }',
                ],
            ]
        );

        $this->end_controls_section();
    }
}
