<?php
/**
 * File: PaymentGatewayTrait.php
 * Description:
 *   مدیریت تعامل با درگاه‌های پرداخت شامل:
 *   - ایجاد تراکنش
 *   - بررسی وضعیت تراکنش
 *   - بازپرداخت وجه
 */

namespace Cardifa\Elementor\Traits;

if (!defined('ABSPATH')) exit; // جلوگیری از دسترسی مستقیم

trait PaymentGatewayTrait {

    /**
     * ایجاد تراکنش جدید
     *
     * @param string $amount مبلغ تراکنش
     * @param string $currency واحد پول
     * @param string $callback_url آدرس بازگشت
     * @return array اطلاعات تراکنش
     */
    public function create_transaction($amount, $currency, $callback_url) {
        // شبیه‌سازی درخواست به درگاه پرداخت
        $gateway_url = 'https://payment-gateway.example.com/create';
        $response = wp_remote_post($gateway_url, [
            'body' => [
                'amount'       => $amount,
                'currency'     => $currency,
                'callback_url' => $callback_url,
            ],
        ]);

        if (is_wp_error($response)) {
            return ['success' => false, 'message' => $response->get_error_message()];
        }

        $body = wp_remote_retrieve_body($response);
        return json_decode($body, true);
    }

    /**
     * بررسی وضعیت تراکنش
     *
     * @param string $transaction_id شناسه تراکنش
     * @return array وضعیت تراکنش
     */
    public function check_transaction_status($transaction_id) {
        $gateway_url = 'https://payment-gateway.example.com/status';
        $response = wp_remote_get("$gateway_url?transaction_id=$transaction_id");

        if (is_wp_error($response)) {
            return ['success' => false, 'message' => $response->get_error_message()];
        }

        $body = wp_remote_retrieve_body($response);
        return json_decode($body, true);
    }

    /**
     * بازپرداخت وجه
     *
     * @param string $transaction_id شناسه تراکنش
     * @param string $amount مبلغ بازپرداخت
     * @return array نتیجه بازپرداخت
     */
    public function refund_transaction($transaction_id, $amount) {
        $gateway_url = 'https://payment-gateway.example.com/refund';
        $response = wp_remote_post($gateway_url, [
            'body' => [
                'transaction_id' => $transaction_id,
                'amount'         => $amount,
            ],
        ]);

        if (is_wp_error($response)) {
            return ['success' => false, 'message' => $response->get_error_message()];
        }

        $body = wp_remote_retrieve_body($response);
        return json_decode($body, true);
    }
}
