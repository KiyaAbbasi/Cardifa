<?php
/**
 * File: SMSHandler.php
 * Description: کلاس مدیریت ارسال پیامک
 */

namespace Cardifa\Admin\Settings\SMS;

defined('ABSPATH') || exit;

class SMSHandler
{
    /**
     * تست اتصال به سامانه پیامکی
     */
    public function test_connection(string $service, string $api_key, string $username, string $password, string $line_number): array
    {
        if (empty($service)) {
            return [
                'success' => false,
                'message' => __('سرویس پیامکی انتخاب نشده است.', 'cardifa'),
            ];
        }
        
        switch ($service) {
            case 'kavenegar':
                return $this->test_kavenegar_connection($api_key, $line_number);
            
            case 'melipayamak':
                return $this->test_melipayamak_connection($username, $password, $line_number);
            
            case 'farazsms':
                return $this->test_farazsms_connection($username, $password, $line_number);
            
            case 'smsir':
                return $this->test_smsir_connection($api_key, $line_number);
            
            default:
                return [
                    'success' => false,
                    'message' => __('سرویس پیامکی نامعتبر است.', 'cardifa'),
                ];
        }
    }
    
    /**
     * ارسال پیامک
     */
    public function send_sms(string $service, string $api_key, string $username, string $password, string $line_number, string $mobile, string $message): array
    {
        if (empty($service)) {
            return [
                'success' => false,
                'message' => __('سرویس پیامکی انتخاب نشده است.', 'cardifa'),
            ];
        }
        
        switch ($service) {
            case 'kavenegar':
                return $this->send_kavenegar_sms($api_key, $line_number, $mobile, $message);
            
            case 'melipayamak':
                return $this->send_melipayamak_sms($username, $password, $line_number, $mobile, $message);
            
            case 'farazsms':
                return $this->send_farazsms_sms($username, $password, $line_number, $mobile, $message);
            
            case 'smsir':
                return $this->send_smsir_sms($api_key, $line_number, $mobile, $message);
            
            default:
                return [
                    'success' => false,
                    'message' => __('سرویس پیامکی نامعتبر است.', 'cardifa'),
                ];
        }
    }
    
    /**
     * تست اتصال به کاوه نگار
     */
    private function test_kavenegar_connection(string $api_key, string $line_number): array
    {
        if (empty($api_key)) {
            return [
                'success' => false,
                'message' => __('کلید API وارد نشده است.', 'cardifa'),
            ];
        }
        
        $url = "https://api.kavenegar.com/v1/{$api_key}/account/info.json";
        
        $response = wp_remote_get($url);
        
        if (is_wp_error($response)) {
            return [
                'success' => false,
                'message' => $response->get_error_message(),
            ];
        }
        
        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);
        
        if (isset($data['return']['status']) && $data['return']['status'] == 200) {
            return [
                'success' => true,
                'data' => [
                    'message' => __('اتصال به کاوه نگار با موفقیت برقرار شد.', 'cardifa'),
                    'credit' => $data['entries']['remaincredit'] ?? 0,
                ],
            ];
        }
        
