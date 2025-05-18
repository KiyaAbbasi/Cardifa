<?php
/**
 * File Name:       Rest_Api.php
 * Description:     پیاده‌سازی REST API برای کاردیفا
 * Since:           1.0.0
 * Last Modified:   2025-04-24 15:02:06
 * @author          Kiya Holding
 * Author URI:      https://kiyaholding.com
 * License:         GPLv3 or later
 * License URI:     https://www.gnu.org/licenses/gpl-3.0.html
 * 
 * @package         Cardifa\Api
 */

namespace Cardifa\Api;

use WP_REST_Server;
use WP_REST_Request;
use WP_REST_Response;
use WP_Error;

defined('ABSPATH') || exit;

/**
 * کلاس پیاده‌سازی REST API
 *
 * @since      1.0.0
 * @package    Cardifa\Api
 * @author     Kiya Holding
 */
class Rest_Api {
    /**
     * @var string نسخه API
     */
    private $version = 'v1';

    /**
     * @var string پیشوند مسیرها
     */
    private $namespace;

    /**
     * سازنده کلاس
     * راه‌اندازی REST API
     *
     * @since 1.0.0
     */
    public function __construct() {
        $this->namespace = 'cardifa/' . $this->version;
        add_action('rest_api_init', [$this, 'register_routes']);
    }

    /**
     * ثبت مسیرهای API
     *
     * @since 1.0.0
     */
    public function register_routes() {
        // دریافت لیست کارت‌ها
        register_rest_route($this->namespace, '/cards', [
            [
                'methods'             => WP_REST_Server::READABLE,
                'callback'            => [$this, 'get_cards'],
                'permission_callback' => '__return_true',
            ],
            [
                'methods'             => WP_REST_Server::CREATABLE,
                'callback'            => [$this, 'create_card'],
                'permission_callback' => [$this, 'check_create_permission'],
                'args'               => $this->get_card_update_args(),
            ],
        ]);

        // عملیات روی یک کارت خاص
        register_rest_route($this->namespace, '/cards/(?P<id>\d+)', [
            [
                'methods'             => WP_REST_Server::READABLE,
                'callback'            => [$this, 'get_card'],
                'permission_callback' => '__return_true',
            ],
            [
                'methods'             => WP_REST_Server::EDITABLE,
                'callback'            => [$this, 'update_card'],
                'permission_callback' => [$this, 'check_update_permission'],
                'args'               => $this->get_card_update_args(),
            ],
            [
                'methods'             => WP_REST_Server::DELETABLE,
                'callback'            => [$this, 'delete_card'],
                'permission_callback' => [$this, 'check_delete_permission'],
            ],
        ]);
    }

    /**
     * بررسی دسترسی ایجاد کارت
     *
     * @param WP_REST_Request $request درخواست REST
     * @return bool|WP_Error
     * @since 1.0.0
     */
    public function check_create_permission($request) {
        if (!is_user_logged_in()) {
            return new WP_Error(
                'rest_forbidden',
                'شما باید وارد شوید.',
                ['status' => 401]
            );
        }

        return true;
    }

    /**
     * بررسی دسترسی به‌روزرسانی کارت
     *
     * @param WP_REST_Request $request درخواست REST
     * @return bool|WP_Error
     * @since 1.0.0
     */
    public function check_update_permission($request) {
        $card = get_post($request['id']);

        if (!$card || $card->post_type !== 'cardifa') {
            return new WP_Error(
                'rest_not_found',
                'کارت مورد نظر یافت نشد.',
                ['status' => 404]
            );
        }

        if (!current_user_can('edit_post', $card->ID)) {
            return new WP_Error(
                'rest_forbidden',
                'شما اجازه ویرایش این کارت را ندارید.',
                ['status' => 403]
            );
        }

        return true;
    }

