<?php
defined('ABSPATH') || exit;

/**
 * شورت‌کد داشبورد بایولینک کاربر
 * نمایش لیست بایولینک‌های ساخته‌شده توسط کاربر
 * و فرم ساخت لینک جدید
 */
function cardifa_user_dashboard_shortcode() {
    if (!is_user_logged_in()) {
        return '<p>برای استفاده از داشبورد ابتدا وارد حساب کاربری شوید.</p>';
    }

    $current_user = wp_get_current_user();

    // لیست بایولینک‌های این کاربر
    $args = array(
        'post_type' => 'cardifa_biolink',
        'author' => $current_user->ID,
        'posts_per_page' => -1
    );
    $links = get_posts($args);

    ob_start();

    echo '<h2>بایولینک‌های شما</h2>';
    if ($links) {
        echo '<ul>';
        foreach ($links as $link) {
            $url = home_url('/') . $link->post_name;
            echo "<li><strong>{$link->post_title}</strong> – <a href='{$url}' target='_blank'>{$url}</a> | <a href='" . get_edit_post_link($link->ID) . "'>ویرایش</a></li>";
        }
        echo '</ul>';
    } else {
        echo '<p>شما هنوز هیچ بایولینکی نساخته‌اید.</p>';
    }

    // فرم ساخت لینک جدید
    ?>
    <h3>ساخت بایولینک جدید</h3>
    <form method="post">
        <label>عنوان بایولینک:
            <input type="text" name="cardifa_title" required />
        </label><br><br>

        <label>آدرس دلخواه (مثلاً kia):
            <input type="text" name="cardifa_slug" required />
        </label><br><br>

        <button type="submit" name="cardifa_submit">ساخت لینک</button>
    </form>
    <?php

    // پردازش فرم
    if (isset($_POST['cardifa_submit'])) {
        $title = sanitize_text_field($_POST['cardifa_title']);
        $slug = sanitize_title($_POST['cardifa_slug']);

        // بررسی تکراری نبودن اسلاگ
        $slug_exists = get_page_by_path($slug, OBJECT, 'cardifa_biolink');
        if ($slug_exists) {
            echo '<p style="color:red;">این آدرس قبلاً انتخاب شده است. لطفاً آدرس دیگری وارد کنید.</p>';
        } else {
            // ساخت پست جدید
            $post_id = wp_insert_post(array(
                'post_type' => 'cardifa_biolink',
                'post_title' => $title,
                'post_name' => $slug,
                'post_status' => 'publish',
                'post_author' => $current_user->ID,
            ));

            if ($post_id) {
                echo '<p style="color:green;">لینک با موفقیت ساخته شد!</p>';
                echo "<meta http-equiv='refresh' content='1'>";
            } else {
                echo '<p style="color:red;">خطا در ساخت لینک. لطفاً دوباره تلاش کنید.</p>';
            }
        }
    }

    return ob_get_clean();
}
add_shortcode('cardifa_dashboard', 'cardifa_user_dashboard_shortcode');
