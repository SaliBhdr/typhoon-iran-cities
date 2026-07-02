# سوالات متداول و رفع اشکال

[← مستندات فارسی](./README.md)

## نصب

### دستورات پیدا نمی‌شوند

```sh
composer dump-autoload
php artisan package:discover
php artisan list iran
```

Laravel &lt; 5.5: ثبت دستی ارائه‌دهنده — [نصب](./installation.md).

### تعارض نسخه PHP

آخرین پکیج PHP 8.3+ می‌خواهد. تا ارتقا:

```json
"salibhdr/typhoon-iran-cities": "^3.1"
```

---

## درون‌ریزی

### «جدول وجود ندارد»

```sh
php artisan migrate
php artisan iran:import --target=cities
```

همان `--unite` و `--target` در انتشار و درون‌ریزی.

### پایان زمان روی هاست اشتراکی

- از SSH/خط فرمان اجرا کنید
- `--target=cities` به‌جای `all`
- افزایش محدودیت از میزبان

### درون‌ریزی مجدد داده جدید نشان نمی‌دهد

```sh
php artisan iran:import --fresh
```

---

## انتشار

### فایل از قبل وجود دارد

```sh
php artisan iran:publish:migrations --force
php artisan iran:publish:models --force
```

### حذف پکیج بعد از انتشار مدل؟

**خیر.** مدل‌ها به فضای نام پکیج وابسته‌اند.

---

## استفاده

### `active()` شهر کمتر از انتظار

والد (استان/شهرستان/بخش) غیرفعال است — [فیلد وضعیت](./status-field.md).

### یکپارچه در برابر مجزا — مدل اشتباه

با [حالت ذخیره‌سازی](./storage-modes.md) تطبیق دهید.

### خطای کلید خارجی در migrate

هدف ناقص — والدها را شامل کنید یا `--target=all`.

---

## انتخاب نسخه

| Laravel | محدودیت |
|---------|---------|
| 13+ | آخرین / `^4.0` |
| 11–12 | `^3.1` |
| 8 (قدیمی) | `^3.1` + تست در محیط آزمایشی |

---

## کمک

1. [گزارش اشکال](https://github.com/SaliBhdr/typhoon-iran-cities/issues)
2. نسخه پکیج، Laravel، PHP، دستور، خطای کامل

## گام بعد

- [راهنمای ارتقا](./upgrade-guide.md)
- [تست و مشارکت](./testing-and-contributing.md)
