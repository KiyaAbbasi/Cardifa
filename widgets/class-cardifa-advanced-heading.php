<?php
/**
 * 🎯 ویجت عنوان پیشرفته کارت دیفا (نسخه اولیه بدون باگ)
 * 📍 مسیر: widgets/class-cardifa-advanced-heading.php
 */

namespace Elementor;

use \Cardifa\Traits\Basic_Cardifa_Controls;

if (!defined('ABSPATH')) exit;

class Cardifa_Advanced_Heading extends \Elementor\Widget_Base {

    use Basic_Cardifa_Controls;

    public function get_name() {
        return 'cardifa_advanced_heading';
    }

    public function get_title() {
        return 'عنوان پیشرفته';
    }

    public function get_icon() {
        return 'eicon-heading';
    }

    public function get_categories() {
        return ['cardifa-elements'];
    }

    public function get_keywords() {
        return ['heading', 'title', 'cardifa'];
    }

    protected function register_controls() {

        // 📦 محتوای عنوان
        $this->start_controls_section('section_content', [
            'label' => 'محتوا',
            'tab' => Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('above_text', [
            'label' => 'متن بالا',
            'type' => Controls_Manager::TEXT,
            'default' => 'زیرعنوان بالا',
        ]);

        $this->add_control('main_text', [
            'label' => 'عنوان اصلی',
            'type' => Controls_Manager::TEXT,
            'default' => 'عنوان شما',
        ]);

        $this->add_control('sub_text', [
            'label' => 'زیرعنوان',
            'type' => Controls_Manager::TEXT,
            'default' => 'توضیح زیر عنوان',
        ]);

        $this->add_control('title_tag', [
            'label' => 'تگ HTML',
            'type' => Controls_Manager::CHOOSE,
            'default' => 'h2',
            'options' => [
                'h1' => ['title' => 'H1', 'icon' => 'eicon-editor-h1'],
                'h2' => ['title' => 'H2', 'icon' => 'eicon-editor-h2'],
                'h3' => ['title' => 'H3', 'icon' => 'eicon-editor-h3'],
            ],
            'toggle' => false,
        ]);

        $this->end_controls_section();

        // 🎨 استایل
        $this->start_controls_section('section_style', [
            'label' => 'استایل',
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->register_text_style('above_text_style', '.cardifa-heading-above');
        $this->register_text_style('main_text_style', '.cardifa-heading-main');
        $this->register_text_style('sub_text_style', '.cardifa-heading-sub');

        $this->end_controls_section();

        // 📐 ترازبندی
        $this->register_alignment('heading_align', '.cardifa-advanced-heading');
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $tag = $settings['title_tag'] ?: 'h2';

        echo '<div class="cardifa-advanced-heading">';
        if (!empty($settings['above_text'])) {
            echo '<div class="cardifa-heading-above">' . esc_html($settings['above_text']) . '</div>';
        }
        echo '<' . esc_attr($tag) . ' class="cardifa-heading-main">' . esc_html($settings['main_text']) . '</' . esc_attr($tag) . '>';
        if (!empty($settings['sub_text'])) {
            echo '<div class="cardifa-heading-sub">' . esc_html($settings['sub_text']) . '</div>';
        }
        echo '</div>';
    }
}
