<?php
/**
 * File: ConditionalLogicTrait.php
 * Path: src/Elementor/Traits/
 * Description:
 *   مدیریت منطق شرطی شامل:
 *   • نمایش یا مخفی کردن المان‌ها بر اساس شرایط دلخواه.
 *   • پشتیبانی از چندین شرط همزمان.
 *   • واکنش‌گرایی کامل.
 * Author: Kiya Holding
 */

namespace Cardifa\Elementor\Traits;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // جلوگیری از دسترسی مستقیم

trait ConditionalLogicTrait {

    /**
     * ثبت تنظیمات منطق شرطی
     *
     * @param string $id شناسه کنترل
     * @param string $selector سلکتور CSS برای اعمال استایل‌ها
     */
    protected function register_conditional_logic_controls(
        string $id = 'conditional_logic',
        string $selector = '{{WRAPPER}} .cardifa-conditional'
    ) {
        // فعال‌سازی منطق شرطی
        $this->add_control(
            "{$id}_enable",
            [
                'label'        => __( 'فعال‌سازی منطق شرطی', 'cardifa' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'فعال', 'cardifa' ),
                'label_off'    => __( 'غیرفعال', 'cardifa' ),
                'return_value' => 'yes',
                'default'      => 'no',
            ]
        );

        // شرط‌های دلخواه
        $this->add_control(
            "{$id}_conditions",
            [
                'label'       => __( 'شرایط', 'cardifa' ),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => [
                    [
                        'name'        => 'key',
                        'label'       => __( 'کلید شرط', 'cardifa' ),
                        'type'        => Controls_Manager::TEXT,
                        'placeholder' => __( 'مثال: user_role', 'cardifa' ),
                    ],
                    [
                        'name'        => 'operator',
                        'label'       => __( 'عملگر', 'cardifa' ),
                        'type'        => Controls_Manager::SELECT,
                        'options'     => [
                            '=='  => __( 'برابر است با', 'cardifa' ),
                            '!='  => __( 'برابر نیست با', 'cardifa' ),
                            '>'   => __( 'بزرگتر از', 'cardifa' ),
                            '<'   => __( 'کوچکتر از', 'cardifa' ),
                        ],
                        'default'     => '==',
                    ],
                    [
                        'name'        => 'value',
                        'label'       => __( 'مقدار', 'cardifa' ),
                        'type'        => Controls_Manager::TEXT,
                        'placeholder' => __( 'مثال: admin', 'cardifa' ),
                    ],
                ],
                'title_field' => '{{{ key }}} {{{ operator }}} {{{ value }}}',
                'condition'   => [
                    "{$id}_enable" => 'yes',
                ],
            ]
        );

        // اعمال شرایط
        $this->add_control(
            "{$id}_apply",
            [
                'label'        => __( 'اعمال شرایط', 'cardifa' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'فعال', 'cardifa' ),
                'label_off'    => __( 'غیرفعال', 'cardifa' ),
                'return_value' => 'yes',
                'default'      => 'yes',
                'selectors'    => [
                    $selector => 'display: none;',
                ],
                'condition'    => [
                    "{$id}_enable" => 'yes',
                ],
            ]
        );
    }
}
