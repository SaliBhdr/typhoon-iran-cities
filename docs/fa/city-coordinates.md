# مختصات شهرها

[← مستندات فارسی](./README.md)

از نسخه **3.1**. عرض و طول جغرافیایی شهرها از CSV.

## نیازمندی

- پکیج **3.1+**
- هدف شامل شهر: `all`, `cities`, `city_districts`

## فعال‌سازی

### جداول مجزا

```sh
php artisan iran:publish:migrations --target=cities --with-city-coordinates
php artisan migrate
php artisan iran:import --target=cities --with-city-coordinates
```

ستون‌های `latitude` و `longitude` روی `iran_cities`.

### حالت یکپارچه

```sh
php artisan iran:publish:migrations --unite --target=cities --with-city-coordinates
php artisan migrate
php artisan iran:import --unite --target=cities --with-city-coordinates
```

### یک‌جا با init

```sh
php artisan iran:init --no-interaction --force \
  --target=cities \
  --with-city-coordinates
```

## پرس‌وجو

```php
$city = IranCity::whereNotNull('latitude')->first();
[$city->latitude, $city->longitude];
```

## افزودن به نصب موجود

```sh
php artisan iran:publish:migrations --target=cities --with-city-coordinates --force
php artisan migrate
php artisan iran:import --target=cities --with-city-coordinates
```

## محدودیت‌ها

- فقط **شهرها**
- داده CSV — کدگذاری جغرافیایی زنده نیست
- دقت وابسته به [iran-cities](https://github.com/ahmadazizi/iran-cities)

## گام بعد

- [مرجع دستورات](./commands-reference.md)
