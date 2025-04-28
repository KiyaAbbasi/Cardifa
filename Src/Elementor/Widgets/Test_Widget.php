<?php
/**
 * File Name:       Test_Widget.php
 * Description:     ویجت تست برای بررسی فراخوانی تمام Traits کاردیفا
 * Since:           1.0.0
 * Last Modified:   2025-04-26
 * Author:          Kiya Holding
 * Author URI:      https://kiyaholding.com
 * License:         GPLv3 or later
 * License URI:     https://www.gnu.org/licenses/gpl-3.0.html
 * 
 * @package         Cardifa\Elementor\Widgets
 */

namespace Cardifa\Elementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

// ─── بارگذاری همه‌ی Traits ───
use Cardifa\Elementor\Traits\BasicCardifaElement;
use Cardifa\Elementor\Traits\BasicStyleTrait;
use Cardifa\Elementor\Traits\DimensionTrait;
use Cardifa\Elementor\Traits\IconTrait;
use Cardifa\Elementor\Traits\RepeaterTrait;
use Cardifa\Elementor\Traits\ResponsiveTrait;
use Cardifa\Elementor\Traits\SliderTrait;
use Cardifa\Elementor\Traits\ImageSliderTrait;
use Cardifa\Elementor\Traits\VideoSliderTrait;
use Cardifa\Elementor\Traits\CarouselTrait;
use Cardifa\Elementor\Traits\SwiperJsTrait;
use Cardifa\Elementor\Traits\SliderNavigationTrait;
use Cardifa\Elementor\Traits\SliderAnimationTrait;
use Cardifa\Elementor\Traits\TypographyTrait;
use Cardifa\Elementor\Traits\BackgroundTrait;
use Cardifa\Elementor\Traits\BorderTrait;
use Cardifa\Elementor\Traits\BoxShadowTrait;
use Cardifa\Elementor\Traits\TextShadowTrait;
use Cardifa\Elementor\Traits\FilterTrait;
use Cardifa\Elementor\Traits\TransitionTrait;
use Cardifa\Elementor\Traits\PositionTrait;
use Cardifa\Elementor\Traits\OverflowTrait;
use Cardifa\Elementor\Traits\TransformTrait;
use Cardifa\Elementor\Traits\HoverAnimationTrait;
use Cardifa\Elementor\Traits\EntranceAnimationTrait;
use Cardifa\Elementor\Traits\ScrollViewTrait;
use Cardifa\Elementor\Traits\ShapeDividerTrait;
use Cardifa\Elementor\Traits\BlendModeTrait;
use Cardifa\Elementor\Traits\CustomCSSTrait;
use Cardifa\Elementor\Traits\GlobalSettingsTrait;
use Cardifa\Elementor\Traits\DynamicTagsTrait;
use Cardifa\Elementor\Traits\FormValidationTrait;
use Cardifa\Elementor\Traits\AjaxTrait;
use Cardifa\Elementor\Traits\AccessibilityTrait;
use Cardifa\Elementor\Traits\RoleCapabilityTrait;
use Cardifa\Elementor\Traits\DevToolsTrait;
use Cardifa\Elementor\Traits\LazyLoadTrait;
use Cardifa\Elementor\Traits\GridLayoutTrait;
use Cardifa\Elementor\Traits\ParallaxEffectTrait;
use Cardifa\Elementor\Traits\StickyTrait;
use Cardifa\Elementor\Traits\ConditionalLogicTrait;
use Cardifa\Elementor\Traits\SEOOptimizationTrait;
use Cardifa\Elementor\Traits\MultiLanguageTrait;

defined('ABSPATH') || exit;

/**
 * ویجت تستی کاردیفا برای تست همه Traits
 *
 * @since 1.0.0
 * @package Cardifa\Elementor\Widgets
 */
