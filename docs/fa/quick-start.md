# شروع سریع

[← مستندات فارسی](./README.md)

از اپ لاراول تازه تا داده درون‌ریزی‌شده در کمترین گام.

## پیش‌نیاز

- لاراول و پی‌اچ‌پی مطابق [نیازمندی‌ها](./requirements-and-versioning.md)
- دیتابیس در `.env`
- `composer require salibhdr/typhoon-iran-cities`

## مسیر A — راه‌اندازی کامل (همه سطوح، جداول مجزا)

```sh
php artisan iran:init

# یا غیرتعاملی:
php artisan iran:init --no-interaction --force
```

مراحل: انتشار مهاجرت → انتشار مدل → migrate → درون‌ریزی

تأیید:

```php
use App\Models\IranProvince;

IranProvince::count(); // 31
```

## مسیر B — فقط شهرها

```sh
php artisan iran:init --no-interaction --force --target=cities
php artisan migrate --no-interaction
```

مدل‌ها: `IranProvince`, `IranCounty`, `IranSector`, `IranCity`

## مسیر C — جدول واحد (حالت یکپارچه)

```sh
php artisan iran:init --no-interaction --force --unite
php artisan migrate --no-interaction
```

مدل `IranRegion` — جزئیات در [حالت‌های ذخیره‌سازی](./storage-modes.md).

## مسیر C + مختصات شهر

```sh
php artisan iran:init \
  --no-interaction --force \
  --target=cities \
  --with-city-coordinates
```

## گام‌به‌گام دستی

```sh
php artisan iran:publish:migrations --target=all
php artisan iran:publish:models --target=all
php artisan migrate
php artisan iran:import
```

## درون‌ریزی مجدد بعد از به‌روزرسانی داده

```sh
php artisan iran:import --fresh
```

## مرجع گزینه‌های رایج

| گزینه | مقادیر | پیش‌فرض | کاربرد |
|-------|--------|---------|--------|
| `--target` | `all`, `provinces`, `counties`, ... | `all` | محدود کردن سطوح |
| `--unite` | — | خاموش | جدول واحد `iran_regions` |
| `--with-city-coordinates` | — | خاموش | عرض و طول جغرافیایی شهرها |
| `--force` | — | خاموش | بازنویسی فایل منتشرشده |
| `--fresh` | — | خاموش | خالی‌کردن جدول قبل از درون‌ریزی |
| `--no-interaction` | — | خاموش | بدون پرسش در `iran:init` |

## گام بعد

- [مرجع دستورات](./commands-reference.md)
- [مدل‌ها و روابط](./models-and-relationships.md)
