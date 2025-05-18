<?php
/**
 * File: Class-Admin-Menu.php
 * Description:
 *   یک‌بار برای همیشه منوی «کاردیفا» + زیرمنوها را ثبت می‌کند،
 *   زیرمنوی خودِ «کاردیفا» را حذف می‌کند
 *   و ترتیب منوهای اصلی وردپرس را تضمین می‌کند.
 * Since: 1.0.0
 */

namespace Cardifa\Admin;

defined('ABSPATH') || exit;

class Class_Admin_Menu
{
    /** 
     * محافظ برای اینکه منو و زیرمنوها فقط یک‌بار ساخته شوند 
     * @var bool
     */
    private static $has_added = false;

    public function __construct()
    {
        // اول منوهای قدیمی پاک شوند
        add_action('admin_menu', [ $this, 'cleanup_old' ], 5);

        // بعد منو/زیرمنوها یک‌بار ثبت شوند
        add_action('admin_menu', [ $this, 'add_complete_menu' ], 10);

        // سپس اگر هنوز زیرمنوی تکراری هست پاکش کنیم
        add_action('admin_menu', [ $this, 'cleanup_submenus' ], 11);

        // enqueue استایل/اسکریپت
        add_action('admin_enqueue_scripts', [ $this, 'enqueue_assets' ], 20);

        // و در نهایت ترتیب منوهای اصلی وردپرس را تنظیم کنیم
        add_action('admin_menu', [ $this, 'reorder_main_menu' ], 999);
    }

    /**
     * ۱) پاکسازی هر منوی قدیمی یا خودکار «کاردیفا»
     */
    public function cleanup_old(): void
    {
        remove_menu_page('cardifa');
        remove_menu_page('edit.php?post_type=cardifa');
        remove_menu_page('post-new.php?post_type=cardifa');
    }

    /**
     * ۲) ثبت کامل منوی اصلی و زیرمنوها (فقط یک‌بار)
     */
    public function add_complete_menu(): void
    {
        if ( self::$has_added ) {
            return;
        }
        self::$has_added = true;

        // ─── منوی اصلی ────────────────────
        add_menu_page(
            __('کاردیفا','cardifa'),
            __('کاردیفا','cardifa'),
            'manage_options',
            'cardifa',
            '__return_null',
            'dashicons-id-alt',
            26
        );

        // ─── زیرمنوها ─────────────────────
        add_submenu_page(
            'cardifa',
            __('لیست کاردیفا‌ها','cardifa'),
            __('لیست کاردیفا‌ها','cardifa'),
            'manage_options',
            'edit.php?post_type=cardifa'
        );
        add_submenu_page(
            'cardifa',
            __('افزودن کاردیفا','cardifa'),
            __('افزودن کاردیفا','cardifa'),
            'manage_options',
            'post-new.php?post_type=cardifa'
        );
        add_submenu_page(
            'cardifa',
            __('دیدگاه‌های کاردیفا‌ها','cardifa'),
            __('دیدگاه‌های کاردیفا‌ها','cardifa'),
            'manage_options',
            'edit-comments.php?post_type=cardifa'
        );
    }

    /**
     * ۳) حذف هر زیرمنوی تکراری «کاردیفا»
     */
    public function cleanup_submenus(): void
    {
        global $submenu;
        if ( ! isset( $submenu['cardifa'] ) ) {
            return;
        }
        foreach ( $submenu['cardifa'] as $idx => $item ) {
            // آیتمی که slug آن دقیقا برابر slug منوی اصلی است
            if ( isset( $item[2] ) && $item[2] === 'cardifa' ) {
                unset( $submenu['cardifa'][ $idx ] );
            }
        }
        // ری‌اندکس
        $submenu['cardifa'] = array_values( $submenu['cardifa'] );
    }

    /**
     * ۴) enqueue استایل و اسکریپت پنل ادمین
     */
    public function enqueue_assets(): void
    {
        wp_enqueue_style(
            'cardifa-admin',
            CARDIFA_URL . 'Assets/Admin/Css/Admin.css',
            [],
            CARDIFA_VERSION
        );
        wp_enqueue_script(
            'cardifa-admin-settings',
            CARDIFA_URL . 'Assets/Admin/Js/Settings.js',
            ['jquery'],
            CARDIFA_VERSION,
            true
        );
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_script( 'wp-color-picker' );

    }

    /**
     * ۵) مرتب‌سازی منوهای اصلی وردپرس به ترتیب دلخواه
     */

    public function reorder_main_menu(): void
    {
        global $menu;
    
        // ترتیب دقیق مورد نظر شما
        $desired = [
            'index.php',                // پیشخوان
            'upload.php',               // رسانه‌ها
            'edit.php?post_type=page',  // برگه‌ها
            'edit.php',                 // نوشته‌ها
            'edit-comments.php',        // دیدگاه‌ها
            'cardifa',                  // کاردیفا
        ];
    
        $sorted    = [];
        $remaining = $menu;
    
        // مرتب‌سازی آیتم‌های منو
        foreach ($desired as $slug) {
            foreach ($remaining as $key => $item) {
                if (isset($item[2]) && strpos($item[2], $slug) !== false) {
                    $sorted[] = $item;
                    unset($remaining[$key]);
                    break;
                }
            }
        }
    
        // اضافه کردن باقی‌مانده منوها
        foreach ($remaining as $item) {
            $sorted[] = $item;
        }
    
        // جایگزینی منوی اصلی
        $menu = $sorted;
    }

}
