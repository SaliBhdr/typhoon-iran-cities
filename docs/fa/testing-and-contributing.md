# تست و مشارکت

[← مستندات فارسی](./README.md)

## اجرای تست

```sh
composer install
composer test
```

### پوشش کد (PCOV)

```sh
composer test:coverage
```

CI روی هر push/PR — گزارش در [Codecov](https://codecov.io/gh/SaliBhdr/typhoon-iran-cities).

## ساختار تست

| مسیر | کاربرد |
|------|--------|
| `tests/Feature/` | دستورات Artisan، درون‌ریزی |
| `tests/Unit/` | مدل، شمارشی‌ها، کلاس‌های پشتیبان |
| `tests/fixtures/` | CSV نمونه |
| `tests/Concerns/` | کمک‌کننده مشترک |

## مشارکت

1. انشعاب (Fork) از مخزن
2. شاخه از `master`/`main`
3. تست برای تغییر رفتار
4. `composer test`
5. درخواست ادغام

### مستندات

- انگلیسی: `docs/en/`
- فارسی: `docs/fa/`
- تغییرات مربوط به کاربر در `CHANGELOG.md`

## مجوز

MIT — [LICENSE](../../LICENSE).

[Salar Bahador](https://github.com/SaliBhdr).

## منبع داده

[ahmadazizi/iran-cities](https://github.com/ahmadazizi/iran-cities) v3.

## گام بعد

- [مرکز مستندات](../README.md)
