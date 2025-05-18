<?php
/**
 * File: PerformanceOptimizationTrait.php
 * Description:
 *   مدیریت بهینه‌سازی عملکرد شامل:
 *   - بارگذاری تنبل (Lazy Loading)
 *   - حذف فایل‌های غیرضروری
 *   - ترکیب و کوچک‌سازی فایل‌ها
 */

namespace Cardifa\Elementor\Traits;

if (!defined('ABSPATH')) exit; // جلوگیری از دسترسی مستقیم

trait PerformanceOptimizationTrait {

    /**
     * فعال‌سازی بارگذاری تنبل
     */
    public function enable_lazy_loading() {
        add_filter('wp_lazy_loading_enabled', '__return_true');
    }

    /**
     * حذف فایل‌های غیرضروری
     *
     * @param array $unnecessary_files لیست فایل‌هایی که باید حذف شوند
     */
    public function remove_unnecessary_files(array $unnecessary_files) {
        foreach ($unnecessary_files as $file) {
            wp_dequeue_script($file);
            wp_dequeue_style($file);
        }
    }

    /**
     * ترکیب و کوچک‌سازی فایل‌ها
     *
     * @param string $type نوع فایل (js یا css)
     * @param array $files لیست فایل‌ها
     * @return string مسیر فایل ترکیب‌شده
     */
    public function minify_and_combine_files($type, array $files) {
        $combined_content = '';
        foreach ($files as $file) {
            $combined_content .= file_get_contents($file);
        }

        $minified_content = $type === 'css' 
            ? $this->minify_css($combined_content) 
            : $this->minify_js($combined_content);

        $output_file = wp_upload_dir()['basedir'] . "/combined.$type";
        file_put_contents($output_file, $minified_content);

        return $output_file;
    }

    /**
     * کوچک‌سازی CSS
     *
     * @param string $css کد CSS
     * @return string کد CSS کوچک‌شده
     */
    private function minify_css($css) {
        return preg_replace('/\s+/', ' ', str_replace(["\n", "\r"], '', $css));
    }

    /**
     * کوچک‌سازی JS
     *
     * @param string $js کد JS
     * @return string کد JS کوچک‌شده
     */
    private function minify_js($js) {
        return preg_replace('/\s+/', ' ', str_replace(["\n", "\r"], '', $js));
    }
}
