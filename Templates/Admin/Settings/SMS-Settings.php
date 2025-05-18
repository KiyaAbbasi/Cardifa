<?php
/**
 * Template: SMS-Settings.php
 * Description: قالب صفحه تنظیمات پیامکی
 */

defined('ABSPATH') || exit;
?>

<div class="wrap cardifa-settings-wrap">
    <div class="cardifa-settings-header">
        <h1 class="cardifa-settings-title"><?php _e('تنظیمات پیامکی کاردیفا', 'cardifa'); ?></h1>
    </div>
    
    <div id="notification"></div>
    
    <form id="sms-settings-form" class="cardifa-settings-form">
        <div class="cardifa-settings-section">
            <h2 class="cardifa-settings-section-title"><?php _e('تنظیمات سرویس پیامکی', 'cardifa'); ?></h2>
            
            <div class="cardifa-settings-field">
                <label for="sms-service"><?php _e('سرویس پیامکی', 'cardifa'); ?></label>
                <select id="sms-service" name="service">
                    <?php foreach ($sms_services as $key => $label) : ?>
                        <option value="<?php echo esc_attr($key); ?>" <?php selected($service, $key); ?>><?php echo esc_html($label); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="cardifa-settings-field service-field kavenegar smsir">
                <label for="api-key"><?php _e('کلید API', 'cardifa'); ?></label>
                <input type="text" id="api-key" name="api_key" value="<?php echo esc_attr($api_key); ?>" placeholder="<?php _e('کلید API را وارد کنید', 'cardifa'); ?>">
            </div>
            
            <div class="cardifa-settings-field service-field melipayamak farazsms">
                <label for="username"><?php _e('نام کاربری', 'cardifa'); ?></label>
                <input type="text" id="username" name="username" value="<?php echo esc_attr($username); ?>" placeholder="<?php _e('نام کاربری را وارد کنید', 'cardifa'); ?>">
            </div>
            
            <div class="cardifa-settings-field service-field melipayamak farazsms">
                <label for="password"><?php _e('رمز عبور', 'cardifa'); ?></label>
                <input type="password" id="password" name="password" value="<?php echo esc_attr($password); ?>" placeholder="<?php _e('رمز عبور را وارد کنید', 'cardifa'); ?>">
            </div>
            
            <div class="cardifa-settings-field common-field">
                <label for="line-number"><?php _e('شماره خط', 'cardifa'); ?></label>
                <input type="text" id="line-number" name="line_number" value="<?php echo esc_attr($line_number); ?>" placeholder="<?php _e('شماره خط ارسال پیامک را وارد کنید', 'cardifa'); ?>">
            </div>
            
            <div id="credit-info"></div>
            
            <div class="button-row">
                <button type="button" id="test-connection" class="button button-secondary"><?php _e('تست اتصال', 'cardifa'); ?></button>
                <button type="button" id="send-test-sms" class="button button-secondary"><?php _e('ارسال پیامک تست', 'cardifa'); ?></button>
            </div>
        </div>
        
        <div class="cardifa-settings-section">
            <h2 class="cardifa-settings-section-title"><?php _e('قالب‌های پیامک', 'cardifa'); ?></h2>
            
            <div class="cardifa-settings-field">
                <label for="template-selector"><?php _e('انتخاب قالب', 'cardifa'); ?></label>
                <select id="template-selector">
                    <?php foreach ($template_types as $key => $label) : ?>
                        <option value="<?php echo esc_attr($key); ?>"><?php echo esc_html($label); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="cardifa-settings-field">
                <label for="template-content"><?php _e('محتوای قالب', 'cardifa'); ?></label>
                <textarea id="template-content" placeholder="<?php _e('متن پیامک را وارد کنید', 'cardifa'); ?>"></textarea>
                <p class="description"><?php _e('از کدهای کوتاه زیر می‌توانید در متن پیامک استفاده کنید.', 'cardifa'); ?></p>
            </div>
            
            <div class="shortcodes-list">
                <?php foreach ($shortcodes as $code => $desc) : ?>
                    <div class="shortcode-item" title="<?php echo esc_attr($desc); ?>"><?php echo esc_html($code); ?></div>
                <?php endforeach; ?>
            </div>
            
            <div class="button-row">
                <button type="button" id="save-template" class="button button-secondary"><?php _e('ذخیره قالب', 'cardifa'); ?></button>
            </div>
            
            <div style="display: none;">
                <?php foreach ($template_types as $key => $label) : ?>
                    <?php
                    $template_active = isset($templates[$key]['active']) ? $templates[$key]['active'] : false;
                    $template_content = isset($templates[$key]['content']) ? $templates[$key]['content'] : '';
                    ?>
                    <div class="template-item" data-key="<?php echo esc_attr($key); ?>">
                        <input type="hidden" class="template-active" name="templates[<?php echo esc_attr($key); ?>][active]" value="<?php echo $template_active ? '1' : '0'; ?>">
                        <input type="hidden" class="template-content" name="templates[<?php echo esc_attr($key); ?>][content]" value="<?php echo esc_attr($template_content); ?>">
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <div class="cardifa-settings-section">
            <h2 class="cardifa-settings-section-title"><?php _e('گیرندگان پیامک', 'cardifa'); ?></h2>
            
            <?php foreach ($recipient_types as $key => $label) : ?>
                <?php
                $recipient_active = isset($recipients[$key]['active']) ? $recipients[$key]['active'] : false;
                $recipient_mobile = isset($recipients[$key]['mobile']) ? $recipients[$key]['mobile'] : '';
                ?>
                <div class="recipient-item" data-key="<?php echo esc_attr($key); ?>">
                    <div class="cardifa-settings-field">
                        <label>
                            <input type="checkbox" class="recipient-active" name="recipients[<?php echo esc_attr($key); ?>][active]" value="1" <?php checked($recipient_active, true); ?>>
                            <?php echo esc_html($label); ?>
                        </label>
                    </div>
                    
                    <?php if ($key === 'admin') : ?>
                        <div class="cardifa-settings-field">
                            <label for="recipient-mobile-<?php echo esc_attr($key); ?>"><?php _e('شماره موبایل مدیر', 'cardifa'); ?></label>
                            <input type="text" id="recipient-mobile-<?php echo esc_attr($key); ?>" class="recipient-mobile" name="recipients[<?php echo esc_attr($key); ?>][mobile]" value="<?php echo esc_attr($recipient_mobile); ?>" placeholder="<?php _e('شماره موبایل مدیر را وارد کنید', 'cardifa'); ?>">
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div class="cardifa-settings-section">
            <button type="submit" id="save-settings" class="button button-primary"><?php _e('ذخیره تنظیمات', 'cardifa'); ?></button>
        </div>
    </form>
    
    <script>
        jQuery(document).ready(function($) {
            // انتخاب قالب پیامک
            $('#template-selector').on('change', function() {
                const key = $(this).val();
                const content = $(`.template-item[data-key="${key}"] .template-content`).val();
                
                $('#template-content').val(content);
            }).trigger('change');
            
            // کپی کردن کد کوتاه
            $('.shortcode-item').on('click', function() {
                const shortcode = $(this).text();
                const textarea = $('#template-content');
                
                textarea.val(textarea.val() + shortcode);
            });
            
            // ذخیره قالب
            $('#save-template').on('click', function() {
                const key = $('#template-selector').val();
                const content = $('#template-content').val();
                
                $(`.template-item[data-key="${key}"] .template-content`).val(content);
                $(`.template-item[data-key="${key}"] .template-active`).val('1');
                
                $('#notification').removeClass('error').addClass('success').text('<?php _e('قالب پیامک با موفقیت ذخیره شد.', 'cardifa'); ?>').fadeIn();
                
                setTimeout(function() {
                    $('#notification').fadeOut();
                }, 3000);
            });
        });
    </script>
</div>