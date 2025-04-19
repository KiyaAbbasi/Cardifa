<?php
/**
 * 📁 widgets-loader.php
 * ----------------------
 * بارگذاری تمام ویجت‌های المنتوری کاردیفا
 */

if (!defined('ABSPATH')) exit;

// 📂 دسته‌بندی اختصاصی کاردیفا در پنل المنتور
add_action('elementor/elements/categories_registered', function($manager) {
    $manager->add_category('cardifa-elements', [
        'title' => 'ویجت‌های کاردیفا',
        'icon'  => 'fa fa-puzzle-piece',
    ]);
});

// 🧩 بارگذاری و ثبت ویجت‌ها
add_action('elementor/widgets/register', function($widgets_manager) {
    // ✅ ویجت "کپی لینک"
    require_once CARDIFA_BIO_PATH . 'widgets/class-cardifa-copy-link.php';
    $widgets_manager->register(new \Elementor\Cardifa_Copy_Link_Widget());
    
    // ✅ ویجت "عنوان پیشرفته"
    require_once CARDIFA_BIO_PATH . 'widgets/class-cardifa-advanced-heading.php';
    error_log('✅ ویجت Advanced Heading لود شد!');
    $widgets_manager->register(new \Elementor\Cardifa_Advanced_Heading());
    





    // 🔜 اینجا ویجت‌های بعدی اضافه میشن
});
