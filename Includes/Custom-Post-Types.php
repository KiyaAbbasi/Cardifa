<?php
/**
 * File: register-cardifa-posttype.php
 * Location: includes/
 * Description:
 *   ثبت Custom Post Type «کاردیفا» برای پروفایل دیجیتال کاربران (Link‑Bio)
 *   – پشتیبانی از REST API (برای Gutenberg و Elementor)
 *   – پشتیبانی از Elementor (ویرایشگر المنتور)
 *   – URL اختصاصی بدون پیشوند
 *   – تصویر شاخص، خلاصه متن، رونوشت
 *   – آرشیو غیرفعال
 * Author:      Kiya Holding
 * Since:       1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register 'cardifa' custom post type.
 *
 * This CPT is used for digital profiles (Link‑Bio) and must be
 * editable via Elementor and REST‑aware.
 */
function cardifa_register_post_type() {

    // ۱) برچسب‌ها (Labels) برای نمایش در پنل مدیریت
    $labels = array(
        'name'                  => _x( 'کاردیفا‌ها',    'Post type general name',   'cardifa' ),
        'singular_name'         => _x( 'کاردیفا',       'Post type singular name',  'cardifa' ),
        'menu_name'             => _x( 'کاردیفا‌ها',    'Admin Menu text',          'cardifa' ),
        'name_admin_bar'        => _x( 'کاردیفا',       'Add New on Toolbar',       'cardifa' ),
        'add_new'               => __( 'افزودن کاردیفا',          'cardifa' ),
        'add_new_item'          => __( 'افزودن کاردیفا جدید',     'cardifa' ),
        'edit_item'             => __( 'ویرایش کاردیفا',         'cardifa' ),
        'new_item'              => __( 'کاردیفای جدید',          'cardifa' ),
        'view_item'             => __( 'نمایش کاردیفا',          'cardifa' ),
        'all_items'             => __( 'همه کاردیفا‌ها',         'cardifa' ),
        'search_items'          => __( 'جستجوی کاردیفا',        'cardifa' ),
        'not_found'             => __( 'هیچ کاردیفایی پیدا نشد',  'cardifa' ),
        'not_found_in_trash'    => __( 'هیچ کاردیفایی در سطل زباله نیست', 'cardifa' ),
    );

    // ۲) آرگومان‌های CPT
    $args = array(
        'labels'              => $labels,
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => 'cardifa_main_menu',   // زیرمنوی «کاردیفا»
        'menu_position'       => 40,
        'menu_icon'           => 'dashicons-id',
        'show_in_admin_bar'   => true,
        'show_in_rest'        => true,                  // فعال برای Gutenberg و REST API
        'rest_base'           => 'cardifa',             // endpoint: /wp-json/wp/v2/cardifa
        'has_archive'         => false,                 // آرشیو غیرفعال
        'rewrite'             => array(
            'slug'       => 'cardifa',
            'with_front' => false,
        ),
        'capability_type'     => 'post',
        'hierarchical'        => false,
        'supports'            => array(
            'title',
            'editor',
            'thumbnail',
            'excerpt',
            'revisions',
            'custom-fields',
            'elementor',    // پشتیبانی مستقیم از Elementor
        ),
        'query_var'           => true,
    );

    register_post_type( 'cardifa', $args );

    // ۳) اطمینان از پشتیبانی Elementor برای این CPT
    add_post_type_support( 'cardifa', 'elementor' );
}
add_action( 'init', 'cardifa_register_post_type', 0 );

/**
 * Ensure Elementor recognizes 'cardifa' CPT for “Edit with Elementor”
 */
add_filter( 'elementor/documents/register_post_type', function( $post_types ) {
    if ( ! in_array( 'cardifa', $post_types, true ) ) {
        $post_types[] = 'cardifa';
    }
    return $post_types;
}, 10, 1 );
