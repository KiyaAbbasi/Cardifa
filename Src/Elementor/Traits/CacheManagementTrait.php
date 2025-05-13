<?php
/**
 * File: CacheManagementTrait.php
 * Description:
 *   مدیریت کش شامل:
 *   - ذخیره‌سازی موقت داده‌ها
 *   - پاکسازی کش
 */

namespace Cardifa\Elementor\Traits;

if (!defined('ABSPATH')) exit; // جلوگیری از دسترسی مستقیم

trait CacheManagementTrait {

    /**
     * ذخیره‌سازی داده در کش
     *
     * @param string $key کلید کش
     * @param mixed $value مقدار کش
     * @param int $expiration زمان انقضا (ثانیه)
     */
    public function set_cache($key, $value, $expiration = 3600) {
        set_transient($key, $value, $expiration);
    }

    /**
     * دریافت داده از کش
     *
     * @param string $key کلید کش
     * @return mixed مقدار کش یا false اگر وجود نداشت
     */
    public function get_cache($key) {
        return get_transient($key);
    }

    /**
     * حذف یک کش خاص
     *
     * @param string $key کلید کش
     */
    public function delete_cache($key) {
        delete_transient($key);
    }

    /**
     * پاکسازی کامل کش
     */
    public function clear_all_cache() {
        global $wpdb;
        $wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_%'");
    }
}
