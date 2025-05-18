📘 مستند نهایی افزونه Cardifa Elementor Add-On

/**
Plugin Name: کاردیفا - سازنده کارت ویزیت دیجیتال
Plugin URI: https://cardifa.link
Description: افزونه‌ای کامل برای ساخت کارت دیجیتال، لینک بایو، سیستم اشتراک و پنل کاربری با قابلیت ثبت‌نام با شماره موبایل و ویجت‌های حرفه‌ای المنتور.
Version: 1.0.0
Author: Kiya Holding
Author URI: https://kiyaholding.com
Text Domain: cardifa
Domain Path: /languages
*/

1. 🎯 معرفی کلی
   افزونه Cardifa یک سیستم کامل مدیریت لینک بیو و کارت ویزیت دیجیتال است که به صورت کامل با صفحه‌ساز المنتور ادغام شده است. این افزونه:

* دارای سیستم عضویت با موبایل و رمز یک‌بار مصرف (OTP)
* امکان ساخت کارت حرفه‌ای با Drag & Drop
* تنظیمات کامل پلن‌ها و اشتراک‌ها
* پنل مدیریت کاربر و مدیر
* ویجت‌های اختصاصی المنتور با بیش از 60 Trait سفارشی برای طراحی بی‌نهایت

2. 🔒 خط قرمزها و اصول اکید اجرایی (Must-Have Rules)

* ❌ هیچ فایلی بدون تأیید نباید حذف یا بازنویسی شود
* ❌ هیچ فانکشنی بدون بررسی و هماهنگی نباید تغییر یابد یا حذف شود
* ❌ هیچ کدی نباید بدون کامنت کامل و DocBlock باشد
* ❌ ساختار پوشه‌ها و نام‌گذاری باید مطابق PascalCase باشد
* ❌ ساختار طراحی و رنگ‌بندی نباید بدون تأیید نهایی تغییر کند (مرجع: Figma)
* ❌ ارسال فقط بخشی از کد یک فایل = ممنوع کامل
* ✅ همه فایل‌ها باید DocBlock فارسی استاندارد داشته باشند:

/**
 * File: FileName.php
 * Location: مسیر دقیق فایل در پروژه
 * Description: توضیح کلی عملکرد فایل
 */

- ✅ نام تمام کلاس‌ها باید با پیشوند مشخص باشند و مسیر آنها مشخص باشد (مثلاً Class-Settings.php)
- ✅ هر Trait باید دقیقاً برابر نام فایلش باشد و حداقل یک متد با نام register\_\* داشته باشد
- ✅ همه مسیرهای `require_once` باید بررسی و به‌روزرسانی شوند هنگام تغییر نام یا مسیر

3. 🗂️ ساختار دقیق فایل‌ها و پوشه‌ها (فولدربندی کامل پروژه)
   📂 این بخش توسط Kiya به صورت دستی جایگزین می‌شود. لطفاً ساختار فعلی پروژه GitHub را دقیقاً اینجا قرار دهید.