    /**
     * بررسی دسترسی حذف کارت
     *
     * @param WP_REST_Request $request درخواست REST
     * @return bool|WP_Error
     * @since 1.0.0
     */
    public function check_delete_permission($request) {
        $card = get_post($request['id']);

        if (!$card || $card->post_type !== 'cardifa') {
            return new WP_Error(
                'rest_not_found',
                'کارت مورد نظر یافت نشد.',
                ['status' => 404]
            );
        }

        if (!current_user_can('delete_post', $card->ID)) {
            return new WP_Error(
                'rest_forbidden',
                'شما اجازه حذف این کارت را ندارید.',
                ['status' => 403]
            );
        }

        return true;
    }

    /**
     * دریافت لیست کارت‌ها
     *
     * @param WP_REST_Request $request درخواست REST
     * @return WP_REST_Response
     * @since 1.0.0
     */
    public function get_cards($request) {
        $args = [
            'post_type'      => 'cardifa',
            'post_status'    => 'publish',
            'posts_per_page' => 10,
            'paged'          => $request->get_param('page') ?? 1,
        ];

        $query = new \WP_Query($args);
        $cards = [];

        foreach ($query->posts as $card) {
            $cards[] = $this->prepare_card_response($card);
        }

        return new WP_REST_Response([
            'cards'     => $cards,
            'total'     => $query->found_posts,
            'max_pages' => $query->max_num_pages,
        ]);
    }

    /**
     * دریافت یک کارت خاص
     *
     * @param WP_REST_Request $request درخواست REST
     * @return WP_REST_Response|WP_Error
     * @since 1.0.0
     */
    public function get_card($request) {
        $card = get_post($request['id']);

        if (!$card || $card->post_type !== 'cardifa') {
            return new WP_Error(
                'card_not_found',
                'کارت مورد نظر یافت نشد.',
                ['status' => 404]
            );
        }

        return new WP_REST_Response($this->prepare_card_response($card));
    }

    /**
     * حذف کارت
     *
     * @param WP_REST_Request $request درخواست REST
     * @return WP_REST_Response|WP_Error
     * @since 1.0.0
     */
    public function delete_card($request) {
        $card = get_post($request['id']);

        if (!$card || $card->post_type !== 'cardifa') {
            return new WP_Error(
                'card_not_found',
                'کارت مورد نظر یافت نشد.',
                ['status' => 404]
            );
        }

        $result = wp_delete_post($request['id'], true);

        if (!$result) {
            return new WP_Error(
                'card_deletion_failed',
                'حذف کارت با خطا مواجه شد.',
                ['status' => 500]
            );
        }

        return new WP_REST_Response(null, 204);
    }

    /**
     * آماده‌سازی پاسخ کارت برای API
     *
     * @param \WP_Post $card پست کارت
     * @return array
     * @since 1.0.0
     */
    private function prepare_card_response($card) {
        return [
            'id'           => $card->ID,
            'title'        => $card->post_title,
            'content'      => $card->post_content,
            'excerpt'      => get_the_excerpt($card),
            'status'       => $card->post_status,
            'author'       => [
                'id'   => $card->post_author,
                'name' => get_the_author_meta('display_name', $card->post_author),
            ],
            'date'         => mysql_to_rfc3339($card->post_date),
            'modified'     => mysql_to_rfc3339($card->post_modified),
            'link'         => get_permalink($card->ID),
            'thumbnail'    => get_the_post_thumbnail_url($card->ID, 'full'),
        ];
    }

    /**
     * دریافت پارامترهای مورد نیاز برای به‌روزرسانی کارت
     *
     * @return array
     * @since 1.0.0
     */
    private function get_card_update_args() {
        return [
            'title' => [
                'type'             => 'string',
                'sanitize_callback' => 'sanitize_text_field',
            ],
            'content' => [
                'type'             => 'string',
                'sanitize_callback' => 'wp_kses_post',
            ],
            'status' => [
                'type'             => 'string',
                'enum'             => ['publish', 'draft', 'private'],
                'sanitize_callback' => 'sanitize_text_field',
            ],
        ];
    }
}
