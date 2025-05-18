<?php
/**
 * File Name:       Public_Bootstrap.php
 * Description:     مدیریت راه‌اندازی و پیکربندی بخش عمومی سایت کاردیفا
 * Since:           1.0.0
 * Last Modified:   2025-04-26
 * Author:          Kiya Holding
 * Author URI:      https://kiyaholding.com
 * License:         GPLv3 or later
 * License URI:     https://www.gnu.org/licenses/gpl-3.0.html
 * 
 * @package         Cardifa\Bootstrap
 */

namespace Cardifa\Bootstrap; // ← اصلاح شد

use Cardifa\Services\AssetManager;   // ← namespace صحیح

defined('ABSPATH') || exit;

class Public_Bootstrap
{
    /**
     * ثبت هوک‌های عمومی
     *
     * @since 1.0.0
     */
    public static function register(): void
    {
        add_action('wp_enqueue_scripts', [__CLASS__, 'enqueue_assets']);
        add_shortcode('cardifa_profile', [__CLASS__, 'render_profile_shortcode']);
    }

    /**
     * enqueue استایل و اسکریپت عمومی
     *
     * @since 1.0.0
     */
    public static function enqueue_assets(): void
    {
        $am = new AssetManager();
        $am->load_assets('public');
    }

    /**
     * رندر شورتکد پروفایل
     *
     * @param array $atts
     * @return string
     * @since 1.0.0
     */
    public static function render_profile_shortcode(array $atts): string
    {
        ob_start();
        require CARDIFA_PATH . 'Templates/Public/Card-Template.php';
        return ob_get_clean();
    }
}
