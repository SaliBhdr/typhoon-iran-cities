# نصب

[← مستندات فارسی](./README.md)

## ۱. بررسی سازگاری

قبل از نصب، [جدول سازگاری](./requirements-and-versioning.md) را با نسخه لاراول و پی‌اچ‌پی خود تطبیق دهید.

## ۲. نصب با کامپوزر

```sh
composer require salibhdr/typhoon-iran-cities
```

برای ماندن روی خط نسخه اصلی مشخص:

```sh
# Laravel 11/12
composer require salibhdr/typhoon-iran-cities:^3.1

# Laravel 13+
composer require salibhdr/typhoon-iran-cities
```

## ۳. تأیید دستورات Artisan

```sh
php artisan list iran
```

| دستور | کاربرد |
|-------|--------|
| `iran:init` | راه‌اندازی تعاملی |
| `iran:publish:migrations` | کپی مهاجرت به `database/migrations` |
| `iran:publish:models` | کپی مدل به `app/Models` |
| `iran:import` | درون‌ریزی داده CSV |

## ۴. ارائه‌دهنده سرویس (لاراول قدیمی)

Laravel 5.5+ خودکار کشف می‌کند. برای اپ قدیمی با پکیج ≤ 3.1:

```php
// config/app.php
'providers' => [
    SaliBhdr\TyphoonIranCities\IranCitiesServiceProvider::class,
],
```

## ۵. اتصال دیتابیس

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

## ۶. انتشار و مهاجرت

**تعاملی (اولین بار)**

```sh
php artisan iran:init
```

**غیرتعاملی (CI)**

```sh
php artisan iran:init --no-interaction --force
php artisan migrate --no-interaction
```

جزئیات در [شروع سریع](./quick-start.md).

## وابستگی بعد از انتشار مدل

مدل‌های `app/Models` از کلاس پایه پکیج ارث می‌برند. **`salibhdr/typhoon-iran-cities` را حذف نکنید.**

مهاجرت‌های منتشرشده مستقل هستند و قابل ویرایش.

## گام بعد

- [شروع سریع](./quick-start.md)
- [حالت‌های ذخیره‌سازی](./storage-modes.md)
