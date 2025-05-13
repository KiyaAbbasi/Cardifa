/**
 * File: settings.js
 * Desc: افزودن/حذف داینامیک ردیف‌های پلن
 */
jQuery(function($){
  $('#cardifa-add-plan').on('click', function(e){
    e.preventDefault();
    var $tbody = $('table.form-table tbody'),
        idx    = $tbody.find('tr').length,
        rowHtml = '<tr>' +
          '<td><input name="cardifa_plans_options['+idx+'][name]" placeholder="نام پلن"></td>' +
          '<td><input name="cardifa_plans_options['+idx+'][price]" placeholder="قیمت"></td>' +
          '<td><input name="cardifa_plans_options['+idx+'][duration]" placeholder="مدت (ماه)"></td>' +
          '<td><input name="cardifa_plans_options['+idx+'][discount]" placeholder="% تخفیف"></td>' +
          '<td><input name="cardifa_plans_options['+idx+'][max_cards]" placeholder="حداکثر کارت"></td>' +
          '<td><input name="cardifa_plans_options['+idx+'][free_sms]" placeholder="SMS رایگان"></td>' +
          '<td><input name="cardifa_plans_options['+idx+'][storage]" placeholder="فضای ذخیره (MB)"></td>' +
          '<td><a href="#" class="remove-plan">حذف</a></td>' +
        '</tr>';
    $tbody.append(rowHtml);
  });

  // حذف ردیف
  $(document).on('click', '.remove-plan', function(e){
    e.preventDefault();
    $(this).closest('tr').remove();
  });
});

// رنگ افزونه
jQuery(function($){
  if ($.fn.wpColorPicker) {
    $('.cardifa-color-field').wpColorPicker();
  }
});
