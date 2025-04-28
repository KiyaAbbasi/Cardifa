<?php
/**
 * File Name:    roles-capabilities.php
 * Location:     includes/
 * Description:  تعریف نقش‌ها و قابلیت‌ها
 */
defined( 'ABSPATH' ) || exit;

function cardifa_add_roles_caps() {
    add_role('cardifa_user','کاردیفا کاربر',['read'=>true]);
    $role = get_role('cardifa_user');
    if($role){
        $role->add_cap('edit_cardifa_card');
        $role->add_cap('publish_cardifa_card');
    }
}
add_action('init','cardifa_add_roles_caps');