Cardifa/
├── Assets/
│   ├── Admin/
│   │   ├── Css/
│   │   │   ├── Cardifa-Settings.css
│   │   │   ├── Hi-Icon.css
│   │   ├── Js/
│   │   │   ├── Settings.js
│   │   │   ├── Cardifa-Datetime.js
│   │   ├── Img/
│   │       ├── Cardifa-Admin-Logo.svg
│   ├── Elementor/
│   │   ├── Css/
│   │   │   ├── Editor.css
│   │   ├── Js/
│   │       ├── Editor.js
│   ├── Fonts/
│   │   ├── Font-Face.css
│   │   ├── YekanBakh/
│   │   │   ├── YekanBakh-Bold.woff2
│   │   │   ├── YekanBakh-ExtraBlack.woff2
│   │   │   ├── YekanBakh-Medium.woff2
│   │   │   ├── YekanBakh-Regular.woff2
│   │   ├── Hi-Icone/
│   │   │   ├── Css/
│   │   │   │   ├── animation.css
│   │   │   │   ├── fa-hi-icone-codes.css
│   │   │   │   ├── fa-hi-icone-embedded.css
│   │   │   │   ├── fa-hi-icone-ie7-codes.css
│   │   │   │   ├── fa-hi-icone-ie7.css
│   │   │   │   ├── fa-hi-icone.css
│   │   │   ├── Font/
│   │   │       ├── fa-hi-icone.eot
│   │   │       ├── fa-hi-icone.svg
│   │   │       ├── fa-hi-icone.ttf
│   │   │       ├── fa-hi-icone.woff
│   │   │       ├── fa-hi-icone.woff2
│   ├── Public/
│   │   ├── Css/
│   │   │   ├── Public-Style.css
│   │   ├── Js/
│   │       ├── Public-Script.js

├── Docs/
│   ├── Composer.json
│   ├── Manifest.md
│   ├── README.md
│   ├── Package.json

├── Includes/
│   ├── Activation.php
│   ├── Custom-Post-Types.php
│   ├── Deactivation.php
│   ├── Functions.php
│   ├── Meta-Boxes.php
│   ├── Roles-Capabilities.php
│   ├── Taxonomies.php
│   ├── Ajax/
│   │   ├── Form_Ajax.php
│   │   ├── Payment_Ajax.php
│   ├── Helpers/
│   │   ├── Security.php
│   │   ├── Utilities.php
│   ├── Taxonomies/
│   │   ├── Card_Categories.php

├── Lang/
│   ├── cardifa-fa_IR.mo
│   ├── cardifa-fa_IR.po

