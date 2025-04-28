<?php
/**
 * File: EventTrackingTrait.php
 * Description:
 *   مدیریت رهگیری رویدادها شامل:
 *   - رهگیری کلیک‌ها و بازدیدها
 *   - ارسال داده‌ها به ابزارهای تحلیل
 */

namespace Cardifa\Elementor\Traits;

if (!defined('ABSPATH')) exit; // جلوگیری از دسترسی مستقیم

trait EventTrackingTrait {

    /**
     * رهگیری کلیک‌ها
     *
     * @param string $selector سلکتور عنصر
     * @param string $event_name نام رویداد
     */
    public function track_clicks($selector, $event_name) {
        add_action('wp_footer', function() use ($selector, $event_name) {
            echo "<script>
                document.querySelector('$selector').addEventListener('click', function() {
                    console.log('$event_name triggered');
                    // ارسال به سرور
                    fetch('".admin_url('admin-ajax.php')."', {
                        method: 'POST',
                        body: new URLSearchParams({
                            action: 'track_event',
                            event_name: '$event_name'
                        })
                    });
                });
            </script>";
        });
    }

    /**
     * ارسال داده به ابزار تحلیل
     *
     * @param string $tool ابزار تحلیل (Google Analytics, etc.)
     * @param array $data داده‌های ارسال‌شده
     */
    public function send_to_analytics($tool, array $data) {
        if ($tool === 'google_analytics') {
            echo "<script>
                gtag('event', '{$data['event_name']}', {
                    'event_category': '{$data['category']}',
                    'event_label': '{$data['label']}',
                    'value': '{$data['value']}'
                });
            </script>";
        }
    }
}
