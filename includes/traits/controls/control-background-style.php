<?php
/**
 * 🎨 فایل: control-background-style.php
 * 🧩 تعریف استایل‌های کامل پس‌زمینه برای ویجت‌های کاردیفا
 * 📍 مسیر: includes/traits/controls/
 */

namespace Cardifa\Traits\Controls;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;

if (!defined('ABSPATH')) exit;

trait Control_Background_Style {

    /**
     * 📦 استایل کامل پس‌زمینه
     * @param string $name نام کنترل برای تفکیک
     * @param string $selector سلکتور المنتی که پس‌زمینه روی آن اعمال می‌شود
     * @param bool $important آیا استایل با !important اعمال شود؟
     */
    protected function register_background_style($name, $selector, $important = false) {
        $important_suffix = $important ? ' !important' : '';

        // 🎨 پس‌زمینه کلاسیک یا گرادینت
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => $name . '_background',
                'label'    => 'پس‌زمینه',
                'types'    => ['classic', 'gradient', 'video'],
                'selector' => '{{WRAPPER}} ' . $selector,
            ]
        );

        // 🌀 شفافیت پس‌زمینه
        $this->add_responsive_control(
            $name . '_bg_opacity',
            [
                'label'     => 'شفافیت پس‌زمینه',
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 1,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} ' . $selector => 'opacity: {{SIZE}}' . $important_suffix . ';',
                ],
            ]
        );

        // 📐 اندازه و موقعیت تصویر
        $this->add_control(
            $name . '_bg_position',
            [
                'label'   => 'موقعیت تصویر',
                'type'    => Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    ''              => 'پیش‌فرض',
                    'center center' => 'وسط-وسط',
                    'top center'    => 'بالا-وسط',
                    'bottom center' => 'پایین-وسط',
                    'left center'   => 'چپ-وسط',
                    'right center'  => 'راست-وسط',
                ],
                'selectors' => [
                    '{{WRAPPER}} ' . $selector => 'background-position: {{VALUE}}' . $important_suffix . ';',
                ],
                'condition' => [
                    $name . '_background_background' => ['classic', 'gradient'],
                ],
            ]
        );

        $this->add_control(
            $name . '_bg_size',
            [
                'label'   => 'اندازه تصویر',
                'type'    => Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    ''         => 'پیش‌فرض',
                    'auto'     => 'Auto',
                    'cover'    => 'Cover',
                    'contain'  => 'Contain',
                ],
                'selectors' => [
                    '{{WRAPPER}} ' . $selector => 'background-size: {{VALUE}}' . $important_suffix . ';',
                ],
                'condition' => [
                    $name . '_background_background' => ['classic', 'gradient'],
                ],
            ]
        );

        $this->add_control(
            $name . '_bg_repeat',
            [
                'label'   => 'تکرار تصویر',
                'type'    => Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    ''       => 'پیش‌فرض',
                    'no-repeat' => 'بدون تکرار',
                    'repeat'    => 'تکرار کامل',
                    'repeat-x'  => 'تکرار افقی',
                    'repeat-y'  => 'تکرار عمودی',
                ],
                'selectors' => [
                    '{{WRAPPER}} ' . $selector => 'background-repeat: {{VALUE}}' . $important_suffix . ';',
                ],
                'condition' => [
                    $name . '_background_background' => ['classic', 'gradient'],
                ],
            ]
        );

        $this->add_control(
            $name . '_bg_attachment',
            [
                'label'   => 'نوع اسکرول',
                'type'    => Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    ''        => 'پیش‌فرض',
                    'scroll'  => 'عادی',
                    'fixed'   => 'ثابت',
                ],
                'selectors' => [
                    '{{WRAPPER}} ' . $selector => 'background-attachment: {{VALUE}}' . $important_suffix . ';',
                ],
                'condition' => [
                    $name . '_background_background' => ['classic', 'gradient'],
                ],
            ]
        );

        $this->add_control(
            $name . '_bg_hover_note',
            [
                'type' => Controls_Manager::RAW_HTML,
                'raw'  => '<small>🎥 در صورتی که پس‌زمینه ویدیو فعال شود، موقعیت و تنظیمات تصویری نادیده گرفته می‌شود.</small>',
                'content_classes' => 'elementor-control-field-description',
                'condition' => [
                    $name . '_background_background' => 'video',
                ],
            ]
        );
    }
}
