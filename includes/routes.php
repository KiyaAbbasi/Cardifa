<?php
/**
 * 📁 فایل routes.php
 * ------------------
 * مدیریت نمایش بایولینک‌ها به صورت cardifa.link/username
 */

if (!defined('ABSPATH')) exit;

/**
 * ✅ تعریف قوانین بازنویسی (rewrite) برای cardifa.link/username
 */
add_action('init', function () {
    // تعریف query var جدید به نام cardifa_user
    add_rewrite_tag('%cardifa_user%', '([^&]+)');

    // تعریف قانون rewrite برای URL مستقیم مانند: site.com/username
    add_rewrite_rule('^([^/]+)/?$', 'index.php?cardifa_user=$matches[1]', 'top');
});

/**
 * ✅ ثبت query var در لیست متغیرهای وردپرس
 */
add_filter('query_vars', function ($vars) {
    $vars[] = 'cardifa_user';
    return $vars;
});

/**
 * ✅ مسیردهی و نمایش قالب نمایشی بایولینک
 */
add_action('template_redirect', function () {
    // گرفتن اسلاگ از آدرس URL
    $slug = get_query_var('cardifa_user');
    if (!$slug) return; // اگر slug نبود، ادامه نده

    // پیدا کردن پست با اسلاگ مربوطه از نوع cardifa
    $found_post = get_page_by_path($slug, OBJECT, 'cardifa');

    if ($found_post && $found_post->post_status === 'publish') {
        global $post;
        $post = $found_post;
        setup_postdata($post);

        // لود قالب نمایشی از پوشه themes
        include CARDIFA_BIO_PATH . 'templates/themes/default.php';
        exit;
    }

    // اگر پست پیدا نشد، نمایش صفحه 404
    global $wp_query;
    $wp_query->set_404();
    status_header(404);
    nocache_headers();
    include get_404_template();
    exit;
});