        return [
            'success' => false,
            'message' => $data['return']['message'] ?? __('خطا در اتصال به کاوه نگار.', 'cardifa'),
        ];
    }
    
    /**
     * تست اتصال به ملی پیامک
     */
    private function test_melipayamak_connection(string $username, string $password, string $line_number): array
    {
        if (empty($username) || empty($password)) {
            return [
                'success' => false,
                'message' => __('نام کاربری یا رمز عبور وارد نشده است.', 'cardifa'),
            ];
        }
        
        $url = "https://rest.payamak-panel.com/api/SendSMS/GetCredit";
        $args = [
            'body' => [
                'username' => $username,
                'password' => $password,
            ],
        ];
        
        $response = wp_remote_post($url, $args);
        
        if (is_wp_error($response)) {
            return [
                'success' => false,
                'message' => $response->get_error_message(),
            ];
        }
        
        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);
        
        if (isset($data['Value']) && $data['Value'] !== null) {
            return [
                'success' => true,
                'data' => [
                    'message' => __('اتصال به ملی پیامک با موفقیت برقرار شد.', 'cardifa'),
                    'credit' => $data['Value'],
                ],
            ];
        }
        
        return [
            'success' => false,
            'message' => $data['RetStatus'] ?? __('خطا در اتصال به ملی پیامک.', 'cardifa'),
        ];
    }
    
    /**
     * تست اتصال به فراز اس‌ام‌اس
     */
    private function test_farazsms_connection(string $username, string $password, string $line_number): array
    {
        if (empty($username) || empty($password)) {
            return [
                'success' => false,
                'message' => __('نام کاربری یا رمز عبور وارد نشده است.', 'cardifa'),
            ];
        }
        
        $url = "https://ippanel.com/api/select";
        $args = [
            'body' => [
                'op' => 'credit',
                'uname' => $username,
                'pass' => $password,
            ],
        ];
        
        $response = wp_remote_post($url, $args);
        
        if (is_wp_error($response)) {
            return [
                'success' => false,
                'message' => $response->get_error_message(),
            ];
        }
        
        $body = wp_remote_retrieve_body($response);
        
        if (is_numeric($body)) {
            return [
                'success' => true,
                'data' => [
                    'message' => __('اتصال به فراز اس‌ام‌اس با موفقیت برقرار شد.', 'cardifa'),
                    'credit' => $body,
                ],
            ];
        }
        
        return [
            'success' => false,
            'message' => __('خطا در اتصال به فراز اس‌ام‌اس.', 'cardifa'),
        ];
    }
    
    /**
     * تست اتصال به پنل اس‌ام‌اس
     */
    private function test_smsir_connection(string $api_key, string $line_number): array
    {
        if (empty($api_key)) {
            return [
                'success' => false,
                'message' => __('کلید API وارد نشده است.', 'cardifa'),
            ];
        }
        
        $url = "https://api.sms.ir/users/v1/info/credit";
        $args = [
            'headers' => [
                'x-api-key' => $api_key,
                'Content-Type' => 'application/json',
            ],
        ];
        
        $response = wp_remote_get($url, $args);
        
        if (is_wp_error($response)) {
            return [
                'success' => false,
                'message' => $response->get_error_message(),
            ];
        }
        
        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);
        
        if (isset($data['status']) && $data['status'] == 1) {
            return [
                'success' => true,
                'data' => [
                    'message' => __('اتصال به پنل اس‌ام‌اس با موفقیت برقرار شد.', 'cardifa'),
                    'credit' => $data['data']['credit'] ?? 0,
                ],
            ];
        }
        
        return [
            'success' => false,
            'message' => $data['message'] ?? __('خطا در اتصال به پنل اس‌ام‌اس.', 'cardifa'),
        ];
    }
    
    /**
     * ارسال پیامک با کاوه نگار
     */
    private function send_kavenegar_sms(string $api_key, string $line_number, string $mobile, string $message): array
    {
        if (empty($api_key)) {
            return [
                'success' => false,
                'message' => __('کلید API وارد نشده است.', 'cardifa'),
            ];
        }
        
        $url = "https://api.kavenegar.com/v1/{$api_key}/sms/send.json";
        $args = [
            'body' => [
                'receptor' => $mobile,
                'message' => $message,
                'sender' => $line_number,
            ],
        ];
        
        $response = wp_remote_post($url, $args);
        
        if (is_wp_error($response)) {
            return [
                'success' => false,
                'message' => $response->get_error_message(),
            ];
        }
        
        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);
        
        if (isset($data['return']['status']) && $data['return']['status'] == 200) {
            return [
                'success' => true,
                'data' => [
                    'message' => __('پیامک با موفقیت ارسال شد.', 'cardifa'),
                    'messageid' => $data['entries'][0]['messageid'] ?? '',
                ],
            ];
        }
        
        return [
            'success' => false,
            'message' => $data['return']['message'] ?? __('خطا در ارسال پیامک.', 'cardifa'),
        ];
    }
    
    /**
     * ارسال پیامک با ملی پیامک
     */
    private function send_melipayamak_sms(string $username, string $password, string $line_number, string $mobile, string $message): array
    {
        if (empty($username) || empty($password)) {
            return [
                'success' => false,
                'message' => __('نام کاربری یا رمز عبور وارد نشده است.', 'cardifa'),
            ];
        }
        
        $url = "https://rest.payamak-panel.com/api/SendSMS/SendSMS";
        $args = [
            'body' => [
                'username' => $username,
                'password' => $password,
                'to' => $mobile,
                'from' => $line_number,
                'text' => $message,
            ],
        ];
        
        $response = wp_remote_post($url, $args);
        
        if (is_wp_error($response)) {
            return [
                'success' => false,
                'message' => $response->get_error_message(),
            ];
        }
        
        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);
        
        if (isset($data['RetStatus']) && $data['RetStatus'] == 1) {
            return [
                'success' => true,
                'data' => [
                    'message' => __('پیامک با موفقیت ارسال شد.', 'cardifa'),
                    'messageid' => $data['Value'] ?? '',
                ],
            ];
        }
        
        return [
            'success' => false,
            'message' => $data['RetStatus'] ?? __('خطا در ارسال پیامک.', 'cardifa'),
        ];
    }
    
    /**
     * ارسال پیامک با فراز اس‌ام‌اس
     */
    private function send_farazsms_sms(string $username, string $password, string $line_number, string $mobile, string $message): array
    {
        if (empty($username) || empty($password)) {
            return [
                'success' => false,
                'message' => __('نام کاربری یا رمز عبور وارد نشده است.', 'cardifa'),
            ];
        }
        
        $url = "https://ippanel.com/api/select";
        $args = [
            'body' => [
                'op' => 'send',
                'uname' => $username,
                'pass' => $password,
                'message' => $message,
                'from' => $line_number,
                'to' => $mobile,
            ],
        ];
        
        $response = wp_remote_post($url, $args);
        
        if (is_wp_error($response)) {
            return [
                'success' => false,
                'message' => $response->get_error_message(),
            ];
        }
        
        $body = wp_remote_retrieve_body($response);
        
        if (is_numeric($body) && $body > 0) {
            return [
                'success' => true,
                'data' => [
                    'message' => __('پیامک با موفقیت ارسال شد.', 'cardifa'),
                    'messageid' => $body,
                ],
            ];
        }
        
        return [
            'success' => false,
            'message' => __('خطا در ارسال پیامک.', 'cardifa'),
        ];
    }
    
    /**
     * ارسال پیامک با پنل اس‌ام‌اس
     */
    private function send_smsir_sms(string $api_key, string $line_number, string $mobile, string $message): array
    {
        if (empty($api_key)) {
            return [
                'success' => false,
                'message' => __('کلید API وارد نشده است.', 'cardifa'),
            ];
        }
        
        $url = "https://api.sms.ir/v1/send/bulk";
        $args = [
            'headers' => [
                'x-api-key' => $api_key,
                'Content-Type' => 'application/json',
            ],
            'body' => json_encode([
                'lineNumber' => $line_number,
                'messageText' => $message,
                'mobiles' => [$mobile],
            ]),
        ];
        
        $response = wp_remote_post($url, $args);
        
        if (is_wp_error($response)) {
            return [
                'success' => false,
                'message' => $response->get_error_message(),
            ];
        }
        
        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);
        
        if (isset($data['status']) && $data['status'] == 1) {
            return [
                'success' => true,
                'data' => [
                    'message' => __('پیامک با موفقیت ارسال شد.', 'cardifa'),
                    'messageid' => $data['data']['messageIds'][0] ?? '',
                ],
            ];
        }
        
        return [
            'success' => false,
            'message' => $data['message'] ?? __('خطا در ارسال پیامک.', 'cardifa'),
        ];
    }
}