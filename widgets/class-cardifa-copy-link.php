<?php
/**
 * 📦 ویجت کپی لینک
 * ----------------------------
 * این ویجت یک دکمه برای کپی کردن لینک دلخواه ایجاد می‌کند.
 * مسیر فایل: /widgets/class-cardifa-copy-link.php
 */

namespace Elementor;

use \Cardifa\Traits\Basic_Cardifa_Controls;

if (!defined('ABSPATH')) exit;

class Cardifa_Copy_Link_Widget extends Widget_Base {

    use Basic_Cardifa_Controls;

    /**
     * 🆔 نام یکتا برای ویجت
     */
    public function get_name() {
        return 'cardifa_copy_link';
    }

    /**
     * 🏷 عنوان نمایشی ویجت در پنل المنتور
     */
    public function get_title() {
        return 'کپی لینک';
    }

    /**
     * 🧩 آیکون ویجت در لیست المنتور
     */
    public function get_icon() {
        return 'eicon-link';
    }

    /**
     * 🗂 دسته‌بندی سفارشی ویجت
     */
    public function get_categories() {
        return ['cardifa-elements'];
    }

    /**
     * 🛠 تنظیمات محتوایی ویجت
     */
    protected function register_controls() {

        // 📌 بخش محتوا
        $this->start_controls_section('section_content', [
            'label' => 'محتوا',
            'tab' => Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('btn_title', [
            'label' => 'متن دکمه',
            'type' => Controls_Manager::TEXT,
            'default' => 'کپی لینک',
        ]);

        $this->add_control('link_url', [
            'label' => 'لینک برای کپی',
            'type' => Controls_Manager::URL,
            'placeholder' => 'https://example.com',
        ]);

        $this->add_control('icon', [
            'label' => 'آیکون دکمه',
            'type' => Controls_Manager::ICONS,
            'default' => [
                'value' => 'fas fa-copy',
                'library' => 'fa-solid',
            ],
        ]);

        $this->end_controls_section();

        // 🎨 استایل متن
        $this->start_controls_section('style_text', [
            'label' => 'استایل متن و آیکون',
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->register_text_style('copy_button_text', '.cardifa-copy-link-button', true);

        $this->end_controls_section();
    }

    /**
     * 🎯 رندر HTML نهایی در فرانت‌اند
     */
    protected function render() {
        $settings = $this->get_settings_for_display();
        $link = $settings['link_url']['url'] ?? '';

        ?>
        <div class="cardifa-copy-link-wrapper">
            <button class="cardifa-copy-link-button" onclick="cardifaCopyToClipboard_<?php echo esc_attr($this->get_id()); ?>()">
                <span class="cardifa-copy-text"><?php echo esc_html($settings['btn_title']); ?></span>
                <?php Icons_Manager::render_icon($settings['icon'], ['aria-hidden' => 'true']); ?>
            </button>
            <input type="text" id="copy-link-<?php echo esc_attr($this->get_id()); ?>" value="<?php echo esc_url($link); ?>" style="position:absolute;left:-9999px;" readonly>
        </div>

        <script>
            function cardifaCopyToClipboard_<?php echo esc_attr($this->get_id()); ?>() {
                const input = document.getElementById('copy-link-<?php echo esc_attr($this->get_id()); ?>');
                input.select();
                input.setSelectionRange(0, 99999); // For mobile devices
                document.execCommand("copy");
                alert("لینک کپی شد! 📋");
            }
        </script>
        <?php
    }
}
