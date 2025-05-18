<?php
/**
 * File: Users_Settings.php
 * Description: تنظیمات کاربران کاردیفا
 *   – نقش پیش‌فرض کاربر کاردیفا
 *
 * Since:     1.0.0
 * Author:    Kiya Holding
 */

namespace Cardifa\Admin\Settings;

defined('ABSPATH') || exit;

class UsersSettings
{
    /**
     * ثبت Settingها و Section تب «کاربران»
     */
    public static function register(): void
    {
        register_setting( 'cardifa_settings_users', 'cardifa_users_options' );
        add_settings_section(
            'users_section',
            __( 'تنظیمات کاربران', 'cardifa' ),
            '__return_null',
            'cardifa_settings_users'
        );
    }

    /**
     * رندر پنل «کاربران»
     */
    public static function render_panel(): void
    {
        $opts  = get_option( 'cardifa_users_options', [] );
        $roles = get_editable_roles();

        echo '<div class="cardifa-card">';
            echo '<h3>' . esc_html__( 'تنظیمات کاربران', 'cardifa' ) . '</h3>';
            echo '<div class="cardifa-fields two-column">';
                echo '<div class="cardifa-field">';
                    echo '<label for="users_default_role">' . esc_html__( 'نقش پیش‌فرض کاربر کاردیفا', 'cardifa' ) . '</label>';
                    echo '<select id="users_default_role" name="cardifa_users_options[default_role]">';
                        foreach ( $roles as $role_key => $role_data ) {
                            printf(
                                '<option value="%1$s"%2$s>%3$s</option>',
                                esc_attr( $role_key ),
                                selected( $opts['default_role'] ?? 'subscriber', $role_key, false ),
                                esc_html( $role_data['name'] )
                            );
                        }
                    echo '</select>';
                echo '</div>';
            echo '</div>';
        echo '</div>';
    }
}
