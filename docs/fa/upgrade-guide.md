# راهنمای ارتقا

[← مستندات فارسی](./README.md)

مراحل مهاجرت بین نسخه‌های اصلی. ابتدا در **محیط آزمایشی** و با **پشتیبان دیتابیس**.

---

## ارتقا به آخرین (Laravel 13 / PHP 8.3+)

**از:** 3.1.x روی Laravel ≤ 12  
**به:** آخرین (`^4.0`)

### ۱. ارتقای اپ لاراول

[راهنمای Laravel 13](https://laravel.com/docs/upgrade) — PHP 8.3+.

### ۲. به‌روزرسانی پکیج

```sh
composer require salibhdr/typhoon-iran-cities:^4.0
```

### ۳. انتشار مجدد (توصیه)

```sh
php artisan iran:publish:migrations --force --target=all
php artisan iran:publish:models --force --target=all
```

تفاوت مهاجرت را قبل از migrate بررسی کنید.

### ۴. migrate

```sh
php artisan migrate
```

### ۵. درون‌ریزی در صورت تغییر CSV

```sh
php artisan iran:import --fresh --target=all
```

### تغییرات ناسازگار

| تغییر | اقدام |
|-------|--------|
| Laravel 13 + PHP 8.3 | اول اپ |
| `--fresh` | درون‌ریزی تمیز |
| بررسی پیش از درون‌ریزی | قبلش `migrate` |

---

## ارتقا از 2.x به 3.x

```sh
composer require salibhdr/typhoon-iran-cities:^3.1
```

با جداول مجزا و `--target=all` داده قبلی معتبر است.

**تغییر به حالت یکپارچه:** درجا نیست — پشتیبان، انتشار با `--unite`، migrate، درون‌ریزی.

**مختصات (3.1+):** [مختصات شهرها](./city-coordinates.md)

---

## ارتقا از 1.x به 2.x

```sh
composer require salibhdr/typhoon-iran-cities:^2.1
php artisan iran:publish:migrations --force
php artisan migrate
php artisan iran:publish:models --force
php artisan iran:import
```

جدول‌های جدید: بخش، منطقه شهری، دهستان، آبادی.

---

## ارتقا مستقیم 1.x به 3.x

ممکن است؛ مراحل 1→2 سپس 2→3. در محیط آزمایشی تست کنید.

---

## بازگشت به نسخه پایین‌تر

توصیه نمی‌شود. پشتیبان + ثابت‌کردن نسخه + انتشار مجدد.

---

## چک‌لیست

| گام | ✓ |
|-----|---|
| پشتیبان دیتابیس | ☐ |
| مطالعه جدول سازگاری | ☐ |
| ارتقای Laravel/PHP | ☐ |
| composer update | ☐ |
| انتشار با همان `--unite`/`--target` | ☐ |
| migrate | ☐ |
| درون‌ریزی `--fresh` در صورت نیاز | ☐ |
| تست اپ | ☐ |

## گام بعد

- [سوالات متداول](./faq-and-troubleshooting.md)
- [CHANGELOG](../../CHANGELOG.md)
