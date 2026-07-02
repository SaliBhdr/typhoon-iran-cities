# مدل‌ها و روابط

[← مستندات فارسی](./README.md)

بعد از `iran:publish:models`، مدل‌ها در `app/Models/` هستند و از `BaseIranModel` متدهای کمکی مشترک دارند.

## متدهای مشترک

| متد | نوع | توضیح |
|-----|-----|--------|
| `getAll()` | ایستا | همه رکوردها |
| `getAllActive()` | ایستا | فعال‌ها |
| `getAllNotActive()` | ایستا | غیرفعال‌ها |
| `active()` | محدوده | فیلتر فعال (با در نظر سلسله‌مراتب) |
| `notActive()` | محدوده | غیرفعال |
| `activate()` / `deactivate()` | نمونه | تغییر `status` |
| `isActive()` / `isNotActive()` | نمونه | بررسی با والدها |

```php
use App\Models\IranCity;

$city = IranCity::find(1);
$city->county;
$city->getCounty();
```

## ستون‌های ساختار

| ستون | نوع | توضیح |
|------|-----|--------|
| `id` | int | کلید |
| `name` | string | نام فارسی |
| `code` | string | کد یکتا |
| `short_code` | string | کد کوتاه |
| `status` | boolean | 1 فعال، 0 غیرفعال |

---

## یکپارچه — `IranRegion`

`parent()`, `children()`, `province()`, `county()`, `sector()`, `city()`, `ruralDistrict()` و انواع `*Children()`.

```php
IranRegion::where('type', 'city')->active()->get();
```

---

## مجزا — `IranProvince`

`counties()`, `sectors()`, `cities()`, ... و `getCounties()`, `getActiveCounties()`, ...

---

## مجزا — `IranCounty`

`province()`, `sectors()`, `cities()`, ... و متدهای کمکی

---

## مجزا — `IranSector`

`province()`, `county()`, `cities()`, `cityDistricts()`, `ruralDistricts()`, `villages()`

---

## مجزا — `IranCity`

`province()`, `county()`, `sector()`, `cityDistricts()`

با مختصات: `latitude`, `longitude`

---

## مجزا — `IranCityDistrict`

`province()`, `county()`, `sector()`, `city()`

---

## مجزا — `IranRuralDistrict`

`province()`, `county()`, `sector()`, `villages()`

---

## مجزا — `IranVillage`

`province()`, `county()`, `sector()`, `ruralDistrict()`

---

## سفارشی‌سازی

```php
namespace App\Models;

use SaliBhdr\TyphoonIranCities\Models\IranCity as BaseIranCity;

class IranCity extends BaseIranCity
{
    // محدوده یا دسترسی‌ساز مخصوص اپ
}
```

## گام بعد

- [فیلد وضعیت](./status-field.md)
- [مختصات شهرها](./city-coordinates.md)
