<?php
/**
 * File: TransitionTrait.php
 * Path: src/Elementor/Traits/
 * Description:
 *   مدیریت تنظیمات Transition شامل:
 *   - نوع Transition
 *   - مدت زمان
 *   - تأخیر
 * Author: Kiya Holding
 */

namespace Cardifa\Elementor\Traits;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // جلوگیری از دسترسی مستقیم

trait TransitionTrait {

    /**
     * ثبت تنظیمات Transition
     *
     * @param string $id شناسه کنترل
     * @param string $selector سلکتور CSS برای اعمال استایل‌ها
     */
    protected function register_transition_controls(
        string $id = 'transition',
        string $selector = '{{WRAPPER}} .cardifa-transition'
    ) {
        // نوع Transition
        $this->add_control(
            "{$id}_type",
            [
                'label'   => __( 'نوع Transition', 'cardifa' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'ease'       => __( 'Ease', 'cardifa' ),
                    'ease-in'    => __( 'Ease In', 'cardifa' ),
                    'ease-out'   => __( 'Ease Out', 'cardifa' ),
                    'ease-in-out'=> __( 'Ease In Out', 'cardifa' ),
                    'linear'     => __( 'Linear', 'cardifa' ),
                ],
                'default' => 'ease',
            ]
        );

        // مدت زمان Transition
        $this->add_control(
            "{$id}_duration",
            [
                'label'      => __( 'مدت زمان Transition (میلی‌ثانیه)', 'cardifa' ),
                'type'       => Controls_Manager::NUMBER,
                'default'    => 300,
                'min'        => 100,
                'max'        => 5000,
                'step'       => 100,
            ]
        );

        // تأخیر در شروع Transition
        $this->add_control(
            "{$id}_delay",
            [
                'label'      => __( 'تأخیر در شروع Transition (میلی‌ثانیه)', 'cardifa' ),
                'type'       => Controls_Manager::NUMBER,
                'default'    => 0,
                'min'        => 0,
                'max'        => 5000,
                'step'       => 100,
            ]
        );

        // اعمال Transition برای خواص خاص
        $this->add_control(
            "{$id}_properties",
            [
                'label'       => __( 'اعمال Transition روی خواص', 'cardifa' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => 'all',
                'placeholder' => __( 'مثال: opacity, transform', 'cardifa' ),
                'description' => __( 'خواص CSS که Transition روی آن‌ها اعمال شود را وارد کنید.', 'cardifa' ),
            ]
        );

        // پیش‌نمایش Transition
        $this->add_control(
            "{$id}_preview",
            [
                'label'        => __( 'پیش‌نمایش Transition', 'cardifa' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'فعال', 'cardifa' ),
                'label_off'    => __( 'غیرفعال', 'cardifa' ),
                'return_value' => 'yes',
                'default'      => 'no',
            ]
        );
    }
}
