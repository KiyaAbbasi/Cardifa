<?php
/**
 * File Name:       HookManager.php
 * Description:     مدیریت تمام هوک‌های پلاگین (اکشن‌ها و فیلترها)
 * Since:           1.0.0
 * Last Modified:   2025-04-24 14:02
 * Author:          Kiya Holding
 * Author URI:      https://kiyaholding.com
 * License:         GPLv3 or later
 * License URI:     https://www.gnu.org/licenses/gpl-3.0.html
 * 
 * @package         Cardifa\Core\Services
 */

namespace Cardifa\Src\Services;

defined('ABSPATH') || exit;

/**
 * کلاس مدیریت هوک‌ها
 * این کلاس مسئول مدیریت تمام اکشن‌ها و فیلترهای پلاگین است
 *
 * @since      1.0.0
 * @package    Cardifa\Core\Services
 * @author     Kiya Holding
 */
class HookManager {
    /**
     * @var array لیست اکشن‌های ثبت شده
     */
    private $actions = [];

    /**
     * @var array لیست فیلترهای ثبت شده
     */
    private $filters = [];

    /**
     * ثبت یک اکشن جدید
     *
     * @param string   $hook          نام هوک
     * @param callable $callback      تابع callback
     * @param int      $priority      اولویت
     * @param int      $accepted_args تعداد آرگومان‌های قابل قبول
     * @since 1.0.0
     */
    public function add_action($hook, $callback, $priority = 10, $accepted_args = 1) {
        $this->actions = $this->add($this->actions, $hook, $callback, $priority, $accepted_args);
    }

    /**
     * ثبت یک فیلتر جدید
     *
     * @param string   $hook          نام هوک
     * @param callable $callback      تابع callback
     * @param int      $priority      اولویت
     * @param int      $accepted_args تعداد آرگومان‌های قابل قبول
     * @since 1.0.0
     */
    public function add_filter($hook, $callback, $priority = 10, $accepted_args = 1) {
        $this->filters = $this->add($this->filters, $hook, $callback, $priority, $accepted_args);
    }

    /**
     * اضافه کردن هوک به آرایه
     *
     * @param array    $hooks         آرایه هوک‌ها
     * @param string   $hook          نام هوک
     * @param callable $callback      تابع callback
     * @param int      $priority      اولویت
     * @param int      $accepted_args تعداد آرگومان‌های قابل قبول
     * @return array
     * @since 1.0.0
     */
    private function add($hooks, $hook, $callback, $priority, $accepted_args) {
        $hooks[] = [
            'hook'          => $hook,
            'callback'      => $callback,
            'priority'      => $priority,
            'accepted_args' => $accepted_args
        ];
        return $hooks;
    }

    /**
     * ثبت تمام هوک‌ها
     *
     * @since 1.0.0
     */
    public function run() {
        foreach ($this->filters as $hook) {
            add_filter(
                $hook['hook'],
                $hook['callback'],
                $hook['priority'],
                $hook['accepted_args']
            );
        }

        foreach ($this->actions as $hook) {
            add_action(
                $hook['hook'],
                $hook['callback'],
                $hook['priority'],
                $hook['accepted_args']
            );
        }
    }
}
