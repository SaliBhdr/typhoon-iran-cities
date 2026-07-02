# Models & Relationships

[← English docs](./README.md)

After `iran:publish:models`, models live in `app/Models/` and extend package base classes. All models inherit common helpers from `BaseIranModel`.

## Common methods (all models)

| Method | Type | Description |
|--------|------|-------------|
| `getAll()` | static | All records ordered by `id` |
| `getAllActive()` | static | All records matching `active()` scope |
| `getAllNotActive()` | static | All records matching `notActive()` scope |
| `active()` | scope | Filter active records (respects hierarchy — see [Status field](./status-field.md)) |
| `notActive()` | scope | Filter inactive records |
| `activate()` | instance | Set `status = 1` on this record |
| `deactivate()` | instance | Set `status = 0` on this record |
| `isActive()` | instance | `true` if record and all ancestors are active |
| `isNotActive()` | instance | Inverse of `isActive()` |

### Example

```php
use App\Models\IranCity;

$cities = IranCity::getAllActive();
$city = IranCity::find(1);

$county = $city->county;       // BelongsTo relation
$county = $city->getCounty();  // Helper wrapper
```

## Schema columns

All region tables share these columns (unite mode adds `type` and hierarchy FKs):

| Column | Type | Description |
|--------|------|-------------|
| `id` | int | Primary key |
| `name` | string | Persian name |
| `code` | string | Unique official code |
| `short_code` | string | Abbreviated code |
| `status` | boolean | `1` = active, `0` = inactive |

Separate-mode tables add FK columns (`province_id`, `county_id`, etc.) appropriate to their level.

---

## Unite mode — `IranRegion`

| Method | Description |
|--------|-------------|
| `parent()` | Direct parent (`belongsTo`) |
| `children()` | Direct children (`hasMany`) |
| `province()` | Province ancestor |
| `provinceChildren()` | Children when this row is a province |
| `county()` / `countyChildren()` | County-level relations |
| `sector()` / `sectorChildren()` | Sector-level relations |
| `city()` / `cityChildren()` | City-level relations |
| `ruralDistrict()` / `ruralDistrictChildren()` | Rural-district relations |

Filter by type:

```php
IranRegion::where('type', 'city')->active()->get();
```

---

## Separate mode — `IranProvince`

| Method | Description |
|--------|-------------|
| `counties()`, `sectors()`, `cities()`, … | `hasMany` to descendant levels |
| `getCounties()`, `getActiveCounties()`, … | Collection helpers for each level |

---

## Separate mode — `IranCounty`

| Method | Description |
|--------|-------------|
| `province()` | Parent province |
| `sectors()`, `cities()`, … | Descendants |
| `getProvince()`, `getSectors()`, … | Helpers |

---

## Separate mode — `IranSector`

| Method | Description |
|--------|-------------|
| `province()`, `county()` | Ancestors |
| `cities()`, `cityDistricts()`, `ruralDistricts()`, `villages()` | Descendants |

---

## Separate mode — `IranCity`

| Method | Description |
|--------|-------------|
| `province()`, `county()`, `sector()` | Ancestors |
| `cityDistricts()` | City districts in this city |
| `getProvince()`, `getCounty()`, `getSector()` | Helpers |

With coordinates enabled, cities also have `latitude` and `longitude` columns.

---

## Separate mode — `IranCityDistrict`

| Method | Description |
|--------|-------------|
| `province()`, `county()`, `sector()`, `city()` | Full ancestor chain |

---

## Separate mode — `IranRuralDistrict`

| Method | Description |
|--------|-------------|
| `province()`, `county()`, `sector()` | Ancestors |
| `villages()` | Villages in this rural district |

---

## Separate mode — `IranVillage`

| Method | Description |
|--------|-------------|
| `province()`, `county()`, `sector()`, `ruralDistrict()` | Full ancestor chain |

---

## Customizing published models

Published models are yours to edit. Common customizations:

```php
// app/Models/IranCity.php
namespace App\Models;

use SaliBhdr\TyphoonIranCities\Models\IranCity as BaseIranCity;

class IranCity extends BaseIranCity
{
    // Add app-specific scopes, accessors, or interfaces
}
```

Do not remove the package dependency — base classes live in the package namespace.

## Next steps

- [Status field](./status-field.md)
- [City coordinates](./city-coordinates.md)
