<?php
/**
 * File Name:    metaboxes.php
 * Location:     includes/
 * Description:  ثبت metabox و ذخیره metadata پویا
 */
defined( 'ABSPATH' ) || exit;

function cardifa_register_meta_boxes() {
    $opts = get_option( 'cardifa_post_types_options', array() );
    if ( empty( $opts['meta_fields'] ) || ! is_array( $opts['meta_fields'] ) ) {
        return;
    }
    foreach ( $opts['meta_fields'] as $field ) {
        if ( empty( $field['post_type'] ) || empty( $field['key'] ) ) {
            continue;
        }
        add_meta_box(
            'cardifa_meta_' . $field['key'],
            ! empty( $field['label'] ) ? $field['label'] : $field['key'],
            'cardifa_meta_box_callback',
            $field['post_type'],
            'normal',
            'default',
            $field
        );
    }
}
add_action( 'add_meta_boxes', 'cardifa_register_meta_boxes' );

function cardifa_meta_box_callback( $post, $meta ) {
    $args = $meta['args'];
    $key  = esc_attr( $args['key'] );
    $value = get_post_meta( $post->ID, $key, true );
    echo '<input type="text" name="' . $key . '" value="' . esc_attr( $value ) . '" style="width:100%;">';
}

function cardifa_save_post_meta( $post_id, $post ) {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    $opts = get_option( 'cardifa_post_types_options', array() );
    if ( empty( $opts['meta_fields'] ) || ! is_array( $opts['meta_fields'] ) ) {
        return;
    }
    foreach ( $opts['meta_fields'] as $field ) {
        $key = $field['key'];
        if ( isset( $_POST[ $key ] ) ) {
            update_post_meta( $post_id, $key, sanitize_text_field( $_POST[ $key ] ) );
        }
    }
}
add_action( 'save_post', 'cardifa_save_post_meta', 10, 2 );
