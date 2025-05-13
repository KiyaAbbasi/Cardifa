<?php
/**
 * File: ErrorHandlingTrait.php
 * Description:
 *   مدیریت خطاها شامل:
 *   - گزارش خطاها
 *   - نمایش پیام‌های مناسب به کاربران
 *   - ثبت خطاها در فایل لاگ
 */

namespace Cardifa\Elementor\Traits;

if (!defined('ABSPATH')) exit; // جلوگیری از دسترسی مستقیم

trait ErrorHandlingTrait {

    /**
     * ثبت خطا در فایل لاگ
     *
     * @param string $error_message پیام خطا
     */
    public function log_error($error_message) {
        $log_file = WP_CONTENT_DIR . '/logs/error_log.txt';
        if (!file_exists(dirname($log_file))) {
            mkdir(dirname($log_file), 0755, true);
        }
        $timestamp = date('Y-m-d H:i:s');
        error_log("[$timestamp] $error_message\n", 3, $log_file);
    }

    /**
     * نمایش پیام‌های خطای کاربرپسند
     *
     * @param string $message پیام کاربرپسند
     */
    public function display_error($message) {
        echo "<div class='error-message' style='color: red; font-weight: bold;'>$message</div>";
    }

    /**
     * پردازش خطا
     *
     * @param \Exception $exception شیء خطا
     */
    public function handle_exception(\Exception $exception) {
        $this->log_error($exception->getMessage());
        $this->display_error(__('مشکلی رخ داده است. لطفاً دوباره تلاش کنید.', 'cardifa'));
    }
}
