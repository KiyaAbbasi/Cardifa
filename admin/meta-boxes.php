<?php
/**
 * 📁 فایل meta-boxes.php
 * ----------------------------
 * ساخت متاباکس تنظیمات بایولینک برای پست تایپ cardifa
 */

if (!defined('ABSPATH')) exit;

/**
 * ✅ افزودن متاباکس تنظیمات بایولینک به پست تایپ cardifa
 */
function cardifa_add_meta_boxes() {
    add_meta_box(
        'cardifa_bio_settings',        // آیدی متاباکس
        'تنظیمات کاریفا',                              
        'cardifa_render_meta_box',     // تابعی که HTML متاباکس رو تولید می‌کنه
        'cardifa',                     // فقط برای پست تایپ cardifa
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'cardifa_add_meta_boxes');

/**
 * ✅ رندر HTML متاباکس تنظیمات بایولینک
 */
function cardifa_render_meta_box($post) {
    wp_nonce_field('cardifa_save_meta_box', 'cardifa_meta_box_nonce');

    $headers = get_post_meta($post->ID, 'headers', true);
    $footers = get_post_meta($post->ID, 'footers', true);
    $border_color = get_post_meta($post->ID, 'border-color', true);
    $bg_color = get_post_meta($post->ID, 'background-color', true);
    $bg_img = get_post_meta($post->ID, 'back_img', true);
    $mobile_bg_color = get_post_meta($post->ID, 'mobile-background-color', true);
    $mobile_bg_img = get_post_meta($post->ID, 'back_img2', true);

    $notch_base = CARDIFA_BIO_URL . 'assets/images/notches/';
    ?>
    <div style="display: flex; flex-wrap: wrap; gap: 20px">
        <div style="flex:1">
            <h4>بالا</h4>
            <?php for ($i = 1; $i <= 6; $i++): $val = 'header-' . $i; ?>
                <label style="display: inline-block; margin: 5px; text-align:center">
                    <input type="radio" name="headers" value="<?php echo $val; ?>" <?php checked($headers, $val); ?>><br>
                    <img src="<?php echo $notch_base . $val . '.png'; ?>" width="80">
                </label>
            <?php endfor; ?>
        </div>
        <div style="flex:1">
            <h4>پایین</h4>
            <?php for ($i = 1; $i <= 4; $i++): $val = 'footer-' . $i; ?>
                <label style="display: inline-block; margin: 5px; text-align:center">
                    <input type="radio" name="footers" value="<?php echo $val; ?>" <?php checked($footers, $val); ?>><br>
                    <img src="<?php echo $notch_base . $val . '.png'; ?>" width="80">
                </label>
            <?php endfor; ?>
        </div>
    </div>
    <hr>
    <label>رنگ حاشیه:
        <input type="color" name="border-color" value="<?php echo esc_attr($border_color); ?>">
    </label><br><br>

    <label>رنگ پس زمینه:
        <input type="color" name="background-color" value="<?php echo esc_attr($bg_color); ?>">
    </label><br><br>

    <label>تصویر پس‌زمینه:
        <input type="text" name="back_img" id="back_img" value="<?php echo esc_attr($bg_img); ?>">
        <button type="button" class="button cardifa-upload" data-target="back_img">انتخاب عکس</button>
    </label><br><br>

    <label>رنگ پس زمینه موبایل:
        <input type="color" name="mobile-background-color" value="<?php echo esc_attr($mobile_bg_color); ?>">
    </label><br><br>

    <label>تصویر پس‌زمینه موبایل:
        <input type="text" name="back_img2" id="back_img2" value="<?php echo esc_attr($mobile_bg_img); ?>">
        <button type="button" class="button cardifa-upload" data-target="back_img2">انتخاب عکس</button>
    </label>

    <script>
        jQuery(document).ready(function ($) {
            $('.cardifa-upload').click(function (e) {
                e.preventDefault();
                var button = $(this);
                var target = $('#' + button.data('target'));
                var custom_uploader = wp.media({
                    title: 'انتخاب عکس',
                    button: { text: 'استفاده از این عکس' },
                    multiple: false
                }).on('select', function () {
                    var attachment = custom_uploader.state().get('selection').first().toJSON();
                    target.val(attachment.url);
                }).open();
            });
        });
    </script>
<?php
}

/**
 * ✅ ذخیره مقادیر متاباکس هنگام ذخیره پست
 */
function cardifa_save_meta_box($post_id) {
    if (!isset($_POST['cardifa_meta_box_nonce']) || !wp_verify_nonce($_POST['cardifa_meta_box_nonce'], 'cardifa_save_meta_box')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    $fields = [
        'headers', 'footers', 'border-color', 'background-color', 'back_img', 'mobile-background-color', 'back_img2'
    ];

    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
        }
    }
}
add_action('save_post', 'cardifa_save_meta_box');
