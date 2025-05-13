<?php
/**
 * File: GlobalAssets.php
 * Location: Src/Core/
 * Description: بارگذاری منابع عمومی (فونت‌ها و آیکون‌ها) برای همه بخش‌های افزونه
 *
 * @package Cardifa\Core
 */

namespace Cardifa\Core;

defined('ABSPATH') || exit;

class GlobalAssets
{
    public static function init()
    {
        // لود فونت‌ها در پنل ادمین، سایت، و المنتور
        add_action('admin_enqueue_scripts', [__CLASS__, 'enqueue_assets']);
        add_action('wp_enqueue_scripts', [__CLASS__, 'enqueue_assets']);
        add_action('elementor/editor/after_enqueue_styles', [__CLASS__, 'enqueue_assets']);
    }

    public static function enqueue_assets()
    {
        $base = plugin_dir_url(CARDIFA_FILE) . 'Assets/Fonts/';

        // فونت YekanBakh و تعریف @font-face
        wp_enqueue_style('cardifa-font-face', $base . 'Font-Face.css', [], CARDIFA_VERSION);

        // فونت آیکون Hi-Icone
        wp_enqueue_style('cardifa-hi-icons', $base . 'Hi-Icone/Css/fa-hi-icone.css', [], CARDIFA_VERSION);
    }
}