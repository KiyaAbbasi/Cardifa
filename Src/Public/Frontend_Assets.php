<?php
/**
 * File Name:       Frontend_Assets.php
 * Description:     مدیریت فایل‌های CSS و JS در بخش عمومی سایت
 * Since:           1.0.0
 * Last Modified:   2025-04-24 14:08:19
 * Author:          KiyaAbbasi
 * Author URI:      https://kiyaholding.com
 * License:         GPLv3 or later
 * License URI:     https://www.gnu.org/licenses/gpl-3.0.html
 * 
 * @package         Cardifa\Public
 */

namespace Cardifa\Public;

use Cardifa\Core\Services\AssetManager;

defined('ABSPATH') || exit;

/**
 * کلاس مدیریت asset های فرانت‌اند
 *
 * @since      1.0.0
 * @package    Cardifa\Public
 * @author     KiyaAbbasi
 */
class Frontend_Assets {
    /**
     * @var AssetManager نمونه کلاس مدیریت asset ها
     */
    private $asset_manager;

    /**
     * سازنده کلاس
     *
     * @param AssetManager $asset_manager نمونه کلاس مدیریت asset ها
     * @since 1.0.0
     */
    public function __construct(AssetManager $asset_manager) {
        $this->asset_manager = $asset_manager;
        add_action('wp_enqueue_scripts', [$this, 'enqueue_styles']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
    }

    /**
     * لود کردن استایل‌های عمومی
     *
     * @since 1.0.0
     */
    public function enqueue_styles() {
        wp_enqueue_style(
            'cardifa-public',
            CARDIFA_URL . 'assets/public/css/public.css',
            [],
            CARDIFA_VERSION
        );

        // استایل‌های اختصاصی کارت‌ها
        wp_enqueue_style(
            'cardifa-cards',
            CARDIFA_URL . 'assets/public/css/cards.css',
            ['cardifa-public'],
            CARDIFA_VERSION
        );
    }

    /**
     * لود کردن اسکریپت‌های عمومی
     *
     * @since 1.0.0
     */
    public function enqueue_scripts() {
        wp_enqueue_script(
            'cardifa-public',
            CARDIFA_URL . 'assets/public/js/public.js',
            ['jquery'],
            CARDIFA_VERSION,
            true
        );

        // اسکریپت‌های اختصاصی کارت‌ها
        wp_enqueue_script(
            'cardifa-cards',
            CARDIFA_URL . 'assets/public/js/cards.js',
            ['jquery', 'cardifa-public'],
            CARDIFA_VERSION,
            true
        );

        // لوکالایز اسکریپت
        wp_localize_script('cardifa-public', 'cardifaPublic', [
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce'   => wp_create_nonce('cardifa-public'),
        ]);
    }
}
