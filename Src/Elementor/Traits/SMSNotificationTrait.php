<?php
/**
 * File: SMSNotificationTrait.php
 * Description:
 *   مدیریت ارسال پیامک شامل:
 *   - ارسال پیامک به کاربران
 *   - پشتیبانی از APIهای پیامکی
 */

namespace Cardifa\Elementor\Traits;

if (!defined('ABSPATH')) exit; // جلوگیری از دسترسی مستقیم

trait SMSNotificationTrait {

    /**
     * ارسال پیامک
     *
     * @param string $phone_number شماره موبایل
     * @param string $message متن پیامک
     * @return array نتیجه عملیات
     */
    public function send_sms($phone_number, $message) {
        // تنظیمات API پیامک
        $api_url = 'https://sms-gateway.example.com/send';
        $api_key = 'YOUR_API_KEY';

        // ارسال درخواست
        $response = wp_remote_post($api_url, [
            'body' => [
                'api_key'      => $api_key,
                'phone_number' => $phone_number,
                'message'      => $message,
            ],
        ]);

        if (is_wp_error($response)) {
            return ['success' => false, 'message' => $response->get_error_message()];
        }

        $body = wp_remote_retrieve_body($response);
        $result = json_decode($body, true);

        if ($result['status'] !== 'success') {
            return ['success' => false, 'message' => $result['message']];
        }

        return ['success' => true, 'message' => 'پیامک با موفقیت ارسال شد.'];
    }
}
