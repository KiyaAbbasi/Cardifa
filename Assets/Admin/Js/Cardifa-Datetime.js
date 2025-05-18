/**
 * File: Cardifa-Datetime.js
 * Desc: ساعت زنده با اعداد فارسی برای پنل تنظیمات Cardifa
 * Author: Kiya Holding
 * Since: 1.0.0
 */

/**
 * 🔢 تبدیل اعداد انگلیسی به فارسی
 */
function toPersianDigits(str) {
  const en = '0123456789';
  const fa = '۰۱۲۳۴۵۶۷۸۹';
  return str.replace(/\d/g, d => fa[d]);
}

/**
 * 🕒 آپدیت زنده ساعت و جایگذاری در DOM
 */
function updateClock() {
  const now = new Date();
  const hh = String(now.getHours()).padStart(2, "0");
  const mm = String(now.getMinutes()).padStart(2, "0");
  const ss = String(now.getSeconds()).padStart(2, "0");
  const time = `${hh}:${mm}:${ss}`;
  const el = document.getElementById("cardifa-live-clock");
  if (el) el.textContent = toPersianDigits(time);
}

updateClock();
setInterval(updateClock, 1000);
