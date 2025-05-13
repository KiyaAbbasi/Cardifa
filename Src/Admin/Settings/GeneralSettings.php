<?php
/**
 * File: General_Settings.php
 * Description: تنظیمات عمومی کاردیفا
 *   – پیشوند URL کارت
 *   – فعال/غیرفعال‌سازی کاردیفا
 *   – رنگ تم اصلی
 *   – نمایش آمار بازدید
 *
 * Since:     1.0.0
 * Author:    Kiya Holding
 */

namespace Cardifa\Admin\Settings;

defined('ABSPATH') || exit;

class GeneralSettings
{
    /**
     * ثبت Settingها و Section تب «عمومی»
     */
    public static function register(): void
    {
        register_setting( 'cardifa_settings_general', 'cardifa_general_options' );
        add_settings_section(
            'general_section',
            __( 'تنظیمات عمومی', 'cardifa' ),
            '__return_null',
            'cardifa_settings_general'
        );
    }

    /**
     * رندر پنل «عمومی»
     */
    public static function render_panel(): void
    {
        $opts = get_option( 'cardifa_general_options', [] );

        echo '<div class="cardifa-card">';
            echo '<h3>' . esc_html__( 'تنظیمات عمومی', 'cardifa' ) . '</h3>';
            echo '<div class="cardifa-fields two-column">';
                // پیشوند URL کارت
                echo '<div class="cardifa-field">';
                    echo '<label for="general_default_slug">' . esc_html__( 'پیشوند URL کارت', 'cardifa' ) . '</label>';
                    printf(
                        '<input type="text" id="general_default_slug" name="cardifa_general_options[default_slug]" value="%s" placeholder="مثلاً card" />',
                        esc_attr( $opts['default_slug'] ?? '' )
                    );
                echo '</div>';

                // فعال/غیرفعال‌سازی کاردیفا
                echo '<div class="cardifa-field">';
                    echo '<label for="general_enable_cardifa">';
                    printf(
                        '<input type="checkbox" id="general_enable_cardifa" name="cardifa_general_options[enable_cardifa]" value="1" %s /> %s',
                        checked( ! empty( $opts['enable_cardifa'] ), true, false ),
                        esc_html__( 'فعال‌سازی کاردیفا', 'cardifa' )
                    );
                    echo '</label>';
                echo '</div>';

                // رنگ تم اصلی
                echo '<div class="cardifa-field">';
                    echo '<label for="general_main_color">' . esc_html__( 'رنگ تم اصلی', 'cardifa' ) . '</label>';
                    printf(
                        '<input type="text" id="general_main_color" name="cardifa_general_options[main_color]" value="%s" class="cardifa-color-field" />',
                        esc_attr( $opts['main_color'] ?? '#0275d8' )
                    );
                echo '</div>';

                // نمایش آمار بازدید
                echo '<div class="cardifa-field">';
                    echo '<label for="general_enable_analytics">';
                    printf(
                        '<input type="checkbox" id="general_enable_analytics" name="cardifa_general_options[enable_analytics]" value="1" %s /> %s',
                        checked( ! empty( $opts['enable_analytics'] ), true, false ),
                        esc_html__( 'نمایش آمار بازدید', 'cardifa' )
                    );
                    echo '</label>';
                echo '</div>';
            echo '</div>';
        echo '</div>';
    }
}
