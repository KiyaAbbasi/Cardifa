<?php
/**
 * File: elementor-category.php
 * Location: src/Elementor/
 * Desc: ثبت دسته‌ی اختصاصی «کاردیفا»
 */
defined( 'ABSPATH' ) || exit;

use Elementor\Plugin;

add_action( 'elementor/init', function() {
    Plugin::instance()->elements_manager->add_category(
        'cardifa',
        [
            'title' => __( 'کاردیفا', 'cardifa' ),
            'icon'  => 'dashicons-id',
        ],
        10
    );
}, 5 );
