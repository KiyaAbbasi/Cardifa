<?php
/**
 * File: Plans_Settings.php
 * Description: مدیریت پلن‌های اشتراک کاردیفا
 *   – جدول داینامیک افزودن/حذف پلن
 *
 * Since:     1.0.0
 * Author:    Kiya Holding
 */

namespace Cardifa\Admin\Settings;

defined('ABSPATH') || exit;

class PlansSettings
{
    /**
     * ثبت Settingها و Section تب «پلن‌ها»
     */
    public static function register(): void
    {
        register_setting( 'cardifa_settings_plans', 'cardifa_plans_options' );
        add_settings_section(
            'plans_section',
            __( 'مدیریت پلن‌ها', 'cardifa' ),
            '__return_null',
            'cardifa_settings_plans'
        );
    }

    /**
     * رندر پنل «پلن‌ها»
     */
    public static function render_panel(): void
    {
        $plans = get_option( 'cardifa_plans_options', [] );

        echo '<div class="cardifa-card">';
            echo '<h3>' . esc_html__( 'پلن‌های اشتراک', 'cardifa' ) . '</h3>';
            echo '<table class="form-table"><tbody>';
                foreach ( $plans as $i => $plan ) {
                    echo '<tr>';
                    foreach ( [ 'name','price','duration','discount','max_cards','free_sms','storage' ] as $field ) {
                        printf(
                            '<td><input name="cardifa_plans_options[%1$d][%2$s]" value="%3$s" placeholder="%4$s" /></td>',
                            esc_attr( $i ),
                            esc_attr( $field ),
                            esc_attr( $plan[ $field ] ?? '' ),
                            esc_attr( $field )
                        );
                    }
                    echo '<td><a href="#" class="remove-plan">' . esc_html__( 'حذف', 'cardifa' ) . '</a></td>';
                    echo '</tr>';
                }
            echo '</tbody></table>';
            echo '<p><a href="#" id="cardifa-add-plan" class="button">' . esc_html__( 'افزودن پلن جدید', 'cardifa' ) . '</a></p>';
        echo '</div>';
    }
}
