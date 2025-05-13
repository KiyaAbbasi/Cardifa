<?php
/**
 * File Name:       AssetManager.php
 * Description:     مدیریت تمام asset های پلاگین (CSS, JS, Fonts)
 * Since:           1.0.0
 * Last Modified:   2025-04-24 14:02
 * Author:          Kiya Holding
 * Author URI:      https://kiyaholding.com
 * License:         GPLv3 or later
 * License URI:     https://www.gnu.org/licenses/gpl-3.0.html
 * 
 * @package         Cardifa\Services
 */

namespace Cardifa\Services;

defined('ABSPATH') || exit;

class AssetManager
{
    /**
     * بارگذاری و enqueue assetها
     *
     * @param string $context ('admin' یا 'public')
     * @since 1.0.0
     */
    public function load_assets(string $context = 'public'): void
    {
        if ($context === 'admin') {
            wp_enqueue_style('cardifa-admin', CARDIFA_URL . 'Assets/Admin/Css/Admin.css', [], CARDIFA_VERSION);
            wp_enqueue_script('cardifa-admin-settings', CARDIFA_URL . 'Assets/Admin/Js/Settings.js', ['jquery'], CARDIFA_VERSION, true);
        } else {
            wp_enqueue_style('cardifa-public', CARDIFA_URL . 'Assets/Public/Css/Public-Style.css', [], CARDIFA_VERSION);
            wp_enqueue_script('cardifa-public', CARDIFA_URL . 'Assets/Public/Js/Public-Script.js', [], CARDIFA_VERSION, true);
        }
    }
}
