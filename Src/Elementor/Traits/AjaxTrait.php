<?php
/**
 * File: AjaxTrait.php
 * Path: src/Elementor/Traits/
 * Description:
 *   مدیریت عملیات ایجکس (AJAX) شامل:
 *   - ثبت اکشن‌های ایجکس در وردپرس
 *   - ارسال و دریافت داده‌ها
 *   - هندل کردن پاسخ‌ها
 * Author: Kiya Holding
 */

namespace Cardifa\Elementor\Traits;

if ( ! defined( 'ABSPATH' ) ) exit; // جلوگیری از دسترسی مستقیم

trait AjaxTrait {

    /**
     * ثبت اکشن ایجکس
     *
     * @param string $action نام اکشن
     * @param callable $callback تابع هندلر
     */
    protected function register_ajax_action(string $action, callable $callback) {
        add_action("wp_ajax_{$action}", $callback); // برای کاربران واردشده
        add_action("wp_ajax_nopriv_{$action}", $callback); // برای کاربران غیرواردشده
    }

    /**
     * ارسال پاسخ موفق
     *
     * @param array $data داده‌هایی که باید در پاسخ ارسال شوند
     */
    protected function send_success_response(array $data = []) {
        wp_send_json_success($data);
    }

    /**
     * ارسال پاسخ خطا
     *
     * @param string $message پیام خطا
     * @param array $data داده‌های اضافی
     */
    protected function send_error_response(string $message, array $data = []) {
        wp_send_json_error(array_merge(['message' => $message], $data));
    }

    /**
     * هندل کردن درخواست ایجکس
     *
     * @param callable $handler تابع پردازش‌کننده
     */
    protected function handle_ajax_request(callable $handler) {
        try {
            // بررسی نانس برای امنیت
            check_ajax_referer('ajax_nonce', 'security');
            
            // اجرای تابع هندلر
            $response = call_user_func($handler, $_POST);

            // ارسال پاسخ موفق
            $this->send_success_response($response);

        } catch (\Exception $e) {
            // ارسال پاسخ خطا
            $this->send_error_response($e->getMessage());
        }
    }
}
