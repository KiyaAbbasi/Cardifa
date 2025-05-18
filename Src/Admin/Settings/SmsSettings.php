<?php
/**
 * File: SmsSettings.php
 * Description: تنظیمات پیامکی کاردیفا
 */

namespace Cardifa\Admin\Settings;

defined('ABSPATH') || exit;

use Cardifa\Admin\Settings\SMS\SMSHandler;
use Cardifa\Admin\Settings\SMS\ShortcodeHandler;

class SmsSettings
{
    /**
     * ثبت تنظیمات صفحه پیامک
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
        
        add_action('admin_enqueue_scripts', [self::class, 'enqueue_assets']);
        add_action('wp_ajax_cardifa_test_sms_connection', [self::class, 'test_connection']);
        add_action('wp_ajax_cardifa_send_test_sms', [self::class, 'send_test_sms']);
        add_action('wp_ajax_cardifa_save_SmsSettings', [self::class, 'save_settings']);
    }
    
    /**
     * بارگذاری فایل‌های CSS و JS مورد نیاز
     */
    public static function enqueue_assets($hook): void
    {
        if (strpos($hook, 'cardifa-settings') === false) {
            return;
        }
        
        wp_enqueue_style(
            'cardifa-sms-settings', 
            CARDIFA_URL . 'Assets/Admin/Css/SMS-Settings.css', 
            [], 
            \CARDIFA_VERSION
        );

        wp_enqueue_script(
            'cardifa-sms-settings', 
            CARDIFA_URL . 'Assets/Admin/Js/SMS-Settings.js', 
            ['jquery'], 
            \CARDIFA_VERSION, 
            true
        );
        
        wp_localize_script('cardifa-sms-settings', 'cardifaSmsSettings', [
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('cardifa_SmsSettings'),
            'messages' => [
                'testSuccess' => __('پیامک تست با موفقیت ارسال شد.', 'cardifa'),
                'testError' => __('خطا در ارسال پیامک تست.', 'cardifa'),
                'connectionSuccess' => __('اتصال به سامانه پیامکی با موفقیت برقرار شد.', 'cardifa'),
                'connectionError' => __('خطا در اتصال به سامانه پیامکی.', 'cardifa'),
                'saveSuccess' => __('تنظیمات با موفقیت ذخیره شد.', 'cardifa'),
                'saveError' => __('خطا در ذخیره تنظیمات.', 'cardifa'),
            ]
        ]);
    }

    /**
     * تست اتصال به سامانه پیامکی
     */
    public static function test_connection(): void
    {
        check_ajax_referer('cardifa_SmsSettings', 'nonce');
        
        if (!current_user_can('manage_options')) {
            wp_send_json_error(__('شما دسترسی لازم برای این عملیات را ندارید.', 'cardifa'));
        }
        
        $service = sanitize_text_field($_POST['service'] ?? '');
        $api_key = sanitize_text_field($_POST['api_key'] ?? '');
        $username = sanitize_text_field($_POST['username'] ?? '');
        $password = sanitize_text_field($_POST['password'] ?? '');
        $line_number = sanitize_text_field($_POST['line_number'] ?? '');
        
        $sms_handler = new SMSHandler();
        $result = $sms_handler->test_connection($service, $api_key, $username, $password, $line_number);
        
        if ($result['success']) {
            wp_send_json_success($result['data']);
        } else {
            wp_send_json_error($result['message']);
        }
    }
    
    /**
     * ارسال پیامک تست
     */
    public static function send_test_sms(): void
    {
        check_ajax_referer('cardifa_SmsSettings', 'nonce');
        
        if (!current_user_can('manage_options')) {
            wp_send_json_error(__('شما دسترسی لازم برای این عملیات را ندارید.', 'cardifa'));
        }
        
        $service = sanitize_text_field($_POST['service'] ?? '');
        $api_key = sanitize_text_field($_POST['api_key'] ?? '');
        $username = sanitize_text_field($_POST['username'] ?? '');
        $password = sanitize_text_field($_POST['password'] ?? '');
        $line_number = sanitize_text_field($_POST['line_number'] ?? '');
        $mobile = sanitize_text_field($_POST['mobile'] ?? '');
        $message = sanitize_textarea_field($_POST['message'] ?? '');
        
        if (empty($mobile) || !preg_match('/^09[0-9]{9}$/', $mobile)) {
            wp_send_json_error(__('شماره موبایل وارد شده معتبر نیست.', 'cardifa'));
        }
        
        if (empty($message)) {
            wp_send_json_error(__('متن پیامک نمی‌تواند خالی باشد.', 'cardifa'));
        }
        
        $sms_handler = new SMSHandler();
        $result = $sms_handler->send_sms($service, $api_key, $username, $password, $line_number, $mobile, $message);
        
        if ($result['success']) {
            wp_send_json_success($result['data']);
        } else {
            wp_send_json_error($result['message']);
        }
    }
    
