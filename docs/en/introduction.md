# Introduction

[← English docs](./README.md)

Typhoon Iran Cities imports Iran's official administrative-division data into your Laravel application. One `composer require`, a handful of Artisan commands, and your database holds provinces through villages — with Eloquent models and relationships ready to use.

## What problem does it solve?

Building location pickers, address forms, shipping zones, or regional analytics for Iran usually means hunting down CSV files, normalizing codes, and wiring foreign keys by hand. This package ships curated data (based on [ahmadazizi/iran-cities](https://github.com/ahmadazizi/iran-cities)), migrations, models, and an import pipeline so you can focus on product logic.

## Region levels

Iran's divisions form a tree:

```
Province (استان)
 └── County (شهرستان)
      └── Sector (بخش)
           ├── City (شهر)
           │    └── City district (منطقه شهری)
           └── Rural district (دهستان)
                └── Village (آبادی)
```

![Administrative divisions](../images/administrative_divisions_of_Iran.jpg)

## Key features

| Feature | Description |
|---------|-------------|
| **Complete hierarchy** | All seven administrative levels with official codes |
| **Two storage strategies** | Separate tables per level, or one unified `iran_regions` table |
| **Selective import** | Import only what you need (`--target=cities`, etc.) |
| **Published artifacts** | Migrations and models copy into your app — you own the schema |
| **Eloquent helpers** | Query scopes, parent/child relations, status management |
| **City coordinates** | Optional latitude/longitude for cities |
| **Re-import support** | `--fresh` truncates and reloads when source data updates |

## What this package is not

- A geocoding or mapping SDK (coordinates are pre-baked CSV data for cities only)
- A REST API — you query models directly or build your own endpoints
- A replacement for Iran's official gazetteer — it mirrors a community-maintained dataset

## Package dependency note

**Published models** extend classes from `SaliBhdr\TyphoonIranCities\Models\*`. You **must keep this package installed** after running `iran:publish:models`. Removing the package breaks your application.

**Published migrations** are self-contained and do not reference the package namespace — they remain valid even if you later customize them.

## Next steps

- [Requirements & versioning](./requirements-and-versioning.md) — pick the right package version for your Laravel app
- [Quick start](./quick-start.md) — install and import in a few commands
