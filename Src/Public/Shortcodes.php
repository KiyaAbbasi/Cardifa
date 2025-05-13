<?php
/**
 * File Name:       Shortcodes.php
 * Description:     مدیریت شورت‌کدهای افزونه کاردیفا
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

defined('ABSPATH') || exit;

/**
 * کلاس مدیریت شورت‌کدها
 *
 * @since      1.0.0
 * @package    Cardifa\Public
 * @author     KiyaAbbasi
 */
class Shortcodes {
    /**
     * سازنده کلاس
     * ثبت شورت‌کدها
     *
     * @since 1.0.0
     */
    public function __construct() {
        add_shortcode('cardifa_card', [$this, 'render_card']);
        add_shortcode('cardifa_profile', [$this, 'render_profile']);
        add_shortcode('cardifa_list', [$this, 'render_cards_list']);
    }

    /**
     * رندر کارت ویزیت
     *
     * @param array  $atts    پارامترهای شورت‌کد
     * @param string $content محتوای بین تگ‌های شورت‌کد
     * @return string
     * @since 1.0.0
     */
    public function render_card($atts, $content = null) {
        $atts = shortcode_atts([
            'id'     => 0,
            'style'  => 'default',
            'class'  => '',
        ], $atts);

        ob_start();
        include CARDIFA_DIR . 'templates/card.php';
        return ob_get_clean();
    }

    /**
     * رندر پروفایل کاربر
     *
     * @param array  $atts    پارامترهای شورت‌کد
     * @param string $content محتوای بین تگ‌های شورت‌کد
     * @return string
     * @since 1.0.0
     */
    public function render_profile($atts, $content = null) {
        $atts = shortcode_atts([
            'user_id' => get_current_user_id(),
            'style'   => 'default',
            'class'   => '',
        ], $atts);

        ob_start();
        include CARDIFA_DIR . 'templates/profile.php';
        return ob_get_clean();
    }

    /**
     * رندر لیست کارت‌ها
     *
     * @param array  $atts    پارامترهای شورت‌کد
     * @param string $content محتوای بین تگ‌های شورت‌کد
     * @return string
     * @since 1.0.0
     */
    public function render_cards_list($atts, $content = null) {
        $atts = shortcode_atts([
            'count'     => 10,
            'category' => '',
            'style'    => 'grid',
            'columns'  => 3,
            'class'    => '',
        ], $atts);

        ob_start();
        include CARDIFA_DIR . 'templates/cards-list.php';
        return ob_get_clean();
    }
}
