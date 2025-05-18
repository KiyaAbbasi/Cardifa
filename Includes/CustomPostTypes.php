<?php
/**
 * File: CustomPostTypes.php
 * ثبت CPT «کاردیفا» بدون خودکارسازی منو
 */

defined('ABSPATH') || exit;

function cardifa_register_post_type() {
    $labels = [
        'name'               => _x('کاردیفا‌ها','general','cardifa'),
        'singular_name'      => _x('کاردیفا','singular','cardifa'),
        'menu_name'          => _x('کاردیفا','menu','cardifa'),
        'name_admin_bar'     => _x('کاردیفا','admin','cardifa'),
        'all_items'          => __('لیست کاردیفا‌ها','cardifa'),
        'add_new'            => __('افزودن کاردیفا','cardifa'),
        'add_new_item'       => __('افزودن کاردیفا جدید','cardifa'),
        'edit_item'          => __('ویرایش کاردیفا','cardifa'),
        'view_item'          => __('نمایش کاردیفا','cardifa'),
        'search_items'       => __('جستجوی کاردیفا','cardifa'),
        'not_found'          => __('هیچ موردی یافت نشد','cardifa'),
        'not_found_in_trash' => __('در سطل زباله چیزی نیست','cardifa'),
    ];

    $args = [
        'labels'             => $labels,
        'public'             => true,
        'show_ui'            => true,
        'show_in_menu'       => false,   // ◀️ بسیار مهم
        'show_in_rest'       => true,
        'has_archive'        => false,
        'rewrite'            => ['slug'=>'cardifa','with_front'=>false],
        'supports'           => ['title','editor','thumbnail','excerpt','revisions','custom-fields'],
        'menu_icon'          => 'dashicons-id-alt',
    ];

    register_post_type('cardifa', $args);
    add_post_type_support('cardifa', 'elementor');
}
add_action('init', 'cardifa_register_post_type', 0);

// اطمینان از پشتیبانی المنتور
add_filter( 'elementor/documents/register_post_type', function( $post_types ) {
    if ( ! in_array( 'cardifa', $post_types, true ) ) {
        $post_types[] = 'cardifa';
    }
    return $post_types;
}, 10, 1 );

/**
 * Ensure Elementor recognizes 'cardifa' CPT for “Edit with Elementor”
 */
add_filter( 'elementor/documents/register_post_type', function( $post_types ) {
    if ( ! in_array( 'cardifa', $post_types, true ) ) {
        $post_types[] = 'cardifa';
    }
    return $post_types;
}, 10, 1 );
