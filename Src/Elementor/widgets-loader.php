<?php
/**
 * File Name:       widgets-loader.php
 * Description:     مدیریت هوشمند ویجت‌های المنتور با جابجایی و حذف دسته‌بندی‌ها
 * Since:           1.0.0
 * Last Modified:   2025-04-24 15:50:37
 * Author:          Kiya Holding
 * Author URI:      https://kiyaholding.com
 * License:         GPLv3 or later
 * License URI:     https://www.gnu.org/licenses/gpl-3.0.html
 * 
 * @package         Cardifa\Elementor
 */

defined('ABSPATH') || exit;

use Elementor\Plugin;

// ─── لود کردن فایل‌های Core ───
require_once CARDIFA_PATH . 'Src/Elementor/Core/Icons.php';
require_once CARDIFA_PATH . 'Src/Elementor/Core/Assets.php';
require_once CARDIFA_PATH . 'Src/Elementor/Core/Utilities.php';

/**
 * لود کردن داینامیک trait ها
 *
 * @param string $trait_name نام trait
 * @return void
 */
function cardifa_autoload_trait($trait_name) {
    $traits_dir = CARDIFA_PATH . 'src/Elementor/Traits/';
    $trait_file = $traits_dir . $trait_name . '.php';
    
    if (file_exists($trait_file)) {
        require_once $trait_file;
    }
}

// ─── بارگذاری داینامیک Trait ها ───
spl_autoload_register(function($class) {
    // فقط trait های مربوط به Cardifa\Elementor\Traits
    if (strpos($class, 'Cardifa\\Elementor\\Traits\\') === 0) {
        $trait_name = str_replace('Cardifa\\Elementor\\Traits\\', '', $class);
        cardifa_autoload_trait($trait_name);
    }
});

// ─── راه‌اندازی کلاس‌های اصلی ───
$icons = new \Cardifa\Elementor\Core\Icons();
$assets = new \Cardifa\Elementor\Core\Assets();
$utilities = new \Cardifa\Elementor\Core\Utilities();

// 1. ثبت دسته‌بندی‌ها
add_action('elementor/elements/categories_registered', function($elements_manager) {
    // حذف همه دسته‌بندی‌های موجود
    $old_categories = $elements_manager->get_categories();
    
    // ایجاد دسته‌بندی‌های جدید
    $new_categories = [
        'layout' => [
            'title' => __('لایوت', 'cardifa'),
            'icon'  => 'eicon-layout',
        ],
        'cardifa' => [
            'title' => __('کاردیفا', 'cardifa'),
            'icon'  => 'eicon-cardifa-icon',
        ]
    ];

    // اضافه کردن دسته‌بندی‌های جدید
    foreach ($new_categories as $key => $category) {
        $elements_manager->add_category($key, $category);
    }
}, 1, 1);

// 2. بارگذاری خودکار ویجت‌ها
add_action('elementor/widgets/register', function($widgets_manager) {
    $widgets_dir = CARDIFA_PATH . 'Src/Elementor/Widgets/';
    
    if (is_dir($widgets_dir)) {
        foreach (glob($widgets_dir . '*.php') as $file) {
            try {
                require_once $file;
                $widget_name = basename($file, '.php');
                $class_name = '\\Cardifa\\Elementor\\Widgets\\' . $widget_name;
                
                if (class_exists($class_name)) {
                    $widgets_manager->register(new $class_name());
                }
            } catch (Exception $e) {
                error_log('Cardifa Elementor Widget Error: ' . $e->getMessage());
                continue;
            }
        }
    }
}, 20);

// 3. فیلتر ویجت‌های غیرمجاز
add_action('elementor/widgets/register', function($widgets_manager) {
    if (wp_doing_ajax() || is_admin()) {
        return;
    }

    $allowed_categories = ['cardifa', 'layout'];
    $widgets = $widgets_manager->get_widget_types();
    
    foreach ($widgets as $widget_id => $widget) {
        $categories = (array) $widget->get_categories();
        
        if (empty(array_intersect($categories, $allowed_categories))) {
            $widgets_manager->unregister($widget_id);
        }
    }
}, 999999);

// 4. حذف پیشرفته ویجت‌های غیرمجاز
add_action('elementor/widgets/register', function($widgets_manager) {
    if (wp_doing_ajax() || is_admin()) {
        return;
    }

    $allowed_categories = ['cardifa', 'layout']; // فقط دسته‌بندی‌های مجاز
    $widgets = $widgets_manager->get_widget_types();
    
    foreach ($widgets as $widget_id => $widget) {
        $categories = (array) $widget->get_categories();

        // اگر دسته‌بندی ویجت در لیست مجاز نبود، حذف کن
        if (empty(array_intersect($categories, $allowed_categories))) {
            $widgets_manager->unregister($widget_id);
        }
    }
}, 999999);