├── Src/
│   ├── Admin/
│   │   ├── Class-Admin-Menu.php
│   │   ├── Class-Settings.php
│   │   ├── Settings/
│   │   │   ├── General_Settings.php
│   │   │   ├── Sms_Settings.php
│   │   │   ├── Users_Settings.php
│   │   │   ├── Plans_Settings.php
│   ├── API/
│   │   ├── Ajax_Handler.php
│   │   ├── Class-Rest-Endpoints.php
│   │   ├── Rest_Api.php
│   ├── Bootstrap/
│   │   ├── Elementor_Bootstrap.php
│   │   ├── Public_Bootstrap.php
│   ├── Core/
│   │   ├── Application.php
│   │   ├── GlobalAssets.php
│   │   ├── Elementor/
│   │   │   ├── Editor/
│   │   │   │   ├── Editor-Style.php
│   │   │   │   ├── Elementor-Category.php
│   │   │   │   ├── Scripts.php
│   ├── Elementor/
│   │   ├── widgets-loader.php
│   │   ├── Core/
│   │   │   ├── Assets.php
│   │   │   ├── Icons.php
│   │   │   ├── Utilities.php
│   │   ├── Traits/
│   │   │   ├── AccessibilityTrait.php
│   │   │   ├── AjaxTrait.php
│   │   │   ├── AnimationTrait.php
│   │   │   ├── APIIntegrationTrait.php
│   │   │   ├── BackgroundTrait.php
│   │   │   ├── BasicCardifaElement.php
│   │   │   ├── BasicStyleTrait.php
│   │   │   ├── BlendModeTrait.php
│   │   │   ├── BorderAndShadowTrait.php
│   │   │   ├── BorderTrait.php
│   │   │   ├── BoxShadowTrait.php
│   │   │   ├── CacheManagementTrait.php
│   │   │   ├── CarouselTrait.php
│   │   │   ├── ConditionalLogicTrait.php
│   │   │   ├── CustomCSSControlTrait.php
│   │   │   ├── DataBindingTrait.php
│   │   │   ├── DataExportTrait.php
│   │   │   ├── DevToolsTrait.php
│   │   │   ├── DimensionTrait.php
│   │   │   ├── DynamicTagsTrait.php
│   │   │   ├── EntranceAnimationTrait.php
│   │   │   ├── ErrorHandlingTrait.php
│   │   │   ├── EventTrackingTrait.php
│   │   │   ├── FilterTrait.php
│   │   │   ├── FlexLayoutTrait.php
│   │   │   ├── FormValidationTrait.php
│   │   │   ├── GlobalSettingsTrait.php
│   │   │   ├── GridLayoutTrait.php
│   │   │   ├── HoverAnimationTrait.php
│   │   │   ├── HoverEffectTrait.php
│   │   │   ├── IconTrait.php
│   │   │   ├── ImageSliderTrait.php
│   │   │   ├── LazyLoadTrait.php
│   │   │   ├── MultiLanguageTrait.php
│   │   │   ├── NotificationTrait.php
│   │   │   ├── OverflowTrait.php
│   │   │   ├── ParallaxEffectTrait.php
│   │   │   ├── PaymentGatewayTrait.php
│   │   │   ├── PerformanceOptimizationTrait.php
│   │   │   ├── PositionTrait.php
│   │   │   ├── RepeaterTrait.php
│   │   │   ├── ResponsiveTrait.php
│   │   │   ├── ResponsiveVisibilityTrait.php
│   │   │   ├── RoleCapabilityTrait.php
│   │   │   ├── ScrollViewTrait.php
│   │   │   ├── SEOOptimizationTrait.php
│   │   │   ├── ShapeDividerTrait.php
│   │   │   ├── SliderAnimationTrait.php
│   │   │   ├── SliderNavigationTrait.php
│   │   │   ├── SliderTrait.php
│   │   │   ├── SMSNotificationTrait.php
│   │   │   ├── SpacingTrait.php
│   │   │   ├── StickyTrait.php
│   │   │   ├── SwiperJsTrait.php
│   │   │   ├── TextShadowTrait.php
│   │   │   ├── TransformTrait.php
│   │   │   ├── TransitionTrait.php
│   │   │   ├── TypographyTrait.php
│   │   │   ├── UserAuthenticationTrait.php
│   │   │   ├── VideoSliderTrait.php
│   │   │   ├── VisibilityTrait.php 
│   │   ├── Widgets/
│   │       ├── Test_Widget.php
│   ├── Helpers/
│   │   ├── Utils.php
│   │   ├── Datetime-Helper.php
│   ├── Modules/
│   ├── Public/
│   │   ├── Class-Shortcodes.php
│   │   ├── Class-Widgets.php
│   │   ├── Frontend_Assets.php
│   │   ├── Shortcodes.php
│   │   ├── User_Panel.php
│   ├── Services/
│   │   ├── AssetManager.php
│   │   ├── HookManager.php
│   │   ├── SettingsManager.php

├── Templates/
│   ├── Admin/
│   │   ├── Admin-Layout.php
│   ├── Elementor/
│   │   ├── Card-Template.php
│   ├── Public/
│   │   ├── Card-Template.php
│   ├── Shortcodes/
│   │   ├── Profile.php
│   ├── Widgets/
│   │   ├── Widget-Template.php

├── Vendor/             ← فقط پوشه (خالی - برای composer)
├── Uninstall.php
├── Cardifa.php


4. 🧩 لیست کامل Traits
   📁 مسیر Traits: Src/Elementor/Traits/
   تعداد: 61 فایل

5. BasicCardifaElement.php

6. BasicStyleTrait.php

7. DimensionTrait.php

8. IconTrait.php

9. RepeaterTrait.php

10. ResponsiveTrait.php

11. SliderTrait.php

12. ImageSliderTrait.php

13. VideoSliderTrait.php

14. CarouselTrait.php

15. SwiperJsTrait.php

16. SliderNavigationTrait.php

17. SliderAnimationTrait.php

18. TypographyTrait.php

19. BackgroundTrait.php

