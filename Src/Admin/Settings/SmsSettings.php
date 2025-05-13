<?php
/**
 * File: Sms_Settings.php
 * Description: تنظیمات پیامکی کاردیفا با هماهنگی کامل با طرح فیگما
 *
 * Since:     1.0.1
 * Author:    Kiya Holding
 */

namespace Cardifa\Admin\Settings;

defined('ABSPATH') || exit;

class SmsSettings
{
    /**
     * ثبت تنظیمات و سِکشِن تب «پیامکی»
     */
    public static function register(): void
    {
        register_setting('cardifa_settings_sms', 'cardifa_sms_options');
        add_settings_section(
            'sms_section',
            __('تنظیمات پیامکی', 'cardifa'),
            '__return_null',
            'cardifa_settings_sms'
        );
    }

    /**
     * رندر کامل پنل «تنظیمات پیامکی»
     */
    public static function render_panel(): void
    {
        $opts = get_option('cardifa_sms_options', []);
        ?>

        <div class="cardifa-panel">
            <!-- هدر بالا -->
            <div class="cardifa-header">
                <h1><?php esc_html_e('تنظیمات کاردیفا', 'cardifa'); ?></h1>
                <p><?php esc_html_e('به پنل مدیریتی کاردیفا خوش‌آمدید', 'cardifa'); ?></p>
                <div class="header-actions">
                    <span id="current-date"><?php echo esc_html(date_i18n('l d/m/Y H:i:s')); ?></span>
                    <button class="button-primary"><?php esc_html_e('ذخیره تنظیمات', 'cardifa'); ?></button>
                </div>
            </div>

            <!-- وضعیت اتصال به سامانه -->
            <div class="cardifa-card">
                <h3><?php esc_html_e('وضعیت اتصال به سامانه', 'cardifa'); ?></h3>
                <div id="sms-status">
                    <span id="sms-conn-status" class="cardifa-status-dot"></span>
                    <span id="sms-conn-text"><?php esc_html_e('در حال بررسی…', 'cardifa'); ?></span>
                    <strong id="sms-credit">—</strong>
                    <small><?php esc_html_e('اعتبار پیامک', 'cardifa'); ?></small>
                </div>
                <button class="button-primary" id="sms-test-button"><?php esc_html_e('ارسال پیامک تست', 'cardifa'); ?></button>
            </div>

            <!-- تنظیمات سامانه پیامکی -->
            <div class="cardifa-card">
                <h3><?php esc_html_e('اطلاعات اتصال به سامانه', 'cardifa'); ?></h3>
                <div class="cardifa-fields two-column">
                    <!-- نام کاربری -->
                    <div class="cardifa-field">
                        <label for="sms_username"><?php esc_html_e('نام کاربری', 'cardifa'); ?></label>
                        <input type="text" id="sms_username" name="cardifa_sms_options[username]" value="<?php echo esc_attr($opts['username'] ?? ''); ?>" />
                    </div>

                    <!-- رمز عبور -->
                    <div class="cardifa-field">
                        <label for="sms_password"><?php esc_html_e('رمز عبور', 'cardifa'); ?></label>
                        <input type="password" id="sms_password" name="cardifa_sms_options[password]" value="<?php echo esc_attr($opts['password'] ?? ''); ?>" />
                    </div>

                    <!-- آی‌پی سامانه -->
                    <div class="cardifa-field">
                        <label for="sms_ip"><?php esc_html_e('آی‌پی سامانه', 'cardifa'); ?></label>
                        <input type="text" id="sms_ip" name="cardifa_sms_options[ip_address]" value="<?php echo esc_attr($opts['ip_address'] ?? ''); ?>" />
                    </div>

                    <!-- شماره خط خدماتی -->
                    <div class="cardifa-field">
                        <label for="sms_line_number"><?php esc_html_e('شماره خط خدماتی', 'cardifa'); ?></label>
                        <input type="text" id="sms_line_number" name="cardifa_sms_options[line_number]" value="<?php echo esc_attr($opts['line_number'] ?? ''); ?>" placeholder="<?php esc_attr_e('مثلاً 1000XXXXXXX', 'cardifa'); ?>" />
                        <small><?php esc_html_e('شماره خط خدماتی که پیامک با آن ارسال می‌شود', 'cardifa'); ?></small>
                    </div>
                </div>
            </div>

            <!-- پیامک‌های رویدادی -->
            <div class="cardifa-card">
                <h3><?php esc_html_e('پیامک‌های رویدادی', 'cardifa'); ?></h3>
                <div class="cardifa-fields three-column">
                    <?php
                    $triggers = [
                        'register' => __('کد {OTP} ثبت نام', 'cardifa'),
                        'confirm_register' => __('تأیید ثبت نام', 'cardifa'),
                        'login_code' => __('کد ورود', 'cardifa'),
                        'expiry_alert' => __('یادآوری پایان اشتراک', 'cardifa'),
                    ];
                    foreach ($triggers as $key => $label) : ?>
                        <div class="cardifa-field">
                            <label>
                                <input type="checkbox" name="cardifa_sms_options[triggers][<?php echo esc_attr($key); ?>][enabled]" value="1" <?php checked($opts['triggers'][$key]['enabled'] ?? false, true); ?>>
                                <?php echo esc_html($label); ?>
                            </label>
                            <textarea name="cardifa_sms_options[triggers][<?php echo esc_attr($key); ?>][message]" rows="2" placeholder="<?php esc_attr_e('متن پیامک', 'cardifa'); ?>"><?php echo esc_textarea($opts['triggers'][$key]['message'] ?? ''); ?></textarea>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- شورت‌کدها -->
            <div class="cardifa-card">
                <h3><?php esc_html_e('لیست کدهای کوتاه', 'cardifa'); ?></h3>
                <ul class="shortcodes">
                    <li><code>{otp}</code>: <?php esc_html_e('کد یک‌بار مصرف', 'cardifa'); ?></li>
                    <li><code>{expiry}</code>: <?php esc_html_e('تاریخ انقضا', 'cardifa'); ?></li>
                    <li><code>{subscription_end}</code>: <?php esc_html_e('پایان اشتراک', 'cardifa'); ?></li>
                </ul>
            </div>
        </div>

        <?php
    }
}