    /**
     * ذخیره تنظیمات
     */
    public static function save_settings(): void
    {
        check_ajax_referer('cardifa_SmsSettings', 'nonce');
        
        if (!current_user_can('manage_options')) {
            wp_send_json_error(__('شما دسترسی لازم برای این عملیات را ندارید.', 'cardifa'));
        }
        
        $options = [];
        parse_str($_POST['cardifa_sms_options'], $options);
        
        $sanitized_options = self::sanitize_options($options['cardifa_sms_options']);
        
        update_option('cardifa_sms_options', $sanitized_options);
        
        wp_send_json_success(__('تنظیمات با موفقیت ذخیره شد.', 'cardifa'));
    }
    
    /**
     * پاکسازی تنظیمات
     */
    private static function sanitize_options($options): array
    {
        $sanitized = [];
        
        // پاکسازی تنظیمات اصلی
        $sanitized['active'] = isset($options['active']) ? (bool) $options['active'] : false;
        $sanitized['service'] = sanitize_text_field($options['service'] ?? 'kavenegar');
        $sanitized['send_type'] = sanitize_text_field($options['send_type'] ?? 'pattern');
        $sanitized['api_key'] = sanitize_text_field($options['api_key'] ?? '');
        $sanitized['username'] = sanitize_text_field($options['username'] ?? '');
        $sanitized['password'] = sanitize_text_field($options['password'] ?? '');
        $sanitized['line_number'] = sanitize_text_field($options['line_number'] ?? '');
        
        // پاکسازی تنظیمات رویدادها
        if (isset($options['events']) && is_array($options['events'])) {
            foreach ($options['events'] as $event_key => $event) {
                $sanitized['events'][$event_key]['active'] = isset($event['active']) ? (bool) $event['active'] : false;
                $sanitized['events'][$event_key]['pattern_code'] = sanitize_text_field($event['pattern_code'] ?? '');
                $sanitized['events'][$event_key]['message'] = sanitize_textarea_field($event['message'] ?? '');
            }
        }
        
        return $sanitized;
    }

