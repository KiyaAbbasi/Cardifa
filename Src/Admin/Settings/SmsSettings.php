<?php
/**
 * Cardifa SMS Settings Page
 * 
 * This file handles the SMS settings panel functionality
 * 
 * @package    Cardifa
 * @subpackage Admin/Settings
 * @author     Kiya Abbasi
 * @since      1.0.0
 */

namespace Cardifa\Admin\Settings;

use Cardifa\Admin\Settings\SMS\SMSHandler;
use Cardifa\Admin\Settings\SMS\ShortcodeHandler;

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * SMS Settings Class
 */
class SmsSettings {

    /**
     * SMS Handler instance
     *
     * @var SMSHandler
     */
    private $sms_handler;

    /**
     * Shortcode Handler instance
     *
     * @var ShortcodeHandler
     */
    private $shortcode_handler;

    /**
     * Constructor
     */
    public function __construct() {
        // Initialize handlers
        $this->sms_handler = new SMSHandler();
        $this->shortcode_handler = new ShortcodeHandler();
        
        // Register actions and filters
        add_action('wp_ajax_cardifa_test_sms_connection', array($this, 'test_sms_connection'));
        add_action('wp_ajax_cardifa_send_test_sms', array($this, 'send_test_sms'));
        add_action('wp_ajax_cardifa_load_event_fields', array($this, 'load_event_fields'));
        add_action('wp_ajax_cardifa_save_sms_settings', array($this, 'save_sms_settings'));
    }

    /**
     * Render the SMS settings page
     */
    public function render() {
        // Get SMS settings
        $sms_settings = get_option('cardifa_sms_settings', array());
        
        // Get SMS providers
        $sms_providers = $this->sms_handler->get_providers();
        
        // Get SMS connection status
        $is_connected = $this->sms_handler->is_connected();
        
        // Get remaining SMS count
        $sms_count = $this->sms_handler->get_sms_count();
        
        // Get SMS sending methods
        $sending_methods = $this->sms_handler->get_sending_methods();
        
        // Get current sending method
        $current_method = isset($sms_settings['sending_method']) ? $sms_settings['sending_method'] : '';
        
        // Get shortcodes
        $shortcodes = $this->shortcode_handler->get_shortcodes();
        
        // Get event SMS settings
        $event_sms = isset($sms_settings['events']) ? $sms_settings['events'] : array();
        
        // Enqueue scripts and styles
        wp_enqueue_style('cardifa-sms-settings', CARDIFA_URL . 'Assets/Admin/Css/SMS-Settings.css', array(), CARDIFA_VERSION);
        wp_enqueue_script('cardifa-sms-settings', CARDIFA_URL . 'Assets/Admin/Js/SMS-Settings.js', array('jquery'), CARDIFA_VERSION, true);
        
        // Event types
        $event_types = array(
            'user_login' => 'ورود کاربر',
            'user_register' => 'ثبت‌نام کاربر',
            'user_register_confirm' => 'تایید ثبت‌نام کاربر',
            'payment_success' => 'پرداخت موفق کاربر',
            'payment_failed' => 'پرداخت ناموفق کاربر',
            'payment_card_failed' => 'عدم پرداخت از کارت کاربر',
            'subscription_renewed' => 'تمدید اشتراک موفق کاربر',
            'subscription_ended' => 'اتمام اشتراک کاربر',
            'subscription_reminder' => 'یادآوری پایان اشتراک کاربر'
        );
        
        // Localize script
        wp_localize_script('cardifa-sms-settings', 'cardifaSmsSettings', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('cardifa_sms_settings_nonce'),
            'strings' => array(
                'testSuccess' => 'اتصال به سامانه پیامکی با موفقیت برقرار شد.',
                'testFailed' => 'اتصال به سامانه پیامکی ناموفق بود. لطفا اطلاعات را بررسی کنید.',
                'smsSent' => 'پیامک با موفقیت ارسال شد.',
                'smsFailed' => 'ارسال پیامک ناموفق بود.',
                'settingsSaved' => 'تنظیمات با موفقیت ذخیره شد.',
                'settingsFailed' => 'ذخیره تنظیمات ناموفق بود.'
            )
        ));
        
