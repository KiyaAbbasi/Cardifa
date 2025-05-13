<?php
/**
 * File: Admin-Layout.php
 * Description: قالب اصلی پنل مدیریت کاردیفا شامل سایدبار، هدر، و محتوای مرکزی داینامیک
 * Author:      Kiya Holding
 * Since:       1.0.0
 */

defined('ABSPATH') || exit;

// دریافت اطلاعات کاربر جاری
$current_user = wp_get_current_user();
$user_name    = $current_user->display_name ?: $current_user->user_login;
$user_role    = !empty($current_user->roles[0]) ? translate_user_role($current_user->roles[0]) : 'کاربر';
$avatar_url   = get_avatar_url($current_user->ID);
?>

<div id="cardifa-admin-wrapper">

  <!-- █ سایدبار ثابت سمت راست -->
  <aside id="cardifa-sidebar">
    <div class="logo">
      <img src="<?php echo plugin_dir_url(__FILE__) . '../../../Assets/Admin/Img/Cardifa-Admin-Logo.webp'; ?>" alt="Cardifa Logo">
    </div>

    <!-- منوی ناوبری پنل -->
    <nav class="menu">
      <ul>
        <li data-section="dashboard" class="active">داشبورد</li>
        <li data-section="sms">پیامک</li>
        <li data-section="users">کاربران</li>
        <li data-section="plans">پلن‌ها</li>
        <li data-section="seo">سئو</li>
        <li data-section="tickets">تیکت‌ها</li>
        <li data-section="notices">اطلاعیه‌ها</li>
        <li data-section="logout">خروج</li>
      </ul>
    </nav>
  </aside>

  <!-- █ محتوای اصلی -->
  <main id="cardifa-main">

    <!-- هدر پنل -->
    <header id="cardifa-header">
      <div class="header-title">
        <h2>پنل مدیریت</h2>
        <span id="cardifa-time"><?php echo function_exists('jdate') ? jdate('l Y/m/d - H:i') : date('l Y/m/d - H:i'); ?></span>
      </div>

      <div class="header-right">
        <button id="cardifa-save-btn" class="primary-button">ذخیره تنظیمات</button>

        <!-- اطلاعات کاربر وارد شده -->
        <div class="user-info">
          <img class="avatar" src="<?php echo esc_url($avatar_url); ?>" alt="User Avatar">
          <div class="user-meta">
            <strong><?php echo esc_html($user_name); ?></strong>
            <span><?php echo esc_html($user_role); ?></span>
          </div>
        </div>
      </div>
    </header>

    <!-- محتوای مرکزی که با Ajax بارگذاری می‌شود -->
    <section id="cardifa-dynamic-content">
      <p>لطفاً یکی از گزینه‌های منو را انتخاب کنید...</p>
    </section>

  </main>
</div>
