# Status Field

[← English docs](./README.md)

Every region row has a `status` boolean column:

| Value | Meaning |
|-------|---------|
| `1` (true) | Active |
| `0` (false) | Inactive |

Use status to soft-disable regions in your UI without deleting rows.

## Querying active records

Always use the `active()` scope in user-facing queries:

```php
use App\Models\IranProvince;
use App\Models\IranCity;

$provinces = IranProvince::active()->get();
$cities = IranCity::active()->where('county_id', 1)->get();
```

`notActive()` returns the opposite.

Static helpers:

```php
IranProvince::getAllActive();
IranProvince::getAllNotActive();
```

## Activating and deactivating

```php
$county = IranCounty::find(1);

$county->deactivate(); // sets status = 0 on this row only
$county->activate();   // sets status = 1
```

### Important: no cascade to children

`deactivate()` updates **only the current record**. Child rows keep their own `status` value in the database.

Hierarchy is enforced through **query scopes**, not cascading updates:

- `active()` and `notActive()` scopes check the record **and all ancestors** via `whereHas`
- A child with `status = 1` is **hidden** when a parent is inactive
- `isActive()` walks up the parent chain and returns `false` if any ancestor is inactive

## Example — province deactivation

```php
use App\Models\IranProvince;
use App\Models\IranCity;

$province = IranProvince::active()->find(1);
$province->deactivate();

// Scoped query — city hidden because province is inactive
IranCity::active()->find(1); // null

// Raw find — row still exists
$city = IranCity::find(1);
$city->status;    // may still be 1
$city->isActive(); // false — province is inactive
```

## When to use status vs. delete

| Approach | Use when |
|----------|----------|
| `deactivate()` | Temporarily hide a region in forms and APIs |
| `active()` scope | All public-facing queries |
| Delete row | Almost never — breaks FK integrity and official codes |

## Unite mode

The same rules apply to `IranRegion`. The `active()` scope walks `parent()` and typed ancestor relations depending on the model configuration.

## Next steps

- [Models & relationships](./models-and-relationships.md)
- [FAQ & troubleshooting](./faq-and-troubleshooting.md)
