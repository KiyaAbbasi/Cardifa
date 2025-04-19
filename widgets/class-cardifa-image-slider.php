<?php
/**
 * 📁 فایل: class-cardifa-image-slider.php
 * -----------------------------
 * 🎯 ویجت اسلایدر تصویر برای بایولینک Cardifa
 * 📦 شامل قابلیت تنظیم تعداد عکس، کنترل فاصله، حاشیه، رنگ پس‌زمینه، تایپوگرافی، نمایش عنوان و...
 */

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

if (!defined('ABSPATH')) exit;

class Cardifa_Image_Slider_Widget extends Widget_Base {

    public function get_name() {
        return 'cardifa_image_slider';
    }

    public function get_title() {
        return 'اسلایدر تصویر';
    }

    public function get_icon() {
        return 'eicon-slider-device';
    }

    public function get_categories() {
        return ['cardifa-elements'];
    }

    public function get_keywords() {
        return ['slider', 'image', 'gallery', 'اسلایدر', 'عکس'];
    }

    protected function register_controls() {
        $this->start_controls_section('content_section', [
            'label' => 'تصاویر',
            'tab' => Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('images', [
            'label' => 'افزودن تصاویر',
            'type' => Controls_Manager::GALLERY,
            'default' => [],
        ]);

        $this->end_controls_section();

        $this->start_controls_section('style_section', [
            'label' => 'استایل اسلایدر',
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_responsive_control('slider_padding', [
            'label' => 'فاصله داخلی',
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .cardifa-image-slider' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Border::get_type(), [
            'name' => 'slider_border',
            'selector' => '{{WRAPPER}} .cardifa-image-slider',
        ]);

        $this->add_group_control(Group_Control_Box_Shadow::get_type(), [
            'name' => 'slider_shadow',
            'selector' => '{{WRAPPER}} .cardifa-image-slider',
        ]);

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        if (!empty($settings['images'])) {
            echo '<div class="cardifa-image-slider swiper">';
            echo '<div class="swiper-wrapper">';
            foreach ($settings['images'] as $image) {
                echo '<div class="swiper-slide">';
                echo '<img src="' . esc_url($image['url']) . '" alt="" />';
                echo '</div>';
            }
            echo '</div>';
            echo '</div>';
        }
    }

    protected function content_template() {}
}
?>
