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
 * @package         Cardifa\Services
 */

namespace Cardifa\Services;

defined('ABSPATH') || exit;

class HookManager
{
    /**
     * آرایه‌ی هوک‌ها (actions & filters)
     *
     * @var array
     */
    private $actions = [];

    /**
     * ثبت یک اکشن
     *
     * @param string   $hook
     * @param callable $callback
     * @param int      $priority
     * @param int      $accepted_args
     * @since 1.0.0
     */
    public function add_action(string $hook, callable $callback, int $priority = 10, int $accepted_args = 1): void
    {
        $this->actions[] = compact('hook', 'callback', 'priority', 'accepted_args');
    }

    /**
     * اجرای تمامی اکشن‌ها
     *
     * @since 1.0.0
     */
    public function run(): void
    {
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
