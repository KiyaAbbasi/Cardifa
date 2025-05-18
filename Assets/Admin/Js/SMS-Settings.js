jQuery(document).ready(function($) {
    // نمایش/مخفی کردن فیلدهای مربوط به هر سرویس پیامکی
    $('#sms-service').on('change', function() {
        const service = $(this).val();
        
        // مخفی کردن همه فیلدها
        $('.service-field').hide();
        
        // نمایش فیلدهای مربوط به سرویس انتخاب شده
        $(`.service-field.${service}`).show();
        
        // فیلدهای عمومی
        if (service) {
            $('.common-field').show();
        } else {
            $('.common-field').hide();
        }
    }).trigger('change');
    
    // تست اتصال به سامانه پیامکی
    $('#test-connection').on('click', function() {
        const button = $(this);
        const originalText = button.text();
        
        button.prop('disabled', true).text('در حال بررسی...');
        
        const data = {
            action: 'cardifa_test_sms_connection',
            nonce: cardifaSmsSettings.nonce,
            service: $('#sms-service').val(),
            api_key: $('#api-key').val(),
            username: $('#username').val(),
            password: $('#password').val(),
            line_number: $('#line-number').val(),
        };
        
        $.post(cardifaSmsSettings.ajaxUrl, data, function(response) {
            if (response.success) {
                showNotification('success', response.data.message);
                
                if (response.data.credit) {
                    $('#credit-info').text(`اعتبار باقیمانده: ${response.data.credit} ریال`).show();
                }
            } else {
                showNotification('error', response.data);
            }
            
            button.prop('disabled', false).text(originalText);
        }).fail(function() {
            showNotification('error', cardifaSmsSettings.messages.connectionError);
            button.prop('disabled', false).text(originalText);
        });
    });
    
    // ارسال پیامک تست
    $('#send-test-sms').on('click', function() {
        const button = $(this);
        const originalText = button.text();
        
        // دریافت شماره موبایل
        const mobile = prompt('لطفا شماره موبایل برای ارسال پیامک تست را وارد کنید:');
        
        if (!mobile) {
            return;
        }
        
        button.prop('disabled', true).text('در حال ارسال...');
        
        const data = {
            action: 'cardifa_send_test_sms',
            nonce: cardifaSmsSettings.nonce,
            service: $('#sms-service').val(),
            api_key: $('#api-key').val(),
            username: $('#username').val(),
            password: $('#password').val(),
            line_number: $('#line-number').val(),
            mobile: mobile,
            message: 'این یک پیامک تست از طرف کاردیفا است.',
        };
        
        $.post(cardifaSmsSettings.ajaxUrl, data, function(response) {
            if (response.success) {
                showNotification('success', cardifaSmsSettings.messages.testSuccess);
            } else {
                showNotification('error', response.data);
            }
            
            button.prop('disabled', false).text(originalText);
        }).fail(function() {
            showNotification('error', cardifaSmsSettings.messages.testError);
            button.prop('disabled', false).text(originalText);
        });
    });
    
    // ذخیره تنظیمات
    $('#sms-settings-form').on('submit', function(e) {
        e.preventDefault();
        
        const button = $('#save-settings');
        const originalText = button.text();
        
        button.prop('disabled', true).text('در حال ذخیره...');
        
        const data = {
            action: 'cardifa_save_SmsSettings',
            nonce: cardifaSmsSettings.nonce,
            service: $('#sms-service').val(),
            api_key: $('#api-key').val(),
            username: $('#username').val(),
            password: $('#password').val(),
            line_number: $('#line-number').val(),
        };
        
        // دریافت قالب‌های پیامک
        data.templates = {};
        $('.template-item').each(function() {
            const key = $(this).data('key');
            data.templates[key] = {
                active: $(this).find('.template-active').is(':checked'),
                content: $(this).find('.template-content').val(),
            };
        });
        
        // دریافت گیرندگان پیامک
        data.recipients = {};
        $('.recipient-item').each(function() {
            const key = $(this).data('key');
            data.recipients[key] = {
                active: $(this).find('.recipient-active').is(':checked'),
                mobile: $(this).find('.recipient-mobile').val(),
            };
        });
        
        $.post(cardifaSmsSettings.ajaxUrl, data, function(response) {
            if (response.success) {
                showNotification('success', cardifaSmsSettings.messages.saveSuccess);
            } else {
                showNotification('error', response.data);
            }
            
            button.prop('disabled', false).text(originalText);
        }).fail(function() {
            showNotification('error', cardifaSmsSettings.messages.saveError);
            button.prop('disabled', false).text(originalText);
        });
    });
    
    // نمایش اعلان
    function showNotification(type, message) {
        const notification = $('#notification');
        notification.removeClass('success error').addClass(type);
        notification.text(message).fadeIn();
        
        setTimeout(function() {
            notification.fadeOut();
        }, 3000);
    }
    
    // انتخاب قالب پیامک
    $('#template-selector').on('change', function() {
        const key = $(this).val();
        const content = $(`.template-item[data-key="${key}"] .template-content`).val();
        
        $('#template-content').val(content);
    });
    
    // ذخیره قالب پیامک
    $('#save-template').on('click', function() {
        const key = $('#template-selector').val();
        const content = $('#template-content').val();
        
        $(`.template-item[data-key="${key}"] .template-content`).val(content);
        
        showNotification('success', 'قالب پیامک با موفقیت ذخیره شد.');
    });
});