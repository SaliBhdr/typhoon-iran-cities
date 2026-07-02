# مرجع دستورات

[← مستندات فارسی](./README.md)

گزینه‌های مشترک (در صورت وجود):

| گزینه | توضیح |
|-------|--------|
| `--unite` | ذخیره در `iran_regions` |
| `--target=<level>` | محدود کردن سطوح (پیش‌فرض: `all`) |
| `--with-city-coordinates` | عرض و طول جغرافیایی شهرها |

---

## `iran:init`

**کاربرد:** راهنمای گام‌به‌گام — انتشار مهاجرت، انتشار مدل، migrate، درون‌ریزی.

```sh
php artisan iran:init [options]
```

| گزینه | توضیح |
|-------|--------|
| `--force` | بازنویسی فایل موجود |
| `--unite` | حالت یکپارچه |
| `--target=all` | سطوح هدف |
| `--with-city-coordinates` | مهاجرت و درون‌ریزی مختصات |
| `--no-interaction` | بله به همه پرسش‌ها (CI) |

### مثال‌ها

```sh
php artisan iran:init
php artisan iran:init --no-interaction --force --target=cities
php artisan iran:init --no-interaction --force --unite --with-city-coordinates
```

---

## `iran:publish:migrations`

```sh
php artisan iran:publish:migrations [options]
```

| گزینه | توضیح |
|-------|--------|
| `--force` | بازنویسی |
| `--unite` | `create_iran_regions_table` |
| `--target=all` | فقط مهاجرت‌های لازم |
| `--with-city-coordinates` | مهاجرت مختصات |

```sh
php artisan iran:publish:migrations --target=cities --with-city-coordinates
php artisan migrate
```

---

## `iran:publish:models`

```sh
php artisan iran:publish:models [options]
```

| گزینه | توضیح |
|-------|--------|
| `--force` | بازنویسی |
| `--unite` | فقط `IranRegion` |
| `--target=all` | مدل‌های متناسب با هدف |

> مدل منتشرشده به پکیج وابسته است — پکیج را حذف نکنید.

---

## `iran:import`

```sh
php artisan iran:import [options]
```

| گزینه | توضیح |
|-------|--------|
| `--unite` | درون‌ریزی به `iran_regions` |
| `--target=all` | سطوح هدف |
| `--with-city-coordinates` | به‌روزرسانی عرض و طول |
| `--fresh` | خالی‌کردن جدول قبل از درون‌ریزی |

### نکات

- محدودیت حافظه و زمان پی‌اچ‌پی برداشته می‌شود (در صورت اجازه سرور)
- هر فایل در یک تراکنش
- **بررسی پیش از اجرا:** اگر جدول نباشد خطای واضح — اول `migrate`
- روی هاست اشتراکی از خط فرمان اجرا کنید

---

## مقادیر `--target`

`all`, `provinces`, `counties`, `sectors`, `cities`, `city_districts`, `rural_districts`, `villages`

---

## جریان‌های کاری معمول

### استقرار (CI)

```sh
composer install --no-dev --optimize-autoloader
php artisan iran:publish:migrations --no-interaction --force --target=cities
php artisan iran:publish:models --no-interaction --force --target=cities
php artisan migrate --force
php artisan iran:import --target=cities --no-interaction
```

### به‌روزرسانی محلی

```sh
php artisan iran:import --fresh --target=all
```

## گام بعد

- [مختصات شهرها](./city-coordinates.md)
- [سوالات متداول](./faq-and-troubleshooting.md)
