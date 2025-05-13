<?php
/**
 * File: Taxonomies.php
 * Location: Includes/
 * Description:
 *   ثبت taxonomyهای «دسته‌‌بندی کارت» و «برچسب کارت» با:
 *   - تصویر شاخص برای هر ترم
 *   - انتخاب دسته مادر (برای دسته‌بندی)
 *   - نمایش تصویر در لیست ترم‌ها
 *   - پشتیبانی کامل از REST API و ویرایشگر المنتور
 * Author:      Kiya Holding
 * Since:       1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * ۱) ثبت taxonomyهای کارت
 */
function cardifa_register_taxonomies() {
    // ۱a. دسته‌بندی کارت‌ها (hierarchical)
    $labels_cat = [
        'name'              => _x( 'دسته‌های کارت',   'taxonomy general name',  'cardifa' ),
        'singular_name'     => _x( 'دسته کارت',       'taxonomy singular name', 'cardifa' ),
        'search_items'      => __( 'جستجوی دسته کارت',        'cardifa' ),
        'all_items'         => __( 'همه دسته‌های کارت',        'cardifa' ),
        'parent_item'       => __( 'دسته مادر',               'cardifa' ),
        'parent_item_colon' => __( 'دسته مادر:',             'cardifa' ),
        'edit_item'         => __( 'ویرایش دسته کارت',        'cardifa' ),
        'update_item'       => __( 'به‌روزرسانی دسته کارت',   'cardifa' ),
        'add_new_item'      => __( 'افزودن دسته کارت جدید',   'cardifa' ),
        'new_item_name'     => __( 'نام دسته جدید',            'cardifa' ),
        'menu_name'         => __( 'دسته‌های کارت',           'cardifa' ),
    ];
    $args_cat = [
        'labels'            => $labels_cat,
        'hierarchical'      => true,
        'public'            => true,
        'show_ui'           => true,
        'show_in_menu'      => false,  // زیرمجموعه‌ی فهرست کارت
        'show_in_rest'      => true,
        'rest_base'         => 'cardifa_card_category',
        'rewrite'           => ['slug'=>'cardifa-category','with_front'=>false],
        'show_admin_column' => true,
    ];
    register_taxonomy( 'cardifa_card_category', ['cardifa'], $args_cat );

    // ۱b. برچسب کارت‌ها (non-hierarchical)
    $labels_tag = [
        'name'              => _x( 'برچسب‌های کارت',    'taxonomy general name',  'cardifa' ),
        'singular_name'     => _x( 'برچسب کارت',       'taxonomy singular name', 'cardifa' ),
        'search_items'      => __( 'جستجوی برچسب کارت',     'cardifa' ),
        'all_items'         => __( 'همه برچسب‌های کارت',     'cardifa' ),
        'edit_item'         => __( 'ویرایش برچسب کارت',     'cardifa' ),
        'update_item'       => __( 'به‌روزرسانی برچسب کارت','cardifa' ),
        'add_new_item'      => __( 'افزودن برچسب کارت',     'cardifa' ),
        'new_item_name'     => __( 'نام برچسب جدید',        'cardifa' ),
        'menu_name'         => __( 'برچسب‌های کارت',         'cardifa' ),
    ];
    $args_tag = [
        'labels'            => $labels_tag,
        'hierarchical'      => false,
        'public'            => true,
        'show_ui'           => true,
        'show_in_menu'      => false,
        'show_in_rest'      => true,
        'rest_base'         => 'cardifa_card_tag',
        'rewrite'           => ['slug'=>'cardifa-tag','with_front'=>false],
        'show_admin_column' => true,
    ];
    register_taxonomy( 'cardifa_card_tag', ['cardifa'], $args_tag );
}
add_action( 'init', 'cardifa_register_taxonomies', 0 );

/**
 * ۲) افزودن فیلد تصویر شاخص در فرم افزودن/ویرایش ترم
 */
function cardifa_taxonomy_add_image_field( $taxonomy ) {
    ?>
    <div class="form-field term-thumbnail-wrap">
      <label for="cardifa_term_thumbnail"><?php esc_html_e( 'تصویر شاخص', 'cardifa' ); ?></label>
      <input type="text" name="cardifa_term_thumbnail" id="cardifa_term_thumbnail" value="" placeholder="<?php esc_attr_e( 'URL تصویر را وارد کنید یا از مدیا انتخاب کنید', 'cardifa' ); ?>">
      <button class="button cardifa-upload-image"><?php esc_html_e( 'انتخاب تصویر', 'cardifa' ); ?></button>
    </div>
    <?php
}
add_action( 'cardifa_card_category_add_form_fields', 'cardifa_taxonomy_add_image_field', 10, 1 );
add_action( 'cardifa_card_tag_add_form_fields',      'cardifa_taxonomy_add_image_field', 10, 1 );

