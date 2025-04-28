<?php
/**
 * File: class-rest-endpoints.php
 * Location: src/API/
 * Description: تعریف Endpointهای REST API برای پلاگین کاردیفا
 * Author: Kiya Holding
 * Since: 1.0.0
 */

namespace Cardifa\API;

use WP_REST_Controller;

if ( ! defined( 'ABSPATH' ) ) exit; // جلوگیری از دسترسی مستقیم

class REST_Endpoints extends WP_REST_Controller {

    /**
     * مقداردهی اولیه و ثبت Endpointها
     */
    public function __construct() {
        add_action( 'rest_api_init', [ $this, 'register_routes' ] );
    }

    /**
     * ثبت Endpointهای REST API
     */
    public function register_routes() {
        register_rest_route(
            'cardifa/v1',
            '/example',
            [
                'methods'  => 'GET',
                'callback' => [ $this, 'example_endpoint' ],
                'permission_callback' => [ $this, 'permissions_check' ],
            ]
        );
    }

    /**
     * چک کردن دسترسی کاربر
     *
     * @return bool
     */
    public function permissions_check() {
        // بررسی دسترسی کاربر (مثلاً باید لاگین باشد)
        return is_user_logged_in();
    }

    /**
     * کال‌بک برای Endpoint نمونه
     *
     * @param \WP_REST_Request $request
     * @return \WP_REST_Response
     */
    public function example_endpoint( $request ) {
        $data = [
            'message' => 'این یک پیام نمونه از REST API است.',
            'status'  => 'success',
        ];

        return rest_ensure_response( $data );
    }
}

// مقداردهی اولیه کلاس
new REST_Endpoints();