20. BorderTrait.php

21. BoxShadowTrait.php

22. TextShadowTrait.php

23. FilterTrait.php

24. TransitionTrait.php

25. PositionTrait.php

26. OverflowTrait.php

27. TransformTrait.php

28. HoverAnimationTrait.php

29. EntranceAnimationTrait.php

30. ScrollViewTrait.php

31. ShapeDividerTrait.php

32. BlendModeTrait.php

33. CustomCSSControlTrait.php

34. GlobalSettingsTrait.php

35. DynamicTagsTrait.php

36. FormValidationTrait.php

37. AjaxTrait.php

38. AccessibilityTrait.php

39. RoleCapabilityTrait.php

40. DevToolsTrait.php

41. LazyLoadTrait.php

42. GridLayoutTrait.php

43. ParallaxEffectTrait.php

44. StickyTrait.php

45. ConditionalLogicTrait.php

46. SEOOptimizationTrait.php

47. MultiLanguageTrait.php

48. NotificationTrait.php

49. ErrorHandlingTrait.php

50. EventTrackingTrait.php

51. CacheManagementTrait.php

52. UserAuthenticationTrait.php

53. PaymentGatewayTrait.php

54. PerformanceOptimizationTrait.php

55. SpacingTrait.php

56. VisibilityTrait.php

57. FlexLayoutTrait.php

58. DataBindingTrait.php

59. DataExportTrait.php

60. UtilitiesTrait.php

61. APIIntegrationTrait.php

62. SMSNotificationTrait.php



🧱 لیست کامل Widgets
📁 مسیر ویجت‌ها: Src/Elementor/Widgets/

Slug	                            کلاس PHP	                           توضیح کوتاه

cardifa_advanced-accordion	        Advanced_Accordion	                   آکوردئون پیشرفته با تنظیمات کامل
cardifa_advanced-heading            Advanced_Heading                       تیتر پیشرفته با افکت‌های انیمیشن و استایل‌های پیچیده
cardifa_advanced-iconbox            Advanced_IconBox                       جعبه آیکون قابل تنظیم
cardifa_advanced-tabs               Advanced_Tabs                          تب‌های پیشرفته با طرح‌بندی دلخواه
cardifa_animated-counter	        Animated_Counter	                   شمارنده عددی با افکت انیمیشن
cardifa_audio-player	            Audio_Player	                       پخش‌کننده صوتی با کنترل‌های پیشرفته
cardifa_blog-grid	                Blog_Grid	                           نمایش پست‌ها به صورت شبکه یا لیست
cardifa_button	                    Button	                               دکمه استاندارد المنتور با امکانات اضافه
cardifa_call-to-action	            Call_To_Action	                       دکمه CTA با متن و استایل‌های جذاب
cardifa_carousel	                Carousel	                           اسلایدر محتوا با Navigation و Pagination
cardifa_contact-card	            Contact_Card	                       کارت اطلاعات تماس با آیکون و لینک
cardifa_countdown-bar	            Countdown_Bar	                       نوار شمارنده معکوس برای تخفیفات یا رویدادها
cardifa_divider	                    Divider	                               جداکننده با طرح‌ها و رنگ‌های متنوع
cardifa_dynamic-slider	            Dynamic_Slider	                       اسلایدر داینامیک با محتوای سفارشی
cardifa_faq	                        FAQ	                                   سوالات متداول با آکوردئون داخلی
cardifa_feature-box	                Feature_Box	                           نمایش ویژگی‌ها یا خدمات با آیکون و متن
cardifa_form	                    Form_Widget	                           فرم تماس با اعتبارسنجی و استایل
cardifa_google-map	                Google_Map	                           نقشه گوگل با Marker و تنظیمات API
cardifa_icon-list	                Icon_List	                           لیست آیکون‌‌دار با طرح‌بندی‌های مختلف
cardifa_image-gallery	            Image_Gallery                          گالری تصاویر با Lightbox و Masonry
cardifa_image-hotspot	            Image_Hotspot	                       نقاط قابل کلیک روی تصاویر
cardifa_image	                    Image_Widget	                       تصویر با Caption, Overlay, لینک
cardifa_lottie-animation	        Lottie_Animation	                   نمایش انیمیشن‌های Lottie
cardifa_name	                    Name_Widget	                           نمایش نام نویسنده یا متن دلخواه
cardifa_pie-chart	                Pie_Chart	                           نمودار دایره‌ای با تنظیمات
cardifa_pricing-table	            Pricing_Table	                       جدول قیمت‌گذاری پیشرفته
cardifa_progress-bar	            Progress_Bar	                       نمایش پیشرفت با نوار قابل تنظیم
cardifa_social	                    Social_Widget	                       آیکون‌های شبکه‌های اجتماعی با استایل‌های hover
cardifa_spacer	                    Spacer_Widget	                       ایجاد فاصله دلخواه در طرح‌بندی
cardifa_team-member	                Team_Member	                           نمایش اعضای تیم با عکس، نام و شرح
cardifa_testimonials	            Testimonials	                       اسلایدر نظرات مشتریان با عکس و متن
cardifa_timer	                    Timer_Widget	                       شمارنده معکوس برای رویدادها
cardifa_video-gallery	            Video_Gallery	                       گالری ویدیو با Lightbox
cardifa_video-player	            Video_Player	                       پخش‌کننده ویدیو با تنظیمات پیشرفته
cardifa_weather	                    Weather_Widget	                       وضعیت آب‌وهوا بر اساس موقعیت
cardifa_woocommerce-products	    Woocommerce_Products	               نمایش محصولات ووکامرس (شبکه/اسلایدر)
cardifa_woocommerce-slider	        Woocommerce_Slider	                   اسلایدر محصولات ووکامرس


