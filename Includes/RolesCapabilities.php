<?php
/**
 * File Name:    RolesCapabilities.php
 * Location:     Includes/
 * Description:  تعریف نقش‌ها و قابلیت‌ها
 */
defined( 'ABSPATH' ) || exit;

/**
 * اضافه کردن نقش اختصاصی و تنظیم قابلیت‌ها
 */
function cardifa_add_roles_caps() {
    // ایجاد نقش جدید کاربر کاردیفا
    add_role(
        'cardifa_user',              // شناسه نقش
        __('کاربرکاردیفا','cardifa'), // نام قابل نمایش
        ['read' => true]            // قابلیت پایه
    );

    // افزایش قابلیت‌های نقش
    $role = get_role( 'cardifa_user' );
    if ( $role ) {
        $role->add_cap( 'edit_cardifa_card' );
        $role->add_cap( 'publish_cardifa_card' );
        $role->add_cap( 'delete_cardifa_card' );
    }
}
add_action( 'init', 'cardifa_add_roles_caps' );
