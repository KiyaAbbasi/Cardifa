<?php
/**
 * File: editor-scripts.php
 * Desc:
 *   هنگام ویرایش CPT cardifa:
 *   – حذف کلاس is-loading از پنل ویجت‌ها
 */
defined( 'ABSPATH' ) || exit;

use Elementor\Plugin;

add_action( 'elementor/editor/after_enqueue_scripts', function() {
    // فقط در صفحهٔ ویرایش cardifa
    $post_id = 0;
    if ( isset( $_GET['post'] ) ) {
        $post_id = absint( $_GET['post'] );
    } elseif ( isset( $_GET['post_id'] ) ) {
        $post_id = absint( $_GET['post_id'] );
    } elseif ( method_exists( Plugin::instance()->editor, 'get_post_id' ) ) {
        $post_id = Plugin::instance()->editor->get_post_id();
    }
    if ( 'cardifa' !== get_post_type( $post_id ) ) {
        return;
    }

    // JS برای حذف کلاس is-loading
    $js = <<<'JS'
document.addEventListener('DOMContentLoaded', function() {
    // راه‌حل اصلی برای حذف اسپینر
    const removeLoading = () => {
        const wrapper = document.querySelector('.elementor-panel-content-wrapper');
        if (wrapper) {
            wrapper.classList.remove('is-loading');
            wrapper.style.pointerEvents = 'auto';
            wrapper.style.opacity = '1';
        }
    };

    // راه‌حل جایگزین با MutationObserver
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.attributeName === 'class') {
                removeLoading();
            }
        });
    });

    // راه‌حل سوم با استفاده از هوک‌های Elementor
    if (window.elementor) {
        elementor.hooks.addAction('panel/init', removeLoading);
        elementor.hooks.addAction('panel/show', removeLoading);
    }

    // اجرای اولیه و تنظیم observer
    removeLoading();
    const target = document.querySelector('.elementor-panel-content-wrapper');
    if (target) {
        observer.observe(target, { attributes: true });
    }

    // حذف اسپینر بعد از بارگذاری کامل
    setTimeout(removeLoading, 1000);
});
JS;

    wp_add_inline_script( 'elementor-editor', $js );
} );
