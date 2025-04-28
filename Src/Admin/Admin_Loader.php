<?php
/**
 * File Name: Admin_Loader.php
 * Description: لودر تمام کلاس‌های ادمین کاردیفا
 * Since: 1.0.0
 * Author: Kiya Holding
 */

namespace Cardifa\Src\Admin;

defined('ABSPATH') || exit;

class Admin_Loader
{
    public function __construct()
    {
        $this->load_dependencies();
        $this->initialize_classes();
    }

    private function load_dependencies()
    {
        require_once CARDIFA_PATH . 'Src/Admin/Class-Admin-Menu.php';
        require_once CARDIFA_PATH . 'Src/Admin/Class-Settings.php';
    }

    private function initialize_classes()
    {
        new \Cardifa\Src\Admin\Class_Admin_Menu();
        // Class_Settings چون static هست نیازی به new نداره
    }
}