        // Start output
        ob_start();
        ?>
        <!-- سامانه پیامکی Cardifa -->
        <div class="card-header">
            <div class="card-icon">
                <i class="fas fa-envelope"></i>
            </div>
            <div class="card-title">
                <span class="card-title-gray">سامانه</span>
                <span class="card-title-regular">پیامکی</span>
            </div>
        </div>
        
        <div class="card">
            <div class="card-content">
                <div class="left-content">
                    <form id="cardifa-sms-settings-form" class="form-container">
                        <div class="form-group">
                            <div class="connection-title">وضعیت اتصال به سامانه</div>
                            <label class="form-label required">انتخاب سامانه</label>
                            <select class="form-input" name="sms_provider" id="sms-provider">
                                <option value="">انتخاب کنید</option>
                                <?php foreach ($sms_providers as $key => $provider) : ?>
                                    <option value="<?php echo esc_attr($key); ?>" <?php selected(isset($sms_settings['provider']) ? $sms_settings['provider'] : '', $key); ?>><?php echo esc_html($provider); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <div class="connection-title"><br></div>
                            <label class="form-label">انتخاب نحوه ارسال</label>
                            <select class="form-input" name="sending_method" id="sending-method">
                                <option value="">انتخاب کنید</option>
                                <?php foreach ($sending_methods as $key => $method) : ?>
                                    <option value="<?php echo esc_attr($key); ?>" <?php selected($current_method, $key); ?>><?php echo esc_html($method); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label required">نام کاربری</label>
                            <input type="text" class="form-input" name="username" placeholder="نام کاربری خود را در سامانه پیامکی وارد نمایید" value="<?php echo esc_attr(isset($sms_settings['username']) ? $sms_settings['username'] : ''); ?>">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label required">رمز عبور</label>
                            <input type="password" class="form-input" name="password" placeholder="رمز عبور خود را در سامانه پیامکی وارد نمایید" value="<?php echo esc_attr(isset($sms_settings['password']) ? $sms_settings['password'] : ''); ?>">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label required">API سامانه</label>
                            <input type="text" class="form-input" name="api_key" placeholder="API سامانه پیامکی را وارد نمایید" value="<?php echo esc_attr(isset($sms_settings['api_key']) ? $sms_settings['api_key'] : ''); ?>">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label required">شماره خط سامانه</label>
                            <input type="text" class="form-input" name="line_number" placeholder="شماره خط سامانه پیامکی را وارد نمایید" value="<?php echo esc_attr(isset($sms_settings['line_number']) ? $sms_settings['line_number'] : ''); ?>">
                        </div>
                    </form>
                    <div class="form-note">* پر کردن فیلدهای ستاره دار ضروری می‌باشد.</div>
                </div>
                
                <div class="right-content">
                    <div class="connection-wrapper">
                        <div class="connection-title">وضعیت اتصال به سامانه</div>
                        
                        <div class="status-section">
                            <div class="status-row">
                                <div class="status-icon">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div class="status-text">کاربر به سامانه <?php echo $is_connected ? '<strong>متصل</strong>' : '<strong style="color: #ff5c5c;">غیرمتصل</strong>'; ?> است</div>
                            </div>
                            
                            <div class="status-row">
                                <div class="status-icon">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div class="status-text">پیامک های شما در سامانه <span class="status-number"><?php echo intval($sms_count); ?></span> عدد می‌باشد</div>
                            </div>
                        </div>
                        
                        <div class="send-sms-form">
                            <div class="connection-title">تست ارتباط سامانه پیامکی</div>
                            <div class="form-label">نوع پیامک تست</div>
                            <select class="send-sms-input" id="test-sms-type">
                                <option value="">انتخاب کنید</option>
                                <?php foreach ($event_types as $key => $event) : ?>
                                    <option value="<?php echo esc_attr($key); ?>"><?php echo esc_html($event); ?></option>
                                <?php endforeach; ?>
                            </select>
                            
