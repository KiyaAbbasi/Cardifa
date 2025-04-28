<?php
/**
 * File: editor-style.php
 * Location: src/Elementor/
 * Desc:
 *   – فقط دسته‌های cardifa و layout نمایش داده شوند
 *   – حذف spinner لودر پنل ویجت‌ها تا درگ/دراپ بلافاصله کار کند
 */
defined( 'ABSPATH' ) || exit;

use Elementor\Plugin;

add_action( 'elementor/editor/after_enqueue_styles', function() {
    // ۱) گرفتن ID پست جاری
    $post_id = 0;
    if ( isset( $_GET['post'] ) ) {
        $post_id = absint( $_GET['post'] );
    } elseif ( isset( $_GET['post_id'] ) ) {
        $post_id = absint( $_GET['post_id'] );
    } elseif ( method_exists( Plugin::instance()->editor, 'get_post_id' ) ) {
        $post_id = Plugin::instance()->editor->get_post_id();
    }
    // فقط در ویرایش CPT cardifa
    if ( 'cardifa' !== get_post_type( $post_id ) ) {
        return;
    }

    // CSS سفارشی
    $css = <<<CSS
/* ۱) فقط نمایش دسته‌های cardifa و layout */
.elementor-panel-category-list .elementor-panel-category-item {
  display: none !important;
}
.elementor-panel-category-list .elementor-panel-category-item[data-tab="cardifa"],
.elementor-panel-category-list .elementor-panel-category-item[data-tab="layout"] {
  display: flex !important;
}

/* ۲) مخفی کردن overlay spinner المنتور (نسخه‌های جدید) */
.e-load-mask {
  display: none !important;
}
/* ۳) حذف کلاس is-loading روی wrapper */
.elementor-panel-content-wrapper.is-loading {
  /* اگر پنل محتوایی قفل شده */
  opacity: 1 !important;
  pointer-events: auto !important;
}
CSS;

    wp_add_inline_style( 'elementor-editor', $css );
} );
