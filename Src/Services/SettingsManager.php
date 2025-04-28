<?php
/**
 * File Name:       SettingsManager.php
 * Description:     مدیریت تمام تنظیمات پلاگین
 * Since:           1.0.0
 * Last Modified:   2025-04-24 14:02
 * Author:          Kiya Holding
 * Author URI:      https://kiyaholding.com
 * License:         GPLv3 or later
 * License URI:     https://www.gnu.org/licenses/gpl-3.0.html
 * 
 * @package         Cardifa\Core\Services
 */

namespace Cardifa\Src\Services;

defined('ABSPATH') || exit;

/**
 * کلاس مدیریت تنظیمات
 * این کلاس مسئول مدیریت تمام تنظیمات پلاگین است
 *
 * @since      1.0.0
 * @package    Cardifa\Core\Services
 * @author     Kiya Holding
 */
class SettingsManager {
    /**
     * @var array تنظیمات پیش‌فرض
     */
    private $defaults = [];

    /**
     * @var array تنظیمات فعلی
     */
    private $settings = [];

    /**
     * سازنده کلاس
     * بارگذاری تنظیمات از دیتابیس
     *
     * @since 1.0.0
     */
    public function __construct() {
        $this->set_defaults();
        $this->load_settings();
    }

    /**
     * تنظیم مقادیر پیش‌فرض
     *
     * @since 1.0.0
     */
    private function set_defaults() {
        $this->defaults = [
            'general' => [
                'max_cards' => 5,
                'enable_sms' => true,
            ],
            'plans' => [],
            'sms' => [
                'api_key' => '',
                'sender' => '',
            ]
        ];
    }

    /**
     * بارگذاری تنظیمات از دیتابیس
     *
     * @since 1.0.0
     */
    private function load_settings() {
        $saved_settings = get_option('cardifa_settings', []);
        $this->settings = wp_parse_args($saved_settings, $this->defaults);
    }

    /**
     * دریافت یک تنظیم خاص
     *
     * @param string $key کلید تنظیم
     * @param mixed $default مقدار پیش‌فرض
     * @return mixed
     * @since 1.0.0
     */
    public function get($key, $default = null) {
        return isset($this->settings[$key]) ? $this->settings[$key] : $default;
    }

    /**
     * تنظیم یک مقدار
     *
     * @param string $key کلید تنظیم
     * @param mixed $value مقدار
     * @since 1.0.0
     */
    public function set($key, $value) {
        $this->settings[$key] = $value;
    }

    /**
     * ذخیره تنظیمات در دیتابیس
     *
     * @return bool
     * @since 1.0.0
     */
    public function save() {
        return update_option('cardifa_settings', $this->settings);
    }
}
