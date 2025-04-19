<?php
/**
 * 🎨 قالب نمایشی اصلی برای بایولینک‌ها
 * 📁 مسیر: templates/themes/default.php
 */

if (!defined('ABSPATH')) exit;

// اطمینان از اینکه post global آماده است
global $post;
$post_id = $post ? $post->ID : 0;

if (!$post_id) {
    echo '<h2 style="color:red;text-align:center;">❌ پست ID یافت نشد!</h2>';
    wp_die();
}

// متاهای ذخیره‌شده از المنتور یا سایر بخش‌ها
$header_style   = get_post_meta($post_id, 'headers', true);
$footer_style   = get_post_meta($post_id, 'footers', true);
$border_color   = get_post_meta($post_id, 'border-color', true);
$background     = get_post_meta($post_id, 'background-color', true);
$mobile_bg      = get_post_meta($post_id, 'mobile-background-color', true);
$bg_img         = get_post_meta($post_id, 'back_img', true);
$bg_img2        = get_post_meta($post_id, 'back_img2', true);

// مسیر نُچ‌ها
$notch_base = CARDIFA_BIO_URL . 'assets/images/notches/';
$header_image = $header_style ? $notch_base . $header_style . '.png' : '';
$footer_image = $footer_style ? $notch_base . $footer_style . '.png' : '';
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?> >
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
    <style>
        body {
            margin: 0;
            font-family: sans-serif;
        }
        .main-layout {
            background-color: <?php echo esc_attr($background); ?>;
            <?php if (!empty($bg_img)): ?>
                background-image: url('<?php echo esc_url($bg_img); ?>');
                background-size: cover;
            <?php endif; ?>
        }
        .element_content {
            border: 10px solid <?php echo esc_attr($border_color); ?>;
            background-color: <?php echo esc_attr($mobile_bg); ?>;
            <?php if (!empty($bg_img2)): ?>
                background-image: url('<?php echo esc_url($bg_img2); ?>');
                background-size: cover;
            <?php endif; ?>
        }
        .top-notch, .btn-notch {
            text-align: center;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="main-layout">
        <div class="container" style="max-width: 1320px; margin: auto;">
            <div class="row">
                <div class="element_content col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5 mt-4 mb-4 mx-auto">

                    <?php if (!empty($header_image)): ?>
                        <div class="top-notch">
                            <img src="<?php echo esc_url($header_image); ?>" alt="Header Notch" style="width: 100%;">
                        </div>
                    <?php endif; ?>

                    <?php the_content(); ?>

                    <?php if (!empty($footer_image)): ?>
                        <div class="btn-notch">
                            <img src="<?php echo esc_url($footer_image); ?>" alt="Footer Notch" style="width: 100%;">
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
    <?php wp_footer(); ?>
</body>
</html>
