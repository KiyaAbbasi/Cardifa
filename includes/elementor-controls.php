<?php
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) exit;

/**
 * ✅ ثبت کنترل‌های اختصاصی برای پست تایپ cardifa در المنتور
 */
add_action('elementor/documents/register_controls', function($document) {
    $post = get_post($document->get_main_id());
    if (!$post || $post->post_type !== 'cardifa') return;

    if ($document->get_controls('cardifa_header_style')) return; // جلوگیری از تکرار ثبت

    $document->start_controls_section(
        'cardifa_settings_section',
        [
            'label' => 'تنظیمات کاردیفا',
            'tab'   => Controls_Manager::TAB_SETTINGS,
        ]
    );

    // نوع هدر بالا
    $document->add_control(
        'cardifa_header_style',
        [
            'label' => 'نوع هدر بالا',
            'type' => Controls_Manager::SELECT,
            'render_type' => 'template',
            'options' => [
                'header-1' => 'Header 1',
                'header-2' => 'Header 2',
                'header-3' => 'Header 3',
                'header-4' => 'Header 4',
                'header-5' => 'Header 5',
                'header-6' => 'Header 6',
            ],
        ]
    );

    // نوع فوتر پایین
    $document->add_control(
        'cardifa_footer_style',
        [
            'label' => 'نوع فوتر پایین',
            'type' => Controls_Manager::SELECT,
            'render_type' => 'template',
            'options' => [
                'footer-1' => 'Footer 1',
                'footer-2' => 'Footer 2',
                'footer-3' => 'Footer 3',
                'footer-4' => 'Footer 4',
            ],
        ]
    );

    // رنگ پس‌زمینه
    $document->add_control(
        'cardifa_background_color',
        [
            'label' => 'رنگ پس‌زمینه',
            'type' => Controls_Manager::COLOR,
            'render_type' => 'template',
        ]
    );

    // رنگ حاشیه
    $document->add_control(
        'cardifa_border_color',
        [
            'label' => 'رنگ حاشیه',
            'type' => Controls_Manager::COLOR,
            'render_type' => 'template',
        ]
    );

    // رنگ پس‌زمینه موبایل
    $document->add_control(
        'cardifa_mobile_background_color',
        [
            'label' => 'رنگ پس‌زمینه موبایل',
            'type' => Controls_Manager::COLOR,
            'render_type' => 'template',
        ]
    );

    // تصویر پس‌زمینه دسکتاپ
    $document->add_control(
        'cardifa_background_image',
        [
            'label' => 'تصویر پس‌زمینه',
            'type' => Controls_Manager::MEDIA,
            'render_type' => 'template',
        ]
    );

    // تصویر پس‌زمینه موبایل
    $document->add_control(
        'cardifa_background_image_mobile',
        [
            'label' => 'تصویر پس‌زمینه موبایل',
            'type' => Controls_Manager::MEDIA,
            'render_type' => 'template',
        ]
    );

    $document->end_controls_section();
});

/**
 * ✅ ذخیره تنظیمات المنتور به صورت متای وردپرس هنگام ذخیره پست
 */
add_action('elementor/document/after_save', function($document) {
    $post_id = $document->get_main_id();
    $post = get_post($post_id);
    if (!$post || $post->post_type !== 'cardifa') return;

    $meta_keys = [
        'cardifa_header_style'             => 'headers',
        'cardifa_footer_style'             => 'footers',
        'cardifa_background_color'         => 'background-color',
        'cardifa_border_color'             => 'border-color',
        'cardifa_mobile_background_color'  => 'mobile-background-color',
        'cardifa_background_image'         => 'back_img',
        'cardifa_background_image_mobile'  => 'back_img2',
    ];

    foreach ($meta_keys as $elementor_key => $meta_key) {
        $value = $document->get_settings($elementor_key);
        if (is_array($value) && isset($value['url'])) {
            $value = $value['url'];
        }
        update_post_meta($post_id, $meta_key, sanitize_text_field($value));
    }
});
