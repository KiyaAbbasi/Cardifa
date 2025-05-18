<?php
/**
 * File: UserAuthenticationTrait.php
 * Description:
 *   مدیریت ورود و ثبت‌نام کاربران شامل:
 *   - ثبت‌نام و ورود با ایمیل و رمز عبور
 *   - پشتیبانی از ورود با پیامک
 *   - بازیابی رمز عبور
 */

namespace Cardifa\Elementor\Traits;

if (!defined('ABSPATH')) exit; // جلوگیری از دسترسی مستقیم

trait UserAuthenticationTrait {

    /**
     * ثبت کاربر جدید
     *
     * @param string $email ایمیل کاربر
     * @param string $password رمز عبور
     * @return array نتیجه عملیات
     */
    public function register_user($email, $password) {
        if (email_exists($email)) {
            return ['success' => false, 'message' => 'این ایمیل قبلاً ثبت شده است.'];
        }

        $user_id = wp_create_user($email, $password, $email);
        if (is_wp_error($user_id)) {
            return ['success' => false, 'message' => $user_id->get_error_message()];
        }

        return ['success' => true, 'user_id' => $user_id];
    }

    /**
     * ورود کاربر
     *
     * @param string $email ایمیل کاربر
     * @param string $password رمز عبور
     * @return array نتیجه عملیات
     */
    public function login_user($email, $password) {
        $creds = [
            'user_login'    => $email,
            'user_password' => $password,
            'remember'      => true,
        ];

        $user = wp_signon($creds, false);
        if (is_wp_error($user)) {
            return ['success' => false, 'message' => $user->get_error_message()];
        }

        return ['success' => true, 'user' => $user];
    }

    /**
     * ارسال لینک بازیابی رمز عبور
     *
     * @param string $email ایمیل کاربر
     * @return array نتیجه عملیات
     */
    public function send_password_reset($email) {
        if (!email_exists($email)) {
            return ['success' => false, 'message' => 'ایمیل یافت نشد.'];
        }

        $reset_key = get_password_reset_key(get_user_by('email', $email));
        $reset_url = network_site_url("wp-login.php?action=rp&key=$reset_key&login=" . rawurlencode($email));

        // ارسال ایمیل
        wp_mail($email, 'بازیابی رمز عبور', "لینک بازیابی: $reset_url");

        return ['success' => true, 'message' => 'لینک بازیابی ارسال شد.'];
    }
}
