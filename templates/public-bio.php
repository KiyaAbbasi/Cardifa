<?php
/**
 * رندر صفحه بایولینک با استفاده از قالب قابل انتخاب (پیش‌فرض: default)
 */

global $post;
$theme = get_post_meta($post->ID, 'cardifa_theme', true);

// اگر قالب انتخاب نشده بود، از قالب default استفاده کن
if (!$theme) {
    $theme = 'default';
}

$template_path = CARDIFA_BIO_PATH . 'templates/themes/' . $theme . '.php';

if (file_exists($template_path)) {
    include $template_path;
} else {
    echo '<h2>قالب انتخاب‌شده وجود ندارد.</h2>';
}
