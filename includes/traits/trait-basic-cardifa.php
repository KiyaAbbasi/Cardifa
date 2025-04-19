<?php
/**
 * 📁 trait-basic-cardifa.php
 * 🎯 ترکیب همه کنترل‌های اختصاصی با فایل‌های کوچک‌نویس و خط تیره
 * 📍 مسیر: includes/traits/trait-basic-cardifa.php
 */

namespace Cardifa\Traits;

if (!defined('ABSPATH')) exit;

// ✅ تمام فایل‌های کنترل رو اینجا include می‌کنیم (طبق اسم فایل‌های شما)
require_once __DIR__ . '/controls/control-text-style.php';
require_once __DIR__ . '/controls/control-icon-style.php';
require_once __DIR__ . '/controls/control-layout-style.php';
require_once __DIR__ . '/controls/control-background-style.php';
require_once __DIR__ . '/controls/control-border-style.php';
require_once __DIR__ . '/controls/control-box-shadow-style.php';
require_once __DIR__ . '/controls/control-button-style.php';
require_once __DIR__ . '/controls/control-css-filters-style.php';
require_once __DIR__ . '/controls/control-display-style.php';
require_once __DIR__ . '/controls/control-hover-style.php';
require_once __DIR__ . '/controls/control-media-style.php';
require_once __DIR__ . '/controls/control-position-style.php';
require_once __DIR__ . '/controls/control-scroll-style.php';
require_once __DIR__ . '/controls/control-spacing-style.php';
require_once __DIR__ . '/controls/control-text-shadow-style.php';
require_once __DIR__ . '/controls/control-typography-style.php';
require_once __DIR__ . '/controls/control-animation-style.php';

// ✅ استفاده از همه traitهای داخل فایل‌ها (نام کلاس‌ها مهم نیست، فقط trait باشن)
trait Basic_Cardifa_Controls {
    use \Cardifa\Traits\Controls\Control_Text_Style;
    use \Cardifa\Traits\Controls\Control_Icon_Style;
    use \Cardifa\Traits\Controls\Control_Layout_Style;
    use \Cardifa\Traits\Controls\Control_Background_Style;
    use \Cardifa\Traits\Controls\Control_Border_Style;
    use \Cardifa\Traits\Controls\Control_Box_Shadow_Style;
    use \Cardifa\Traits\Controls\Control_Button_Style;
    use \Cardifa\Traits\Controls\Control_Css_Filters_Style;
    use \Cardifa\Traits\Controls\Control_Display_Style;
    use \Cardifa\Traits\Controls\Control_Hover_Style;
    use \Cardifa\Traits\Controls\Control_Media_Style;
    use \Cardifa\Traits\Controls\Control_Position_Style;
    use \Cardifa\Traits\Controls\Control_Scroll_Style;
    use \Cardifa\Traits\Controls\Control_Spacing_Style;
    use \Cardifa\Traits\Controls\Control_Text_Shadow_Style;
    use \Cardifa\Traits\Controls\Control_Typography_Style;
    use \Cardifa\Traits\Controls\Control_Animation_Style;
}