function cardifa_taxonomy_edit_image_field( $term, $taxonomy ) {
    $thumbnail = get_term_meta( $term->term_id, 'cardifa_term_thumbnail', true );
    ?>
    <tr class="form-field term-thumbnail-wrap">
      <th scope="row"><label for="cardifa_term_thumbnail"><?php esc_html_e( 'تصویر شاخص', 'cardifa' ); ?></label></th>
      <td>
        <input type="text" name="cardifa_term_thumbnail" id="cardifa_term_thumbnail" value="<?php echo esc_attr( $thumbnail ); ?>" placeholder="<?php esc_attr_e( 'URL تصویر را وارد کنید یا از مدیا انتخاب کنید', 'cardifa' ); ?>">
        <button class="button cardifa-upload-image"><?php esc_html_e( 'انتخاب تصویر', 'cardifa' ); ?></button>
      </td>
    </tr>
    <?php
}
add_action( 'cardifa_card_category_edit_form_fields', 'cardifa_taxonomy_edit_image_field', 10, 2 );
add_action( 'cardifa_card_tag_edit_form_fields',      'cardifa_taxonomy_edit_image_field', 10, 2 );

/**
 * ۳) ذخیره متادیتای تصویر شاخص ترم
 */
function cardifa_save_taxonomy_image_meta( $term_id ) {
    if ( isset( $_POST['cardifa_term_thumbnail'] ) ) {
        update_term_meta(
            $term_id,
            'cardifa_term_thumbnail',
            esc_url_raw( $_POST['cardifa_term_thumbnail'] )
        );
    }
}
add_action( 'created_cardifa_card_category', 'cardifa_save_taxonomy_image_meta', 10, 2 );
add_action( 'edited_cardifa_card_category',  'cardifa_save_taxonomy_image_meta', 10, 2 );
add_action( 'created_cardifa_card_tag',      'cardifa_save_taxonomy_image_meta', 10, 2 );
add_action( 'edited_cardifa_card_tag',       'cardifa_save_taxonomy_image_meta', 10, 2 );

/**
 * ۴) نمایش ستون «تصویر» در لیست ترم‌ها
 */
function cardifa_taxonomy_columns( $columns ) {
    $new_columns = [];
    foreach ( $columns as $key => $title ) {
        $new_columns[ $key ] = $title;
        if ( 'name' === $key ) {
            $new_columns['thumbnail'] = __( 'تصویر', 'cardifa' );
        }
    }
    return $new_columns;
}
add_filter( 'manage_edit-cardifa_card_category_columns', 'cardifa_taxonomy_columns' );
add_filter( 'manage_edit-cardifa_card_tag_columns',      'cardifa_taxonomy_columns' );

/**
 * ۵) پر کردن داده‌ی ستون «تصویر» 
 */
function cardifa_taxonomy_custom_column( $content, $column, $term_id ) {
    if ( 'thumbnail' === $column ) {
        $url = get_term_meta( $term_id, 'cardifa_term_thumbnail', true );
        if ( $url ) {
            $content = '<img src="' . esc_url( $url ) . '" style="max-width:60px;height:auto;">';
        } else {
            $content = '&mdash;';
        }
    }
    return $content;
}
add_filter( 'manage_cardifa_card_category_custom_column', 'cardifa_taxonomy_custom_column', 10, 3 );
add_filter( 'manage_cardifa_card_tag_custom_column',      'cardifa_taxonomy_custom_column', 10, 3 );

/**
 * ۶) enqueue اسکریپت مدیای انتخاب تصویر در فرم تکسونومی
 */
function cardifa_enqueue_taxonomy_media_script( $hook ) {
    if ( 'edit-tags.php' === $hook && in_array( get_current_screen()->taxonomy, ['cardifa_card_category','cardifa_card_tag'], true ) ) {
        wp_enqueue_media();
        wp_enqueue_script(
            'cardifa-taxonomy-media',
            CARDIFA_URL . 'Assets/Admin/Js/taxonomy-media.js',
            ['jquery'],
            CARDIFA_VERSION,
            true
        );
    }
}
add_action( 'admin_enqueue_scripts', 'cardifa_enqueue_taxonomy_media_script' );
