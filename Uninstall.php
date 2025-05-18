<?php
/**
 * Uninstall Cardifa Plugin
 * حذف کامل جداول، تنظیمات و داده‌های افزونه
 */

// امنیت: اجرای مستقیم فایل ممنوع
defined('WP_UNINSTALL_PLUGIN') || exit;

// 1. حذف جداول دیتابیس
global $wpdb;
$tables = [
    $wpdb->prefix . 'cardifa_table1',
    $wpdb->prefix . 'cardifa_table2',
];
foreach ($tables as $table) {
    $wpdb->query("DROP TABLE IF EXISTS {$table}");
}

// 2. حذف تنظیمات ذخیره‌شده در wp_options
delete_option('cardifa_settings');
delete_option('cardifa_other_option');

// 3. حذف داده‌های متا مرتبط با پست‌ها
$meta_keys = ['cardifa_meta_key1', 'cardifa_meta_key2'];
foreach ($meta_keys as $key) {
    $wpdb->query(
        $wpdb->prepare("DELETE FROM {$wpdb->postmeta} WHERE meta_key = %s", $key)
    );
}

// 4. حذف نقش‌ها و قابلیت‌ها
remove_role('cardifa_user');

// 5. حذف پوشه‌های افزونه (در صورت لزوم)
// توجه: این بخش باید با احتیاط فراوان انجام شود
$upload_dir = wp_upload_dir();
$cardifa_dir = $upload_dir['basedir'] . '/cardifa';
if (is_dir($cardifa_dir)) {
    array_map('unlink', glob("$cardifa_dir/*.*"));
    rmdir($cardifa_dir);
}