    /**
     * نمایش پنل تنظیمات پیامک
     */
    public static function render_panel(): void
    {
        $opts = get_option('cardifa_sms_options', []);

        // تنظیمات پیش‌فرض
        $default_settings = [
            'active' => false,
            'service' => 'kavenegar',
            'send_type' => 'pattern',
            'api_key' => '',
            'username' => '',
            'password' => '',
            'line_number' => '',
            'events' => [],
        ];

        // ادغام تنظیمات ذخیره شده با پیش‌فرض‌ها
        $settings = wp_parse_args($opts, $default_settings);

        // لیست سرویس‌های پیامکی
        $sms_services = [
            'kavenegar' => 'کاوه نگار',
            'melipayamak' => 'ملی پیامک',
            'farazsms' => 'فراز اس‌ام‌اس',
            'smsir' => 'پنل اس‌ام‌اس',
            'ghasedak' => 'قاصدک',
        ];
        
        // انواع ارسال پیامک
        $send_types = [
            'pattern' => 'ارسال با پترن',
            'service' => 'ارسال با خط خدماتی',
        ];
        
        // لیست رویدادهای پیامکی
        $events = [
            'login' => 'ورود کاربر',
            'register' => 'ثبت‌نام کاربر',
            'confirm_register' => 'تایید ثبت‌نام کاربر',
            'success_payment' => 'پرداخت موفق کاربر',
            'failed_payment' => 'پرداخت ناموفق کاربر',
            'no_payment' => 'عدم پرداخت از کارت کاربر',
            'renew_sub' => 'تمدید اشتراک موفق کاربر',
            'end_sub' => 'اتمام اشتراک کاربر',
            'remind_sub' => 'یادآوری پایان اشتراک کاربر'
        ];
        
        // لیست کدهای کوتاه
        $shortcodes = ShortcodeHandler::get_shortcodes();
        
        // متن‌های پیش‌فرض پیامک‌ها
        $default_messages = [
            'login' => 'کاربر گرامی {name} {family}، ورود شما به سایت با موفقیت انجام شد.',
            'register' => 'کاربر گرامی {name} {family}، ثبت‌نام شما با موفقیت انجام شد.',
            'confirm_register' => 'کاربر گرامی {name} {family}، کد تایید شما: {otp}',
            'success_payment' => 'کاربر گرامی {name} {family}، پرداخت شما به مبلغ {plan_price} با موفقیت انجام شد.',
            'failed_payment' => 'کاربر گرامی {name} {family}، پرداخت شما ناموفق بود.',
            'no_payment' => 'کاربر گرامی {name} {family}، پرداخت از کارت شما انجام نشد.',
            'renew_sub' => 'کاربر گرامی {name} {family}، اشتراک {plan_name} شما با موفقیت تمدید شد.',
            'end_sub' => 'کاربر گرامی {name} {family}، اشتراک {plan_name} شما به پایان رسیده است.',
            'remind_sub' => 'کاربر گرامی {name} {family}، تنها {days_left} روز تا پایان اشتراک {plan_name} شما باقی مانده است.'
        ];
        
        // بررسی وضعیت اتصال به سامانه پیامکی
        $connection_status = [
            'connected' => false,
            'credit' => 0
        ];
        
        if ($settings['active']) {
            $sms_handler = new SMSHandler();
            $connection_status = $sms_handler->check_connection_status(
                $settings['service'],
                $settings['api_key'],
                $settings['username'],
                $settings['password'],
                $settings['line_number']
            );
        }
        
        // ادغام متن‌های پیامک ذخیره شده با پیش‌فرض‌ها
        foreach ($events as $event_key => $event_name) {
            if (!isset($settings['events'][$event_key]['message'])) {
                $settings['events'][$event_key]['message'] = $default_messages[$event_key] ?? '';
            }
            if (!isset($settings['events'][$event_key]['pattern_code'])) {
                $settings['events'][$event_key]['pattern_code'] = '';
            }
            if (!isset($settings['events'][$event_key]['active'])) {
                $settings['events'][$event_key]['active'] = false;
            }
        }
        
        // نمایش فرم تنظیمات
        ?>
        <div class="container">
            <div class="card-header">
                <div class="card-icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <div class="card-title">
                    <span class="card-title-gray">سامانه</span>
                    <span class="card-title-regular">پیامکی</span>
                </div>
            </div>
            
            <form method="post" action="options.php" id="cardifa-sms-settings-form">
                <?php settings_fields('cardifa_settings_sms'); ?>
                
                <!-- سامانه پیامکی Card -->
                <div class="card">
                    <div class="card-content">
                        <div class="left-content">
                            <div class="form-container">
                                <div class="form-group">
                                    <div class="connection-title">وضعیت اتصال به سامانه</div>
                                    <label class="form-label required">انتخاب سامانه</label>
                                    <select class="form-input" name="cardifa_sms_options[service]" id="sms-service">
                                        <?php foreach ($sms_services as $key => $name) : ?>
                                            <option value="<?php echo esc_attr($key); ?>" <?php selected($settings['service'], $key); ?>><?php echo esc_html($name); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <div class="connection-title"><br></div>
                                    <label class="form-label">انتخاب نحوه ارسال</label>
                                    <select class="form-input" name="cardifa_sms_options[send_type]" id="send-type">
                                        <?php foreach ($send_types as $key => $name) : ?>
                                            <option value="<?php echo esc_attr($key); ?>" <?php selected($settings['send_type'], $key); ?>><?php echo esc_html($name); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                
                                <!-- فیلدهای مختص هر سرویس -->
                                <div class="service-fields" id="service-kavenegar" style="display: <?php echo $settings['service'] === 'kavenegar' ? 'block' : 'none'; ?>">
                                    <div class="form-group">
                                        <label class="form-label required">API سامانه</label>
                                        <input type="text" class="form-input" name="cardifa_sms_options[api_key]" value="<?php echo esc_attr($settings['api_key']); ?>" placeholder="کلید API خود را در سامانه پیامکی وارد نمایید">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label required">شماره خط سامانه</label>
                                        <input type="text" class="form-input" name="cardifa_sms_options[line_number]" value="<?php echo esc_attr($settings['line_number']); ?>" placeholder="شماره خط خود را در سامانه پیامکی وارد نمایید">
                                    </div>
                                </div>
                                
                                <div class="service-fields" id="service-melipayamak" style="display: <?php echo $settings['service'] === 'melipayamak' ? 'block' : 'none'; ?>">
                                    <div class="form-group">
                                        <label class="form-label required">نام کاربری</label>
                                        <input type="text" class="form-input" name="cardifa_sms_options[username]" value="<?php echo esc_attr($settings['username']); ?>" placeholder="نام کاربری خود را در سامانه پیامکی وارد نمایید">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label required">رمز عبور</label>
                                        <input type="password" class="form-input" name="cardifa_sms_options[password]" value="<?php echo esc_attr($settings['password']); ?>" placeholder="رمز عبور خود را در سامانه پیامکی وارد نمایید">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label required">شماره خط سامانه</label>
                                        <input type="text" class="form-input" name="cardifa_sms_options[line_number]" value="<?php echo esc_attr($settings['line_number']); ?>" placeholder="شماره خط خود را در سامانه پیامکی وارد نمایید">
                                    </div>
                                </div>
                                
                                <div class="service-fields" id="service-farazsms" style="display: <?php echo $settings['service'] === 'farazsms' ? 'block' : 'none'; ?>">
                                    <div class="form-group">
                                        <label class="form-label required">API سامانه</label>
                                        <input type="text" class="form-input" name="cardifa_sms_options[api_key]" value="<?php echo esc_attr($settings['api_key']); ?>" placeholder="کلید API خود را در سامانه پیامکی وارد نمایید">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label required">شماره خط سامانه</label>
                                        <input type="text" class="form-input" name="cardifa_sms_options[line_number]" value="<?php echo esc_attr($settings['line_number']); ?>" placeholder="شماره خط خود را در سامانه پیامکی وارد نمایید">
                                    </div>
                                </div>
                                
                                <div class="service-fields" id="service-smsir" style="display: <?php echo $settings['service'] === 'smsir' ? 'block' : 'none'; ?>">
                                    <div class="form-group">
                                        <label class="form-label required">API سامانه</label>
                                        <input type="text" class="form-input" name="cardifa_sms_options[api_key]" value="<?php echo esc_attr($settings['api_key']); ?>" placeholder="کلید API خود را در سامانه پیامکی وارد نمایید">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label required">شماره خط سامانه</label>
                                        <input type="text" class="form-input" name="cardifa_sms_options[line_number]" value="<?php echo esc_attr($settings['line_number']); ?>" placeholder="شماره خط خود را در سامانه پیامکی وارد نمایید">
                                    </div>
                                </div>
                                
                                <div class="service-fields" id="service-ghasedak" style="display: <?php echo $settings['service'] === 'ghasedak' ? 'block' : 'none'; ?>">
                                    <div class="form-group">
                                        <label class="form-label required">API سامانه</label>
                                        <input type="text" class="form-input" name="cardifa_sms_options[api_key]" value="<?php echo esc_attr($settings['api_key']); ?>" placeholder="کلید API خود را در سامانه پیامکی وارد نمایید">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label required">شماره خط سامانه</label>
                                        <input type="text" class="form-input" name="cardifa_sms_options[line_number]" value="<?php echo esc_attr($settings['line_number']); ?>" placeholder="شماره خط خود را در سامانه پیامکی وارد نمایید">
                                    </div>
                                </div>
                            </div>
                            <div class="form-note">* پر کردن فیلدهای ستاره دار ضروری می‌باشد.</div>
                        </div>
                        <div class="right-content">
                            <div class="connection-wrapper">
                                <div class="connection-title">وضعیت اتصال به سامانه</div>
                                <div class="status-section">
                                    <div class="status-row">
                                        <div class="status-icon">
                                            <i class="fas <?php echo $connection_status['connected'] ? 'fa-check' : 'fa-times'; ?>"></i>
                                        </div>
                                        <div class="status-text">کاربر به سامانه <strong><?php echo $connection_status['connected'] ? 'متصل' : 'غیرمتصل'; ?></strong> است</div>
                                    </div>
                                    <?php if ($connection_status['connected']) : ?>
                                    <div class="status-row">
                                        <div class="status-icon">
                                            <i class="fas fa-check"></i>
                                        </div>
                                        <div class="status-text">پیامک های شما در سامانه <span class="status-number"><?php echo esc_html($connection_status['credit']); ?></span> عدد می‌باشد</div>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="send-sms-form">
                                    <div class="connection-title">ارسال پیامک تست</div>
                                    <div class="form-label required">شماره موبایل</div>
                                    <input type="text" class="send-sms-input" id="test-mobile" placeholder="شماره موبایل خود‌ را وارد نمایید">
                                </div>
                                <div class="send-button-row">
                                    <button type="button" class="send-button" id="test-connection-btn">تست اتصال</button>
                                    <button type="button" class="send-button" id="send-test-sms-btn">ارسال پیامک</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- فعال‌سازی سیستم پیامکی -->
                <div class="card-header">
                    <div class="card-icon">
                        <i class="fas fa-toggle-on"></i>
                    </div>
                    <div class="card-title">
                        <span class="card-title-gray">فعال‌سازی</span>
                        <span class="card-title-regular">سیستم پیامکی</span>
                    </div>
                </div>
                <div class="card">
                    <div class="card-content">
                        <div class="form-group">
                            <label class="toggle-switch">
                                <input type="checkbox" name="cardifa_sms_options[active]" value="1" <?php checked(1, $settings['active']); ?>>
                                <span class="toggle-slider"></span>
                            </label>
                            <span class="toggle-label">فعال‌سازی سیستم ارسال پیامک</span>
                        </div>
                    </div>
                </div>
                
                <!-- پیامک‌های رویدادی -->
                <div class="card-header">
                    <div class="card-icon">
                        <i class="fas fa-bell"></i>
                    </div>
                    <div class="card-title">
                        <span class="card-title-gray">پیامک‌های </span>
                        <span class="card-title-regular">رویدادی</span>
                    </div>
                </div>
                <div class="card sms-event-card">
                    <div class="connection-title"><?php echo $settings['send_type'] === 'pattern' ? 'کدهای پترن سامانه پیامکی' : 'متن پیامک‌های رویدادی'; ?></div>
                    
                    <div class="event-form-group">
                        <?php 
                        $counter = 0;
                        foreach ($events as $event_key => $event_name) : 
                            if ($counter % 3 == 0) {
                                echo '<div class="event-row">';
                            }
                        ?>
                            <div class="event-item">
                                <div class="event-header">
                                    <div class="form-label required"><?php echo esc_html($event_name); ?></div>
                                    <label class="toggle-switch">
                                        <input type="checkbox" name="cardifa_sms_options[events][<?php echo esc_attr($event_key); ?>][active]" value="1" <?php checked(1, $settings['events'][$event_key]['active']); ?>>
                                        <span class="toggle-slider"></span>
                                    </label>
                                </div>
                                <?php if ($settings['send_type'] === 'pattern') : ?>
                                    <div class="event-content">
                                        <input type="text" class="form-input" name="cardifa_sms_options[events][<?php echo esc_attr($event_key); ?>][pattern_code]" value="<?php echo esc_attr($settings['events'][$event_key]['pattern_code']); ?>" placeholder="کد پترن را وارد کنید">
                                    </div>
                                <?php else : ?>
                                    <div class="event-content">
                                        <textarea class="form-textarea" name="cardifa_sms_options[events][<?php echo esc_attr($event_key); ?>][message]" rows="4" placeholder="متن پیامک را وارد کنید"><?php echo esc_textarea($settings['events'][$event_key]['message']); ?></textarea>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php 
                            $counter++;
                            if ($counter % 3 == 0 || $counter == count($events)) {
                                echo '</div>';
                            }
                        endforeach; 
                        ?>
                    </div>
                </div>
                
                <!-- کدهای کوتاه -->
                <div class="card-header">
                    <div class="card-icon">
                        <i class="fas fa-code"></i>
                    </div>
                    <div class="card-title">
                        <span class="card-title-gray">لیست</span>
                        <span class="card-title-regular">کدهای‌کوتاه</span>
                    </div>
                </div>
                <div class="card"> 
                    <div class="connection-title">شورت کدهای قابل استفاده</div>
                    <div class="shortcodes-grid">
                        <?php foreach ($shortcodes as $code => $desc) : ?>
                            <div class="shortcode-item">
                                <div class="shortcode-text"><?php echo esc_html($desc); ?></div>
                                <div class="shortcode-code"><span class="shortcode-opt"><?php echo esc_html($code); ?></span></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="save-button">ذخیره تنظیمات</button>
                </div>
            </form>
            
            <!-- مودال ارسال پیامک تست -->
            <div id="test-sms-modal" class="modal">
                <div class="modal-content">
                    <span class="modal-close">&times;</span>
                    <h3>ارسال پیامک تست</h3>
                    <div class="form-group">
                        <label class="form-label required">شماره موبایل</label>
                        <input type="text" id="modal-mobile" class="form-input" placeholder="09123456789">
                    </div>
                    <div class="form-group">
                        <label class="form-label required">متن پیامک</label>
                        <textarea id="modal-message" class="form-textarea" rows="5" placeholder="این یک پیامک تست از سیستم کاردیفا است."></textarea>
                    </div>
                    <div class="form-actions">
                        <button type="button" id="send-test-sms-confirm" class="save-button">ارسال</button>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}