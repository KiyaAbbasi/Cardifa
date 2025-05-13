<?php
/**
 * File: DatetimeHelper.php
 * Desc: توابع کمکی تاریخ شمسی و تبدیل اعداد برای پنل Cardifa
 * Author: Kiya Holding
 * Since: 1.0.0
 */

defined('ABSPATH') || exit;

if (!function_exists('cardifa_get_shamsi_datetime_parts')) {
    /**
     * خروجی: آرایه شامل [weekday, day, month, year] با اعداد فارسی
     */
    function cardifa_get_shamsi_datetime_parts(): array
    {
        $timestamp = time();
        list($gy, $gm, $gd) = explode('-', date('Y-m-d', $timestamp));
        $gy = (int)$gy; $gm = (int)$gm; $gd = (int)$gd;

        $g_d_m = [0,31,59,90,120,151,181,212,243,273,304,334];
        $gy2 = ($gm > 2) ? ($gy + 1) : $gy;
        $days = 355666 + (365 * $gy) + (int)(($gy2 + 3) / 4) - (int)(($gy2 + 99) / 100) + (int)(($gy2 + 399) / 400) + $gd + $g_d_m[$gm - 1];

        $jy = -1595 + (33 * (int)($days / 12053));
        $days %= 12053;

        $jy += 4 * (int)($days / 1461);
        $days %= 1461;

        if ($days > 365) {
            $jy += (int)(($days - 1) / 365);
            $days = ($days - 1) % 365;
        }

        $jm_list = [31,31,31,31,31,31,30,30,30,30,30,29];
        for ($jm = 0; $jm < 12 && $days >= $jm_list[$jm]; $jm++)
            $days -= $jm_list[$jm];
        $jd = $days + 1;

        $jm = str_pad($jm + 1, 2, '0', STR_PAD_LEFT);
        $jd = str_pad($jd, 2, '0', STR_PAD_LEFT);
        $jy = str_pad($jy, 4, '0', STR_PAD_LEFT);

        $weekdays = ['شنبه','یکشنبه','دوشنبه','سه‌شنبه','چهارشنبه','پنجشنبه','جمعه'];
        $weekday_index = (date('w', $timestamp) + 1) % 7;
        $weekday = $weekdays[$weekday_index];

        return [
            'weekday' => cardifa_convert_to_persian_numbers($weekday),
            'day'     => cardifa_convert_to_persian_numbers($jd),
            'month'   => cardifa_convert_to_persian_numbers($jm),
            'year'    => cardifa_convert_to_persian_numbers($jy)
        ];
    }
}

if (!function_exists('cardifa_get_shamsi_date_for_display')) {
    /**
     * خروجی نهایی برای نمایش: "شنبه 1404/02/20"
     */
    function cardifa_get_shamsi_date_for_display(): string
    {
        $parts = cardifa_get_shamsi_datetime_parts();
        return "{$parts['weekday']} {$parts['year']}/{$parts['month']}/{$parts['day']}";
    }
}

if (!function_exists('cardifa_convert_to_persian_numbers')) {
    /**
     * تبدیل اعداد انگلیسی به فارسی
     */
    function cardifa_convert_to_persian_numbers(string $input): string
    {
        $en = ['0','1','2','3','4','5','6','7','8','9'];
        $fa = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'];
        return str_replace($en, $fa, $input);
    }
}
