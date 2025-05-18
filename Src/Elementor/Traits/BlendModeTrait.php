<?php
/**
 * File: BlendModeTrait.php
 * Path: src/Elementor/Traits/
 * Description:
 *   مدیریت تنظیمات Blend Mode شامل:
 *   - انتخاب نوع حالت ترکیب (Blend Mode)
 *   - پیش‌نمایش Blend Mode
 * Author: Kiya Holding
 */

namespace Cardifa\Elementor\Traits;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // جلوگیری از دسترسی مستقیم

trait BlendModeTrait {

    /**
     * ثبت تنظیمات Blend Mode
     *
     * @param string $id شناسه کنترل
     * @param string $selector سلکتور CSS برای اعمال استایل‌ها
     */
    protected function register_blend_mode_controls(
        string $id = 'blend_mode',
        string $selector = '{{WRAPPER}} .cardifa-blend-mode'
    ) {
        // انتخاب حالت ترکیب
        $this->add_control(
            "{$id}_type",
            [
                'label'   => __( 'حالت ترکیب (Blend Mode)', 'cardifa' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'normal'      => __( 'عادی (Normal)', 'cardifa' ),
                    'multiply'    => __( 'ضرب (Multiply)', 'cardifa' ),
                    'screen'      => __( 'اسکرین (Screen)', 'cardifa' ),
                    'overlay'     => __( 'Overlay', 'cardifa' ),
                    'darken'      => __( 'تاریک‌تر (Darken)', 'cardifa' ),
                    'lighten'     => __( 'روشن‌تر (Lighten)', 'cardifa' ),
                    'color-dodge' => __( 'Color Dodge', 'cardifa' ),
                    'color-burn'  => __( 'Color Burn', 'cardifa' ),
                    'difference'  => __( 'Difference', 'cardifa' ),
                    'exclusion'   => __( 'Exclusion', 'cardifa' ),
                    'hue'         => __( 'Hue', 'cardifa' ),
                    'saturation'  => __( 'Saturation', 'cardifa' ),
                    'color'       => __( 'Color', 'cardifa' ),
                    'luminosity'  => __( 'Luminosity', 'cardifa' ),
                ],
                'default' => 'normal',
                'selectors' => [
                    $selector => 'mix-blend-mode: {{VALUE}};',
                ],
            ]
        );

        // پیش‌نمایش Blend Mode
        $this->add_control(
            "{$id}_preview",
            [
                'label'        => __( 'پیش‌نمایش Blend Mode', 'cardifa' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'فعال', 'cardifa' ),
                'label_off'    => __( 'غیرفعال', 'cardifa' ),
                'return_value' => 'yes',
                'default'      => 'no',
            ]
        );
    }
}
