<?php
/**
 * File: ShortcodeHandler.php
 * Description: کلاس مدیریت کدهای کوتاه پیامک
 */

namespace Cardifa\Admin\Settings\SMS;

defined('ABSPATH') || exit;

class ShortcodeHandler
{
    /**
     * دریافت لیست کدهای کوتاه
     */
    public static function get_shortcodes(): array
    {
        return [
            '{site_name}' => __('نام سایت', 'cardifa'),
            '{site_url}' => __('آدرس سایت', 'cardifa'),
            '{admin_email}' => __('ایمیل مدیر', 'cardifa'),
            '{date}' => __('تاریخ', 'cardifa'),
            '{time}' => __('زمان', 'cardifa'),
            '{customer_name}' => __('نام مشتری', 'cardifa'),
            '{customer_first_name}' => __('نام کوچک مشتری', 'cardifa'),
            '{customer_last_name}' => __('نام خانوادگی مشتری', 'cardifa'),
            '{customer_phone}' => __('شماره تلفن مشتری', 'cardifa'),
            '{customer_email}' => __('ایمیل مشتری', 'cardifa'),
            '{order_id}' => __('شناسه سفارش', 'cardifa'),
            '{order_number}' => __('شماره سفارش', 'cardifa'),
            '{order_status}' => __('وضعیت سفارش', 'cardifa'),
            '{order_total}' => __('مبلغ کل سفارش', 'cardifa'),
            '{order_date}' => __('تاریخ سفارش', 'cardifa'),
            '{order_items}' => __('محصولات سفارش', 'cardifa'),
            '{payment_method}' => __('روش پرداخت', 'cardifa'),
            '{shipping_method}' => __('روش ارسال', 'cardifa'),
            '{tracking_code}' => __('کد رهگیری', 'cardifa'),
        ];
    }
    
    /**
     * جایگزینی کدهای کوتاه در متن پیامک
     */
    public static function replace_shortcodes(string $message, array $data = []): string
    {
        $shortcodes = self::get_shortcodes();
        
        // جایگزینی کدهای کوتاه عمومی
        $message = str_replace('{site_name}', get_bloginfo('name'), $message);
        $message = str_replace('{site_url}', get_bloginfo('url'), $message);
        $message = str_replace('{admin_email}', get_bloginfo('admin_email'), $message);
        $message = str_replace('{date}', date_i18n(get_option('date_format')), $message);
        $message = str_replace('{time}', date_i18n(get_option('time_format')), $message);
        
        // جایگزینی کدهای کوتاه داینامیک
        foreach ($data as $key => $value) {
            $message = str_replace('{' . $key . '}', $value, $message);
        }
        
        return $message;
    }
    
    /**
     * پردازش قالب پیامک برای سفارش
     */
    public static function process_order_template(string $template_key, int $order_id): string
    {
        if (!function_exists('wc_get_order')) {
            return '';
        }
        
        $order = wc_get_order($order_id);
        
        if (!$order) {
            return '';
        }
        
        $options = get_option('cardifa_sms_options', []);
        $templates = $options['templates'] ?? [];
        
        if (!isset($templates[$template_key]) || empty($templates[$template_key]['content'])) {
            return '';
        }
        
        $message = $templates[$template_key]['content'];
        
        // دریافت اطلاعات سفارش
        $order_data = [
            'customer_name' => $order->get_formatted_billing_full_name(),
            'customer_first_name' => $order->get_billing_first_name(),
            'customer_last_name' => $order->get_billing_last_name(),
            'customer_phone' => $order->get_billing_phone(),
            'customer_email' => $order->get_billing_email(),
            'order_id' => $order->get_id(),
            'order_number' => $order->get_order_number(),
            'order_status' => wc_get_order_status_name($order->get_status()),
            'order_total' => $order->get_formatted_order_total(),
            'order_date' => date_i18n(get_option('date_format'), $order->get_date_created()->getTimestamp()),
            'payment_method' => $order->get_payment_method_title(),
            'shipping_method' => $order->get_shipping_method(),
            'tracking_code' => $order->get_meta('tracking_code'),
        ];
        
        // دریافت محصولات سفارش
        $items = [];
        foreach ($order->get_items() as $item) {
            $product = $item->get_product();
            $items[] = $item->get_name() . ' × ' . $item->get_quantity();
        }
        $order_data['order_items'] = implode(' - ', $items);
        
        return self::replace_shortcodes($message, $order_data);
    }
}
