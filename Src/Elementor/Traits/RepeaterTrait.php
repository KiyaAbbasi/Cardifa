<?php
/**
 * File: RepeaterTrait.php
 * Path: src/Elementor/Traits/
 * Description:
 *   افزودن کنترل Repeater با قابلیت‌های پیشرفته.
 * Author: Kiya Holding
 */

namespace Cardifa\Elementor\Traits;

use Elementor\Controls_Manager;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) exit; // جلوگیری از دسترسی مستقیم

trait RepeaterTrait {

    /**
     * ثبت کنترل Repeater
     *
     * @param string $id شناسه کنترل
     */
    protected function register_repeater_controls(string $id = 'repeater') {
        $repeater = new Repeater();

        // افزودن متن
        $repeater->add_control(
            "{$id}_text",
            [
                'label' => __( 'متن', 'cardifa' ),
                'type'  => Controls_Manager::TEXT,
                'default' => __( 'متن پیش‌فرض', 'cardifa' ),
            ]
        );

        // افزودن تصویر
        $repeater->add_control(
            "{$id}_image",
            [
                'label' => __( 'تصویر', 'cardifa' ),
                'type'  => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Controls_Manager::get_placeholder_image_src(),
                ],
            ]
        );

        return $repeater;
    }
}
