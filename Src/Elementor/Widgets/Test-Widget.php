<?php
/**
 * File Name:    Test_Widget.php
 * Description:  ویجت تست برای اطمینان از ثبت ویجت‌ها
 * Since:        1.0.0
 */

namespace Cardifa\Elementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

defined('ABSPATH') || exit;

class Test_Widget extends Widget_Base
{
    public function get_name(): string
    {
        return 'cardifa_test';
    }

    public function get_title(): string
    {
        return __('Cardifa Test', 'cardifa');
    }

    public function get_icon(): string
    {
        return 'eicon-testimonial';
    }

    public function get_categories(): array
    {
        return ['cardifa'];
    }

    protected function _register_controls(): void
    {
        $this->start_controls_section(
            'content_section',
            ['label' => __('تنظیمات ویجت تست', 'cardifa')]
        );
        $this->add_control(
            'title',
            [
                'label'       => __('متن عنوان', 'cardifa'),
                'type'        => Controls_Manager::TEXT,
                'placeholder' => __('مثال: تست ویجت', 'cardifa'),
                'default'     => __('تست موفق ویجت!', 'cardifa'),
            ]
        );
        $this->end_controls_section();
    }

    protected function render(): void
    {
        $settings = $this->get_settings_for_display();
        echo '<div class="cardifa-test-widget">';
        echo '<h3>' . esc_html( $settings['title'] ) . '</h3>';
        echo '</div>';
    }
}
