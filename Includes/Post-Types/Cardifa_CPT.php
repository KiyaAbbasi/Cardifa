<?php
/**
 * File Name:    Cardifa_CPT.php
 * Location:     includes/Post-Types/
 * Description:  ثبت Custom Post Type «کاردیفا» برای پروفایل دیجیتال کاربران (Link-Bio)
 *               – پشتیبانی از REST API و Gutenberg
 *               – پشتیبانی از ویرایش با Elementor
 *               – URL اختصاصی بدون پیشوند
 *               – تصویر شاخص، خلاصه متن، رونوشت
 *               – آرشیو غیرفعال
 * Since:        1.0.0
 * Author:       Kiya Holding
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register 'cardifa' custom post type.
 */
function cardifa_register_cpt() {

    $labels = [
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
        'not_found'             => __( 'هیچ کاردیفایی یافت نشد',  'cardifa' ),
        'not_found_in_trash'    => __( 'هیچ کاردیفایی در سطل زباله یافت نشد', 'cardifa' ),
    ];

    $args = [
        'labels'              => $labels,
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => 'cardifa',   // زیرمنوی منوی اصلی
        'show_in_rest'        => true,        // REST API for Gutenberg & Elementor
        'rest_base'           => 'cardifa',
        'has_archive'         => false,       // آرشیو غیرفعال
        'rewrite'             => [
            'slug'       => 'cardifa',
            'with_front' => false,
        ],
        'capability_type'     => 'post',
        'hierarchical'        => false,
        'supports'            => [
            'title',
            'editor',
            'thumbnail',
            'excerpt',
            'revisions',
            'custom-fields',
        ],
        'menu_icon'           => 'dashicons-id-alt',
    ];

    register_post_type( 'cardifa', $args );

    // اطمینان از پشتیبانی ویرایش با Elementor
    add_post_type_support( 'cardifa', 'elementor' );
}
add_action( 'init', 'cardifa_register_cpt', 0 );

/**
 * Ensure Elementor recognizes 'cardifa' CPT for “Edit with Elementor”.
 */
add_filter( 'elementor/documents/register_post_type', function( array $post_types ): array {
    if ( ! in_array( 'cardifa', $post_types, true ) ) {
        $post_types[] = 'cardifa';
    }
    return $post_types;
}, 10, 1 );
