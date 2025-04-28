<?php
/**
 * File Name:    Admin_Loader.php
 * Description:  لودر تمام کلاس‌های ادمین کاردیفا
 * Since:        1.0.0
 * Author:       Kiya Holding
 */

namespace Cardifa\Admin;

defined('ABSPATH') || exit;

class Admin_Loader
{
    /**
     * Admin_Loader constructor.
     *
     * @since 1.0.0
     */
    public function __construct()
    {
        $this->load_dependencies();
        $this->initialize_classes();
    }

    /**
     * بارگذاری فایل‌های مورد نیاز ادمین
     *
     * @since 1.0.0
     */
    private function load_dependencies(): void
    {
        require_once CARDIFA_PATH . 'Src/Admin/Class-Admin-Menu.php';
        require_once CARDIFA_PATH . 'Src/Admin/Class-Settings.php';
    }

    /**
     * نمونه‌سازی کلاس‌های ادمین
     *
     * @since 1.0.0
     */
    private function initialize_classes(): void
    {
        new Class_Admin_Menu();    // منوی اصلی و اسکریپت/استایل ادمین
        // Class_Settings چون static هست، نیازی به new نداره
    }
}
