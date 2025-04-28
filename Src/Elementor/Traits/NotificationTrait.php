<?php
/**
 * File: NotificationTrait.php
 * Description:
 *   مدیریت ارسال اعلان‌ها شامل:
 *   - اعلان‌های ایمیلی
 *   - اعلان‌های Push Notification
 *   - زمان‌بندی ارسال اعلان‌ها
 */

namespace Cardifa\Elementor\Traits;

if (!defined('ABSPATH')) exit; // جلوگیری از دسترسی مستقیم

trait NotificationTrait {

    /**
     * ارسال ایمیل
     *
     * @param string $to آدرس گیرنده
     * @param string $subject موضوع ایمیل
     * @param string $message متن ایمیل
     * @return bool نتیجه ارسال
     */
    public function send_email_notification($to, $subject, $message) {
        $headers = ['Content-Type: text/html; charset=UTF-8'];
        return wp_mail($to, $subject, $message, $headers);
    }

    /**
     * ارسال Push Notification
     *
     * @param string $device_token توکن دستگاه
     * @param string $title عنوان اعلان
     * @param string $message متن اعلان
     * @return array نتیجه ارسال
     */
    public function send_push_notification($device_token, $title, $message) {
        $push_service_url = 'https://push-service.example.com/send';
        $response = wp_remote_post($push_service_url, [
            'body' => [
                'device_token' => $device_token,
                'title'        => $title,
                'message'      => $message,
            ],
        ]);

        if (is_wp_error($response)) {
            return ['success' => false, 'message' => $response->get_error_message()];
        }

        $body = wp_remote_retrieve_body($response);
        return json_decode($body, true);
    }

    /**
     * زمان‌بندی ارسال اعلان
     *
     * @param string $time زمان ارسال (فرمت: Y-m-d H:i:s)
     * @param callable $callback تابع برای ارسال اعلان
     * @param array $args آرگومان‌های تابع
     */
    public function schedule_notification($time, callable $callback, $args = []) {
        wp_schedule_single_event(strtotime($time), 'send_scheduled_notification', $args);
        add_action('send_scheduled_notification', $callback, 10, count($args));
    }
}