🚀 فازهای اجرایی پروژه Cardifa

فاز ۱: زیرساخت و اسکلت پروژه

ایجاد ساختار پوشه‌ها و فایل‌ها مطابق با اصول PSR

تنظیم composer برای autoload

ساخت کلاس‌های پایه و بارگذاری اولیه

فاز ۲: ثبت CPT و Taxonomy

ساخت پست تایپ cardifa

ساخت taxonomies اختصاصی برای فیلتر و دسته‌بندی محتوا

فاز ۳: پنل ادمین و تنظیمات

ایجاد منو تنظیمات

پیاده‌سازی تنظیمات پیامک، پلن‌ها، کاربران

فاز ۴: طراحی ویجت‌ها و Traits

ایمپورت Traits (مجموعاً ۶۱ عدد)

بارگذاری خودکار ویجت‌ها

طراحی ویجت تست و اجرای تست ساختاری

فاز ۵: پنل کاربری

پیاده‌سازی داشبورد کاربر

دسترسی محدود بر اساس پلن

آمار کلیک، لینک‌ها و مدیریت اطلاعات کارت

فاز ۶: پیامک و تایید هویت

اتصال به ملی پیامک و APIs دیگر

محدودیت ارسال OTP و بررسی امنیتی

فاز ۷: QR Code & Link Sharing

ساخت QR به فرمت SVG / PNG

پنل اشتراک لینک کوتاه و کپی سریع

فاز ۸: فروش و اشتراک پیشرفته

درگاه پرداخت مستقیم

سیستم کوپن تخفیف

تاریخ انقضا و مدیریت اشتراک

فاز ۹: نهایی‌سازی و تست کامل

تست یکپارچه عملکرد

حذف ویجت‌های غیرمجاز در EditMode

مستندسازی کامل نهایی و تولید README

فاز ۱۰: انتشار نهایی

آپلود روی WordPress Repo

آماده‌سازی صفحه فرود

ویدیو آموزشی و نمونه استفاده کاربران

