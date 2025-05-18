<?php
/**
 * File: Class-Settings.php
 * Description: صفحهٔ تنظیمات کاردیفا با طراحی مطابق طرح فیگما و ساختار بهینه‌شده
 * Since:       1.0.0
 * Author:      Kiya Holding
 */

namespace Cardifa\Admin;

defined('ABSPATH') || exit;

class Class_Settings
{
    public static function init(): void
    {
        add_action('admin_menu', [ __CLASS__, 'add_menu' ], 20);
        add_action('admin_init', [ __CLASS__, 'register_all' ]);
        add_action('admin_enqueue_scripts', [ __CLASS__, 'enqueue_assets' ]);
    }

    public static function add_menu(): void
    {
        add_submenu_page(
            'cardifa',
            __('تنظیمات کاردیفا','cardifa'),
            __('تنظیمات','cardifa'),
            'manage_options',
            'cardifa-settings',
            [ __CLASS__, 'render' ]
        );
    }

    public static function enqueue_assets(): void
    {
        wp_enqueue_style('cardifa-settings-style', CARDIFA_URL . 'Assets/Admin/Css/Cardifa-Settings.css', [], '1.0.0');
        wp_enqueue_script('cardifa-datetime', CARDIFA_URL . 'Assets/Admin/Js/Cardifa-Datetime.js', [], '1.0.0', true);
    }

    public static function register_all(): void
    {
        require_once CARDIFA_PATH . 'Src/Admin/Settings/GeneralSettings.php';
        require_once CARDIFA_PATH . 'Src/Admin/Settings/SmsSettings.php';
        require_once CARDIFA_PATH . 'Src/Admin/Settings/UsersSettings.php';
        require_once CARDIFA_PATH . 'Src/Admin/Settings/PlansSettings.php';
        require_once CARDIFA_PATH . 'Src/Helpers/DatetimeHelper.php';

        \Cardifa\Admin\Settings\GeneralSettings::register();
        \Cardifa\Admin\Settings\SmsSettings::register();
        \Cardifa\Admin\Settings\UsersSettings::register();
        \Cardifa\Admin\Settings\PlansSettings::register();
    }

    public static function render(): void
    {
        $tabs = [
            'dashboard'   => 'داشبورد',
            'sms'         => 'پیامک',
            'users'       => 'کاربران',
            'plans'       => 'پلن‌ها',
            'seo'         => 'سئو',
            'tickets'     => 'تیکت‌ها',
            'notices'     => 'اطلاعیه‌ها',
            'logout'      => 'خروج'
        ];

        $current = isset($_GET['tab']) && isset($tabs[$_GET['tab']]) ? $_GET['tab'] : 'dashboard';

        $current_user = wp_get_current_user();
        $user_name    = $current_user->display_name ?: $current_user->user_login;
        $user_role    = !empty($current_user->roles[0]) ? translate_user_role($current_user->roles[0]) : 'کاربر';
        $avatar_url   = get_avatar_url($current_user->ID);
        $panel_type   = current_user_can('manage_options') ? 'مدیریت' : 'کاربری';

        $date_text = function_exists('cardifa_get_shamsi_date_for_display')
            ? cardifa_get_shamsi_date_for_display()
            : date('Y/m/d');

        echo '<style>#wpfooter { display: none !important; } html { overflow-x: hidden !important; }</style>';

        echo '<div id="cardifa-settings-layout">';

        // ▓ ستون سمت راست - ۲۵٪
        echo '<aside id="cardifa-sidebar">';

            // باکس سبز رنگ بالایی
            echo '<div class="sidebar-top-bg">';
                echo '<div class="logo">';
                    echo '<img src="' . CARDIFA_URL . 'Assets/Admin/Img/Cardifa-Admin-Logo.svg" alt="Cardifa">';
                echo '</div>';
            echo '</div>';

            // باکس نیمه سوار پروفایل
            echo '<div class="cardifa-user-box">';
                echo '<img class="avatar" src="' . esc_url($avatar_url) . '" alt="User Avatar">';
                echo '<div class="meta">';
                    echo '<strong>' . esc_html($user_name) . '</strong>';
                    echo '<span>' . esc_html($user_role) . '</span>';
                echo '</div>';
            echo '</div>';

            // منوها
            echo '<nav class="cardifa-nav"><ul>';
            foreach ($tabs as $slug => $label) {
                $active = $slug === $current ? 'active' : '';
                echo '<li><a href="' . esc_url(admin_url("admin.php?page=cardifa-settings&tab={$slug}")) . '" class="' . $active . '">';
                echo '<i class="hi-icon hi-icon-' . esc_attr($slug) . '"></i> ';
                echo esc_html($label) . '</a></li>';
            }
            echo '</ul></nav>';

        echo '</aside>';

        // ▓ ستون اصلی سمت چپ - ۷۵٪
        echo '<main id="cardifa-main">';

            // هدر اصلی کاردیفا
            echo '<header id="cardifa-main-header">';
                echo '<div class="left">';
                    echo '<h1>پنل کاردیفا</h1>';
                    echo '<p>به پنل ' . esc_html($panel_type) . ' خوش آمدید</p>';
                echo '</div>';
                echo '<div class="right">';
                    echo '<i class="hi-icon hi-icon-bell"></i>';
                    echo '<span class="date-time">'
                        . esc_html($date_text)
                        . ' ساعت <span id="cardifa-live-clock">۰۰:۰۰:۰۰</span>'
                        . '</span>';
                    echo '<button id="save-settings-btn" class="primary-button">ذخیره تنظیمات</button>';
                echo '</div>';
            echo '</header>';

            // محتوای پویا
            echo '<section id="cardifa-main-content">';
                switch ($current) {
                    case 'sms':
                        \Cardifa\Admin\Settings\SmsSettings::render_panel();
                        break;
                    case 'users':
                        \Cardifa\Admin\Settings\UsersSettings::render_panel();
                        break;
                    case 'plans':
                        \Cardifa\Admin\Settings\PlansSettings::render_panel();
                        break;
                    default:
                        \Cardifa\Admin\Settings\GeneralSettings::render_panel();
                }
            echo '</section>';

        echo '</main>';

        echo '</div>'; // layout
    }
}

Class_Settings::init();