class Test_Widget extends Widget_Base
{
    // ─── اضافه کردن Traits به ویجت ───
    use BasicCardifaElement;
    use BasicStyleTrait;
    use DimensionTrait;
    use IconTrait;
    use RepeaterTrait;
    use ResponsiveTrait;
    use SliderTrait;
    use ImageSliderTrait;
    use VideoSliderTrait;
    use CarouselTrait;
    use SwiperJsTrait;
    use SliderNavigationTrait;
    use SliderAnimationTrait;
    use TypographyTrait;
    use BackgroundTrait;
    use BorderTrait;
    use BoxShadowTrait;
    use TextShadowTrait;
    use FilterTrait;
    use TransitionTrait;
    use PositionTrait;
    use OverflowTrait;
    use TransformTrait;
    use HoverAnimationTrait;
    use EntranceAnimationTrait;
    use ScrollViewTrait;
    use ShapeDividerTrait;
    use BlendModeTrait;
    use CustomCSSTrait;
    use GlobalSettingsTrait;
    use DynamicTagsTrait;
    use FormValidationTrait;
    use AjaxTrait;
    use AccessibilityTrait;
    use RoleCapabilityTrait;
    use DevToolsTrait;
    use LazyLoadTrait;
    use GridLayoutTrait;
    use ParallaxEffectTrait;
    use StickyTrait;
    use ConditionalLogicTrait;
    use SEOOptimizationTrait;
    use MultiLanguageTrait;

    /**
     * بازگرداندن نام ویجت
     *
     * @return string
     */
    public function get_name()
    {
        return 'cardifa_test_widget';
    }

    /**
     * بازگرداندن عنوان ویجت
     *
     * @return string
     */
    public function get_title()
    {
        return __('ویجت تستی کاردیفا', 'cardifa');
    }

    /**
     * بازگرداندن آیکون ویجت
     *
     * @return string
     */
    public function get_icon()
    {
        return 'eicon-flame';
    }

    /**
     * بازگرداندن دسته‌بندی ویجت
     *
     * @return array
     */
    public function get_categories()
    {
        return ['cardifa'];
    }

    /**
     * ثبت کنترل‌های ویجت
     *
     * @return void
     */
    protected function register_controls()
    {
        $this->start_controls_section(
            'section_test_controls',
            [
                'label' => __('تست کامل تاریت‌ها', 'cardifa'),
            ]
        );

        // صدا زدن متد ثبت کنترل‌های Traits
        $this->register_basic_cardifa_controls();
        $this->register_basic_style_controls();
        $this->register_dimension_controls();
        $this->register_icon_controls();
        $this->register_repeater_controls();
        $this->register_responsive_controls();
        $this->register_slider_controls();
        $this->register_image_slider_controls();
        $this->register_video_slider_controls();
        $this->register_carousel_controls();
        $this->register_swiper_js_controls();
        $this->register_slider_navigation_controls();
        $this->register_slider_animation_controls();
        $this->register_typography_controls();
        $this->register_background_controls();
        $this->register_border_controls();
        $this->register_box_shadow_controls();
        $this->register_text_shadow_controls();
        $this->register_filter_controls();
        $this->register_transition_controls();
        $this->register_position_controls();
        $this->register_overflow_controls();
        $this->register_transform_controls();
        $this->register_hover_animation_controls();
        $this->register_entrance_animation_controls();
        $this->register_scroll_view_controls();
        $this->register_shape_divider_controls();
        $this->register_blend_mode_controls();
        $this->register_custom_css_controls();
        $this->register_global_settings_controls();
        $this->register_dynamic_tags_controls();
        $this->register_form_validation_controls();
        $this->register_ajax_controls();
        $this->register_accessibility_controls();
        $this->register_role_capability_controls();
        $this->register_dev_tools_controls();
        $this->register_lazy_load_controls();
        $this->register_grid_layout_controls();
        $this->register_parallax_effect_controls();
        $this->register_sticky_controls();
        $this->register_conditional_logic_controls();
        $this->register_seo_optimization_controls();
        $this->register_multi_language_controls();

        $this->end_controls_section();
    }

    /**
     * رندر خروجی فرانت‌اند
     *
     * @return void
     */
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        echo '<div class="cardifa-test-widget">';
        echo '<h3>' . esc_html__('تست موفق همه‌ی Traits کاردیفا 🚀', 'cardifa') . '</h3>';
        echo '</div>';
    }
}
