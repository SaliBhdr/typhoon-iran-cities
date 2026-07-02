# فیلد وضعیت

[← مستندات فارسی](./README.md)

ستون `status` از نوع boolean:

| مقدار | معنی |
|-------|------|
| `1` | فعال |
| `0` | غیرفعال |

برای غیرفعال کردن نرم در رابط کاربری بدون حذف ردیف.

## پرس‌وجوی فعال

```php
use App\Models\IranProvince;
use App\Models\IranCity;

IranProvince::active()->get();
IranCity::active()->where('county_id', 1)->get();
```

## فعال و غیرفعال کردن

```php
$county = IranCounty::find(1);
$county->deactivate(); // فقط این ردیف
$county->activate();
```

### مهم: آبشاری روی فرزندان نیست

`deactivate()` **فقط ردیف فعلی** را تغییر می‌دهد. فرزندان مقدار `status` خود را حفظ می‌کنند.

سلسله‌مراتب از **محدوده** اعمال می‌شود:

- `active()` و `notActive()` والدها را با `whereHas` بررسی می‌کنند
- فرزند با `status=1` وقتی والد غیرفعال است **پنهان** می‌شود
- `isActive()` زنجیره والد را بالا می‌رود

## مثال — غیرفعال کردن استان

```php
$province = IranProvince::active()->find(1);
$province->deactivate();

IranCity::active()->find(1); // null

$city = IranCity::find(1);
$city->status;     // ممکن است هنوز 1
$city->isActive(); // false
```

## وضعیت در برابر حذف

| روش | کاربرد |
|-----|--------|
| `deactivate()` | مخفی موقت در فرم و رابط |
| `active()` | همه پرس‌وجوهای عمومی |
| حذف ردیف | تقریباً هرگز — کلید خارجی و کد رسمی |

## گام بعد

- [مدل‌ها و روابط](./models-and-relationships.md)
