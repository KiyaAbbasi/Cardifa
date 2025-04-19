<?php
/**
 * 📁 فایل post-type.php
 * -----------------------
 * تعریف پست تایپ اختصاصی برای ساخت بایولینک‌های Cardifa
 */

if (!defined('ABSPATH')) exit;

/**
 * ✅ ثبت پست تایپ cardifa
 */
function cardifa_register_post_type() {
    $labels = array(
        'name'               => 'کاردیفا‌ها',
        'singular_name'      => 'کاردیفا',
        'add_new'            => 'افزودن کاردیفای جدید',
        'add_new_item'       => 'افزودن کاردیفا',
        'edit_item'          => 'ویرایش کاردیفا',
        'new_item'           => 'کاردیفای جدید',
        'view_item'          => 'مشاهده کاردیفا',
        'search_items'       => 'جستجوی کاردیفا‌ها',
        'not_found'          => 'موردی یافت نشد',
        'not_found_in_trash' => 'در زباله‌دان چیزی یافت نشد',
        'menu_name'          => 'کاردیفا‌ها',
    );

    $args = array(
        'label'               => 'کاردیفا',
        'labels'              => $labels,
        'public'              => true,
        'has_archive'         => false,
        'publicly_queryable'  => true,
        'rewrite'             => false, // مسیر رو خودمون تو routes.php کنترل می‌کنیم
        'supports'            => array('title', 'editor', 'author'),
        'capability_type'     => 'post',
        'show_in_rest'        => true,
        'menu_position'       => 10,
        'menu_icon'           => 'dashicons-admin-links',
        'exclude_from_search' => true,
        'show_in_nav_menus'   => false,
    );

    register_post_type('cardifa', $args);
}
add_action('init', 'cardifa_register_post_type');
