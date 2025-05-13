<?php
/**
 * File: SMSSettings.php
 * Description: تنظیمات سامانه پیامکی مطابق با طرح فیگما
 * Author: Kiya Holding
 * Version: 2.0.0
 */

namespace Cardifa\Admin\Settings;

use Cardifa\Admin\SMS\SMSHandler;
use Cardifa\Admin\SMS\ShortcodeHandler;

class SmsSettings
{
    /**
     * Initialize the SMS settings page.
     */
    public static function init(): void
    {
        add_action('admin_menu', [__CLASS__, 'addMenu']);
        add_action('admin_init', [__CLASS__, 'registerSettings']);
    }

    /**
     * Add SMS settings to the WordPress admin menu.
     */
    public static function addMenu(): void
    {
        add_menu_page(
            __('تنظیمات پیامکی', 'cardifa'),
            __('پیامک', 'cardifa'),
            'manage_options',
            'sms-settings',
            [__CLASS__, 'renderSettingsPage'],
            'dashicons-email',
            25
        );
    }

    /**
     * Register SMS settings.
     */
    public static function registerSettings(): void
    {
        register_setting('sms_settings_group', 'sms_connection_status');
        register_setting('sms_settings_group', 'sms_pattern_code');
        register_setting('sms_settings_group', 'sms_event_messages');
        register_setting('sms_settings_group', 'sms_shortcodes');
    }

    /**
     * Render the SMS settings page.
     */
    public static function renderSettingsPage(): void
    {
        // Load current settings from the database
        $connectionStatus = get_option('sms_connection_status', 'not_connected');
        $patternCode = get_option('sms_pattern_code', '');
        $eventMessages = get_option('sms_event_messages', []);
        $shortcodes = get_option('sms_shortcodes', ['{Name}', '{OPT}', '{Expire}']);

        ?>
        <div class="wrap">
            <h1><?php _e('تنظیمات سامانه پیامکی', 'cardifa'); ?></h1>
            
            <form method="post" action="options.php">
                <?php
                settings_fields('sms_settings_group');
                do_settings_sections('sms-settings');
                ?>

                <h2><?php _e('اطلاعات سامانه پیامکی', 'cardifa'); ?></h2>
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row"><?php _e('وضعیت اتصال:', 'cardifa'); ?></th>
                        <td>
                            <select name="sms_connection_status">
                                <option value="connected" <?php selected($connectionStatus, 'connected'); ?>><?php _e('متصل', 'cardifa'); ?></option>
                                <option value="not_connected" <?php selected($connectionStatus, 'not_connected'); ?>><?php _e('قطع اتصال', 'cardifa'); ?></option>
                            </select>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php _e('کد پترن:', 'cardifa'); ?></th>
                        <td>
                            <input type="text" name="sms_pattern_code" value="<?php echo esc_attr($patternCode); ?>" />
                        </td>
                    </tr>
                </table>

                <h2><?php _e('پیامک‌های رویدادی', 'cardifa'); ?></h2>
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row"><?php _e('متن پیامک ثبت‌نام کاربر:', 'cardifa'); ?></th>
                        <td>
                            <textarea name="sms_event_messages[register]"><?php echo esc_textarea($eventMessages['register'] ?? ''); ?></textarea>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php _e('متن پیامک تایید پرداخت:', 'cardifa'); ?></th>
                        <td>
                            <textarea name="sms_event_messages[payment]"><?php echo esc_textarea($eventMessages['payment'] ?? ''); ?></textarea>
                        </td>
                    </tr>
                </table>

                <h2><?php _e('کدهای کوتاه', 'cardifa'); ?></h2>
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row"><?php _e('لیست کدهای کوتاه:', 'cardifa'); ?></th>
                        <td>
                            <ul>
                                <?php foreach ($shortcodes as $shortcode): ?>
                                    <li><?php echo esc_html($shortcode); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </td>
                    </tr>
                </table>

                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }
}

SMSSettings::init();
