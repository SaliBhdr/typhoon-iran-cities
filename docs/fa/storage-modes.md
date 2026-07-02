# حالت‌های ذخیره‌سازی

[← مستندات فارسی](./README.md)

دو روش برای ذخیره داده وجود دارد. **قبل از انتشار مهاجرت** انتخاب کنید — تغییر بعداً به مهاجرت داده نیاز دارد.

## جداول مجزا (پیش‌فرض)

| سطح | جدول | مدل |
|-----|------|-----|
| استان | `iran_provinces` | `IranProvince` |
| شهرستان | `iran_counties` | `IranCounty` |
| بخش | `iran_sectors` | `IranSector` |
| شهر | `iran_cities` | `IranCity` |
| منطقه شهری | `iran_city_districts` | `IranCityDistrict` |
| دهستان | `iran_rural_districts` | `IranRuralDistrict` |
| آبادی | `iran_villages` | `IranVillage` |

### چه زمانی

- **اطمینان نوع** — `$city->county` مدل `IranCounty` برمی‌گرداند
- پرس‌وجو عمدتاً روی **یک سطح**
- کلیدهای خارجی نرمال (`province_id`, ...)
- آشنایی تیم با روابط کلاسیک لاراول

### مثال

```php
use App\Models\IranCity;

$city = IranCity::with('county.province')->find(1);
```

### دستور

```sh
php artisan iran:init --target=cities
# بدون --unite
```

## حالت یکپارچه (جدول واحد)

همه سطوح در `iran_regions` با ستون `type`.

| ستون | کاربرد |
|------|--------|
| `type` | `province`, `county`, ... |
| `parent_id` | والد مستقیم |
| `province_id` … | کلیدهای خارجی غیرنرمال‌شده |
| `name`, `code`, `short_code`, `status` | مشابه حالت مجزا |

مدل: **`IranRegion`**

### چه زمانی

- **رابط یکسان** برای همه انواع منطقه
- رابط کاربری درختی
- کمینه کردن تعداد جدول
- پرس‌وجوی چندسطحی شبیه چندریختی

### مثال

```php
use App\Models\IranRegion;

IranRegion::where('type', 'city')->active()->get();
```

### دستور

```sh
php artisan iran:init --unite --target=all
```

## مقایسه

| جنبه | جداول مجزا | یکپارچه |
|------|------------|---------|
| تعداد جدول | تا 7 | 1 |
| اطمینان نوع | قوی | فیلتر با `type` |
| `--target` | بله | بله |
| مختصات | ستون روی `iran_cities` | روی ردیف `type=city` |
| تغییر بعدی | انتقال داده لازم | انتقال داده لازم |

## تعامل `--target`

| `--target` | سطوح |
|------------|------|
| `provinces` | استان |
| `counties` | تا شهرستان |
| `sectors` | تا بخش |
| `cities` | تا شهر |
| `city_districts` | تا منطقه شهری |
| `rural_districts` | تا دهستان |
| `villages` | تا آبادی |
| `all` | همه |

هر هدف **والدهای لازم** را شامل می‌شود.

## گام بعد

- [مرجع دستورات](./commands-reference.md)
- [مدل‌ها و روابط](./models-and-relationships.md)
