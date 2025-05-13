<?php
/**
 * File Name:       Ajax-Handler.php
 * Description:     مدیریت درخواست‌های Ajax کاردیفا
 * Since:           1.0.0
 * Last Modified:   2025-04-24 15:00:15
 * @author          Kiya Holding
 * Author URI:      https://kiyaholding.com
 * License:         GPLv3 or later
 * License URI:     https://www.gnu.org/licenses/gpl-3.0.html
 * 
 * @package         Cardifa\Api
 */

namespace Cardifa\Api;

defined('ABSPATH') || exit;

/**
 * کلاس مدیریت Ajax
 *
 * @since      1.0.0
 * @package    Cardifa\Api
 * @author     Kiya Holding
 */
class Ajax_Handler {
    /**
     * سازنده کلاس
     * ثبت اکشن‌های Ajax
     *
     * @since 1.0.0
     */
    public function __construct() {
        // ثبت اکشن‌های عمومی
        add_action('wp_ajax_nopriv_cardifa_load_cards', [$this, 'load_cards']);
        add_action('wp_ajax_cardifa_load_cards', [$this, 'load_cards']);

        // ثبت اکشن‌های مخصوص کاربران
        add_action('wp_ajax_cardifa_save_card', [$this, 'save_card']);
        add_action('wp_ajax_cardifa_delete_card', [$this, 'delete_card']);
        add_action('wp_ajax_cardifa_update_settings', [$this, 'update_settings']);
    }

    /**
     * بارگذاری کارت‌ها
     *
     * @since 1.0.0
     */
    public function load_cards() {
        check_ajax_referer('cardifa-public', 'nonce');

        $page = isset($_POST['page']) ? absint($_POST['page']) : 1;
        $per_page = 10;

        $args = [
            'post_type'      => 'cardifa',
            'post_status'    => 'publish',
            'posts_per_page' => $per_page,
            'paged'          => $page,
        ];

        $query = new \WP_Query($args);
        $cards = [];

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $cards[] = [
                    'id'          => get_the_ID(),
                    'title'       => get_the_title(),
                    'excerpt'     => get_the_excerpt(),
                    'permalink'   => get_permalink(),
                    'thumbnail'   => get_the_post_thumbnail_url(),
                    'author'      => get_the_author(),
                    'date'        => get_the_date(),
                ];
            }
            wp_reset_postdata();
        }

        wp_send_json_success([
            'cards'      => $cards,
            'max_pages'  => $query->max_num_pages,
            'found'      => $query->found_posts,
        ]);
    }

    /**
     * ذخیره کارت
     *
     * @since 1.0.0
     */
    public function save_card() {
        check_ajax_referer('cardifa-public', 'nonce');

        if (!is_user_logged_in()) {
            wp_send_json_error('شما اجازه دسترسی ندارید.');
        }

        $card_data = [
            'post_title'   => sanitize_text_field($_POST['title']),
            'post_content' => wp_kses_post($_POST['content']),
            'post_type'    => 'cardifa',
            'post_status'  => 'publish',
            'post_author'  => get_current_user_id(),
        ];

        $card_id = wp_insert_post($card_data, true);

        if (is_wp_error($card_id)) {
            wp_send_json_error('خطا در ذخیره کارت.');
        }

        wp_send_json_success([
            'id'        => $card_id,
            'message'   => 'کارت با موفقیت ذخیره شد.',
            'redirect'  => get_permalink($card_id),
        ]);
    }

    /**
     * حذف کارت
     *
     * @since 1.0.0
     */
    public function delete_card() {
        check_ajax_referer('cardifa-public', 'nonce');

        if (!is_user_logged_in()) {
            wp_send_json_error('شما اجازه دسترسی ندارید.');
        }

        $card_id = absint($_POST['card_id']);
        $card = get_post($card_id);

        if (!$card || $card->post_type !== 'cardifa' || $card->post_author != get_current_user_id()) {
            wp_send_json_error('شما اجازه حذف این کارت را ندارید.');
        }

        if (wp_delete_post($card_id, true)) {
            wp_send_json_success('کارت با موفقیت حذف شد.');
        }

        wp_send_json_error('خطا در حذف کارت.');
    }

    /**
     * به‌روزرسانی تنظیمات کاربر
     *
     * @since 1.0.0
     */
    public function update_settings() {
        check_ajax_referer('cardifa-public', 'nonce');

        if (!is_user_logged_in()) {
            wp_send_json_error('شما اجازه دسترسی ندارید.');
        }

        $user_id = get_current_user_id();
        $settings = [
            'notification' => isset($_POST['notification']) ? 'yes' : 'no',
            'privacy'     => sanitize_text_field($_POST['privacy']),
            'theme'       => sanitize_text_field($_POST['theme']),
        ];

        foreach ($settings as $key => $value) {
            update_user_meta($user_id, 'cardifa_' . $key, $value);
        }

        wp_send_json_success('تنظیمات با موفقیت ذخیره شد.');
    }
}