                            <div class="form-label required">شماره موبایل</div>
                            <input type="text" class="send-sms-input" id="test-mobile-number" placeholder="شماره موبایل خود‌ را وارد نمایید">
                        </div>
                        <div class="send-button-row">
                            <button type="button" id="test-connection-btn" class="send-button">تست اتصال</button>
                            <button type="button" id="send-test-sms-btn" class="send-button">ارسال پیامک</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- پیامک‌های رویدادی -->
        <div id="event-sms-container" style="<?php echo empty($current_method) ? 'display: none;' : ''; ?>">
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
                <div class="connection-title"><?php echo $current_method === 'pattern' ? 'کدهای پترن سامانه پیامکی' : 'متن‌های پیامک رویدادی'; ?></div>
                <div class="event-form-group" id="event-fields-container">
                    <?php
                    if (!empty($current_method)) {
                        $this->render_event_fields($current_method, $event_types, $event_sms);
                    }
                    ?>
                </div>
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
                <?php foreach ($shortcodes as $code => $description) : ?>
                    <div class="shortcode-item">
                        <div class="shortcode-text"><?php echo esc_html($description); ?></div>
                        <div class="shortcode-code"><span class="shortcode-opt"><?php echo esc_html($code); ?></span></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
        // End output
        $output = ob_get_clean();
        echo $output;
    }
    
    /**
     * Render event fields
     * 
     * @param string $method      Sending method (pattern or service)
     * @param array  $event_types Available event types
     * @param array  $event_sms   Saved event SMS settings
     */
    private function render_event_fields($method, $event_types, $event_sms) {
        foreach ($event_types as $key => $label) {
            $enabled = isset($event_sms[$key]['enabled']) ? $event_sms[$key]['enabled'] : true;
            $value = isset($event_sms[$key]['value']) ? $event_sms[$key]['value'] : '';
            $placeholder = $method === 'pattern' ? 'شماره پترن مورد نظر را از سامانه پیامکی وارد کنید' : 'متن پیامک را وارد کنید';
            ?>
            <div class="event-item">
                <div class="event-header">
                    <div class="form-label required"><?php echo esc_html($label); ?></div>
                    <label class="toggle-switch">
                        <input type="checkbox" name="event_enabled[<?php echo esc_attr($key); ?>]" <?php checked($enabled, true); ?>>
                        <span class="toggle-slider"></span>
                    </label>
                </div>
                <textarea class="event-textarea" name="event_value[<?php echo esc_attr($key); ?>]" placeholder="<?php echo esc_attr($placeholder); ?>"><?php echo esc_textarea($value); ?></textarea>
            </div>
            <?php
        }
    }
    
    /**
     * Ajax handler for loading event fields
     */
    public function load_event_fields() {
        // Check nonce
        check_ajax_referer('cardifa_sms_settings_nonce', 'nonce');
        
        // Get sending method
        $method = isset($_POST['method']) ? sanitize_text_field($_POST['method']) : '';
        
        // Get SMS settings
        $sms_settings = get_option('cardifa_sms_settings', array());
        $event_sms = isset($sms_settings['events']) ? $sms_settings['events'] : array();
        
        // Event types
        $event_types = array(
            'user_login' => 'ورود کاربر',
            'user_register' => 'ثبت‌نام کاربر',
            'user_register_confirm' => 'تایید ثبت‌نام کاربر',
            'payment_success' => 'پرداخت موفق کاربر',
            'payment_failed' => 'پرداخت ناموفق کاربر',
            'payment_card_failed' => 'عدم پرداخت از کارت کاربر',
            'subscription_renewed' => 'تمدید اشتراک موفق کاربر',
            'subscription_ended' => 'اتمام اشتراک کاربر',
            'subscription_reminder' => 'یادآوری پایان اشتراک کاربر'
        );
        
        // Start output buffering
        ob_start();
        $this->render_event_fields($method, $event_types, $event_sms);
        $html = ob_get_clean();
        
        // Send response
        wp_send_json_success(array(
            'html' => $html,
            'title' => $method === 'pattern' ? 'کدهای پترن سامانه پیامکی' : 'متن‌های پیامک رویدادی'
        ));
    }
    
    /**
     * Ajax handler for testing SMS connection
     */
    public function test_sms_connection() {
        // Check nonce
        check_ajax_referer('cardifa_sms_settings_nonce', 'nonce');
        
        // Get form data
        $provider = isset($_POST['provider']) ? sanitize_text_field($_POST['provider']) : '';
        $username = isset($_POST['username']) ? sanitize_text_field($_POST['username']) : '';
        $password = isset($_POST['password']) ? sanitize_text_field($_POST['password']) : '';
        $api_key = isset($_POST['api_key']) ? sanitize_text_field($_POST['api_key']) : '';
        $line_number = isset($_POST['line_number']) ? sanitize_text_field($_POST['line_number']) : '';
        
        // Test connection
        $result = $this->sms_handler->test_connection(array(
            'provider' => $provider,
            'username' => $username,
            'password' => $password,
            'api_key' => $api_key,
            'line_number' => $line_number
        ));
        
        // Send response
        if ($result['success']) {
            wp_send_json_success(array(
                'message' => 'اتصال به سامانه پیامکی با موفقیت برقرار شد.',
                'sms_count' => intval($result['sms_count'])
            ));
        } else {
            wp_send_json_error(array(
                'message' => 'اتصال به سامانه پیامکی ناموفق بود. لطفا اطلاعات را بررسی کنید.'
            ));
        }
    }
    
    /**
     * Ajax handler for sending test SMS
     */
    public function send_test_sms() {
        // Check nonce
        check_ajax_referer('cardifa_sms_settings_nonce', 'nonce');
        
        // Get form data
        $mobile = isset($_POST['mobile']) ? sanitize_text_field($_POST['mobile']) : '';
        $event_type = isset($_POST['event_type']) ? sanitize_text_field($_POST['event_type']) : '';
        
        // Validate data
        if (empty($mobile) || empty($event_type)) {
            wp_send_json_error(array(
                'message' => 'لطفا شماره موبایل و نوع پیامک را وارد کنید.'
            ));
            return;
        }
        
        // Send test SMS
        $result = $this->sms_handler->send_test_sms($mobile, $event_type);
        
        // Send response
        if ($result['success']) {
            wp_send_json_success(array(
                'message' => 'پیامک با موفقیت ارسال شد.'
            ));
        } else {
            wp_send_json_error(array(
                'message' => 'ارسال پیامک ناموفق بود: ' . $result['message']
            ));
        }
    }
    
    /**
     * Ajax handler for saving SMS settings
     */
    public function save_sms_settings() {
        // Check nonce
        check_ajax_referer('cardifa_sms_settings_nonce', 'nonce');
        
        // Get form data
        $provider = isset($_POST['provider']) ? sanitize_text_field($_POST['provider']) : '';
        $sending_method = isset($_POST['sending_method']) ? sanitize_text_field($_POST['sending_method']) : '';
        $username = isset($_POST['username']) ? sanitize_text_field($_POST['username']) : '';
        $password = isset($_POST['password']) ? sanitize_text_field($_POST['password']) : '';
        $api_key = isset($_POST['api_key']) ? sanitize_text_field($_POST['api_key']) : '';
        $line_number = isset($_POST['line_number']) ? sanitize_text_field($_POST['line_number']) : '';
        
        // Get event data
        $event_enabled = isset($_POST['event_enabled']) ? $_POST['event_enabled'] : array();
        $event_value = isset($_POST['event_value']) ? $_POST['event_value'] : array();
        
        // Process events
        $events = array();
        if (!empty($event_value)) {
            foreach ($event_value as $key => $value) {
                $events[$key] = array(
                    'enabled' => isset($event_enabled[$key]) ? true : false,
                    'value' => sanitize_textarea_field($value)
                );
            }
        }
        
        // Prepare settings
        $sms_settings = array(
            'provider' => $provider,
            'sending_method' => $sending_method,
            'username' => $username,
            'password' => $password,
            'api_key' => $api_key,
            'line_number' => $line_number,
            'events' => $events
        );
        
        // Save settings
        update_option('cardifa_sms_settings', $sms_settings);
        
        // Send response
        wp_send_json_success(array(
            'message' => 'تنظیمات با موفقیت ذخیره شد.'
        ));
    }
}
