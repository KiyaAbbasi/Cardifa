<?php
/**
 * File: APIIntegrationTrait.php
 * Description:
 *   مدیریت ارتباط با API‌های خارجی شامل:
 *   - ارسال درخواست به API
 *   - پردازش پاسخ‌ها
 *   - مدیریت خطاهای API
 */

namespace Cardifa\Elementor\Traits;

if (!defined('ABSPATH')) exit; // جلوگیری از دسترسی مستقیم

trait APIIntegrationTrait {

    /**
     * ارسال درخواست به API
     *
     * @param string $url آدرس API
     * @param array $params پارامترهای درخواست
     * @param string $method روش درخواست (GET یا POST)
     * @return array پاسخ API
     */
    public function send_api_request($url, $params = [], $method = 'GET') {
        $args = [
            'method' => strtoupper($method),
            'body'   => $params,
            'timeout' => 15,
        ];

        $response = wp_remote_request($url, $args);

        if (is_wp_error($response)) {
            return ['success' => false, 'message' => $response->get_error_message()];
        }

        $body = wp_remote_retrieve_body($response);
        return json_decode($body, true);
    }

    /**
     * مدیریت خطاهای API
     *
     * @param array $response پاسخ API
     * @return bool آیا خطایی وجود دارد؟
     */
    public function handle_api_errors($response) {
        if (isset($response['error'])) {
            $this->log_error("API Error: " . $response['error']);
            $this->display_error(__('مشکلی در ارتباط با API رخ داده است.', 'cardifa'));
            return true;
        }
        return false;
    }
}
