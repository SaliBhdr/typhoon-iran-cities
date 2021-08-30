# Iran Regions such as Provinces, Counties, Cities, City Districts, Rural Districts and Villages

![SaliBhdr|typhoon][link-logo]

[![Total Downloads][ico-downloads]][link-downloads]
[![Required Laravel Version][ico-laravel]][link-packagist]
[![Required PHP Version][ico-php]][link-packagist]
[![Latest Versions][ico-version]][link-packagist]
[![License][ico-license]][link-packegist]
[![Today Downloads][ico-today-downloads]][link-downloads]

## Introduction

Typhoon Iran Cities is a Laravel package for importing all regions such as provinces, counties, sectors, cities, city districts, rural districts and villages of Iran into your database with just 
only one console command.

This is the most accurate Laravel package for administrative divisions of Iran without a doubt.

**Attention:** This package allows you to choose whether to use all regions in just one table
or divide them in their own separate table, Or even you can select the data that you want.

![Administrative Divisions and Regions of Iran](./docs/images/administrative_divisions_of_Iran.jpg)

**Features**
- All provinces of Iran (استان)
- All counties of Iran (شهرستان)
- All sectors of Iran (بخش)
- All cities of Iran (شهر)
- All city districts of Iran (مناطق شهری)
- All rural districts of Iran (دهستان)
- All villages of Iran (آبادی)
- Built-in models of provinces, counties, sectors, cities, city districts, rural districts and villages
- relational database between these tables
- Both all in one region table and separate tables
- Helper methods

## Installation

Install with composer:

```sh
 $ composer require salibhdr/typhoon-iran-cities
```

For Laravel < 5.5 Register the Service provider in your config/app.php configuration file:

```
'providers' => [

     # Other service providers...
     
     SaliBhdr\TyphoonIranCities\IranCitiesServiceProvider::class,
],
```

## Getting started

This package provides a number of commands for you to easily use them to import migrations,
models and data of your desired regions. 

Before that, you should pay attention to explanation of the 2 options used in the commands:

**`--unite` option:**

This package can be used in 2 separate strategies. 
Some programmers like to have each region in a separate table, 
and others like all regions to be in a single table. 

To do this, in the version 3 of this package, 
it is possible to choose one of these strategies depending on your taste.

If you want to have all regions in one table, you must use the `--unite` option in commands.

**`--target` option:**

The `--target` option allows you to select the regions that you want to use.

Suppose you just want to add **cities** to database, and you may not need villages or rural districts. 
All you have to do is set the `--target` value equal to the cities.

You can Select the target regions that you want to use from one
of these options : all, provinces, counties, sectors, cities, city_districts, rural_districts, villages

The default value of the `--target` option is set to all. So if you want all regions don't use this option.

## Usage

### Commands

Here are the list of all commands that are available:

```sh

  # init command that runs publish and import commands step by step (For ease of use)
  iran:init                    Copies models and migrations then imports data
  
  # publish commands
  iran:publish:migrations      Copies migrations into migrations directory
  iran:publish:models          Copies related models
    
  # import commands
  iran:import                  Imports all regions into the database (Can be selected by option)

```
#### Commands Explanations:

**The `iran:init` command:**

If you're using this package for the first time or somehow the migrations, models or data is deleted,
you can use this command to initialize all three. Under the hood, 
this command runs below commands step by step:

```sh

  iran:publish:migrations      Copies migrations into migrations directory
  iran:publish:models          Copies related models
  migrate                      For migrating new migrations of package
  iran:import                  Imports all regions into the database (Can be selected by option)

```

As mentioned before all commands have the `--unite` and the `--target` options.

Remember if you want all regions to be in one `regions` table Use `--unite` option.

In the following section, we examine both of these cases with the target of the city. 
Do not use this option if you want all regions.

- One `regions` Table :

```sh
  php artisan iran:init --unite --target=cities
```
This will publish `IranRegion` model, `create_iran_regions_table` migration and import data up to 
cities level into `iran_regions` table and will ignore city districts, 
rural districts and villages

- Separate tables :

```sh
  php artisan iran:init --target=cities
```

This will publish `IranProvince`,`IranCounty`,`IranSector` adn `IranCity` models, 
related migrations of these models and import data up to
cities level into separate tables and will ignore city districts, 
rural districts and villages

---
**The `iran:import` command:**

This command will only import data. remember to use the `--unite` and the `--target` options right based on your desired approach.

Check the `iran:init` section above to see the usage of these options.

Cities example:

- One `regions` Table :

```sh
  php artisan iran:import --unite --target=cities
```
This will import data up to cities level into `iran_regions` table
and will ignore city districts, rural districts and villages

- Separate tables :

```sh
  php artisan iran:import --target=cities
```

This will import data up to cities level into separate tables a
nd will ignore city districts, rural districts and villages

---
**The `iran:publish:migrations` command:**

This command will publish related migration files. 
remember to use the `--unite` and the `--target` options 
right based on your desired approach.

Check the `iran:init` section above to see the usage of these options.

You can use `--force` option to overwrite the existed files.

Cities example:

- One `regions` Table :

```sh
  php artisan iran:publish:migrations --unite --target=cities
```

This will publish `create_iran_regions_table` migration file.

- Separate tables :

```sh
  php artisan iran:import --target=cities
```

This will publish related migration files up to cities level.

---
**The `iran:publish:models` command:**

This command will publish related model files.
remember to use the `--unite` and the `--target` options
right based on your desired approach.

Check the `iran:init` section above to see the usage of these options.

You can use `--force` option to overwrite the existed files.

Cities example:

- One `regions` Table :

```sh
  php artisan iran:publish:models --unite --target=cities
```

This will publish `IranRegion` model file.

- Separate tables :

```sh
  php artisan iran:import --target=cities
```

This will publish related model files up to cities level.

---

#### Code

This package uses eloquent models. Some methods are common among these models, and some aren't. 
Here is the list of all available methods with their usages:

**Common Methods for All models**

All models have these methods:

| Method                                    | Type                  | Usage                                |
|-------------------------------------------|:---------------------:|:-------------------------------------|
| getAll($paginate = true/false)            | static                | Get all                              |
| getAllActive($paginate = true/false)      | static                | Get all active                       |
| getAllNotActive($paginate = true/false)   | static                | Get all not active                   |
| active()                                  | static/dynamic        | Query for get active records         |
| notActive()                               | static/dynamic        | Query for get not active records     |
| activate()                                | dynamic               | Activates a record                   |
| deactivate()                              | dynamic               | Deactivates a record                 |
| isActive()                                | dynamic               | Returns bool for record status       |
| isNotActive()                             | dynamic               | Get all the counties of a province   |

---

#### Unite Mode


**IranRegion Model:**

| Method                        | Type    | Usage                                                                               |
|-------------------------------|:-------:|:------------------------------------------------------------------------------------|
| parent()                      | dynamic | belongsTo() relation method for the direct parent of a region                              |
| children()                    | dynamic | hasMany() relation method for all the direct children of a region                   |
| province()                    | dynamic | belongsTo() relation method for the province of a region if available               |
| provinceChildren()            | dynamic | hasMany() relation method for all the children of a province if available           |
| county()                      | dynamic | belongsTo() relation method for the county of a region if available                 |
| countyChildren()              | dynamic | hasMany() relation method for all the children of a county if available             |
| sector()                      | dynamic | belongsTo() relation method for the sector of a region if available                 |
| sectorChildren()              | dynamic | hasMany() relation method for all the children of a sector if available             |
| city()                        | dynamic | belongsTo() relation method for the city of a region if available                   |
| cityChildren()                | dynamic | hasMany() relation method for all the children of a city if available               |
| ruralDistrict()               | dynamic | belongsTo() relation method for the rural district of a region if available         |
| ruralDistrictChildren()       | dynamic | hasMany() relation method for all the children of a rural district if available     |


---

#### Separate Mode


**IranProvince Model:**

| Method                        | Type    | Usage                                                               |
|-------------------------------|:-------:|:--------------------------------------------------------------------|
| counties()                    | dynamic | hasMany() relation method for all the counties of a province        |
| sectors()                     | dynamic | hasMany() relation method for all the sectors of a province         |
| cities()                      | dynamic | hasMany() relation method for all the cities of a province          |
| cityDistricts()               | dynamic | hasMany() relation method for all the city districts of a province  |
| ruralDistricts()              | dynamic | hasMany() relation method for all the rural districts of a province |
| villages()                    | dynamic | hasMany() relation method for all the villages of a province        |
| getCounties()                 | dynamic | Get all the counties of a province                                  |
| getActiveCounties()           | dynamic | Get all the active counties of a province                           |
| getNotActiveCounties()        | dynamic | Get all the not active counties of a province                       |
| getSectors()                  | dynamic | Get all the sectors of a province                                   |
| getActiveSectors()            | dynamic | Get all the active sectors of a province                            |
| getNotActiveSectors()         | dynamic | Get all the not active sectors of a province                        |
| getCities()                   | dynamic | Get all the cities of a province                                    |
| getActiveCities()             | dynamic | Get all the active cities of a province                             |
| getNotActiveCities()          | dynamic | Get all the not active cities of a province                         |
| getCityDistricts()            | dynamic | Get all the city districts of a province                            |
| getActiveCityDistricts()      | dynamic | Get all the active city districts of a province                     |
| getNotActiveCityDistricts()   | dynamic | Get all the not active city districts of a province                 | 
| getRuralDistricts()           | dynamic | Get all the rural districts of a province                           |
| getActiveRuralDistricts()     | dynamic | Get all the active rural districts of a province                    |
| getNotActiveRuralDistricts()  | dynamic | Get all the not active rural districts of a province                |
| getVillages()                 | dynamic | Get all the villages of a province                                  |
| getActiveVillages()           | dynamic | Get all the active villages of a province                           |
| getNotActiveVillages()        | dynamic | Get all the not active villages of a province                       |

---

**IranCounty Model:**

| Method                        | Type    | Usage                                                             |
|-------------------------------|:-------:|:------------------------------------------------------------------|
| province()                    | dynamic | belongsTo() relation method for the province of a county          |
| sectors()                     | dynamic | hasMany() relation method for all the sectors of a county         |
| cities()                      | dynamic | hasMany() relation method for all the cities of a county          |
| cityDistricts()               | dynamic | hasMany() relation method for all the city districts of a county  |
| ruralDistricts()              | dynamic | hasMany() relation method for all the rural districts of a county |
| villages()                    | dynamic | hasMany() relation method for all the villages of a county        |
| getProvince()                 | dynamic | Get the parent province of a county                               |
| getSectors()                  | dynamic | Get all the sectors of a county                                   |
| getActiveSectors()            | dynamic | Get all the active sectors of a county                            |
| getNotActiveSectors()         | dynamic | Get all the not active sectors of a county                        |
| getCities()                   | dynamic | Get all the cities of a county                                    |
| getActiveCities()             | dynamic | Get all the active cities of a county                             |
| getNotActiveCities()          | dynamic | Get all the not active cities of a county                         |
| getCityDistricts()            | dynamic | Get all the city districts of a county                            |
| getActiveCityDistricts()      | dynamic | Get all the active city districts of a county                     |
| getNotActiveCityDistricts()   | dynamic | Get all the not active city districts of a county                 | 
| getRuralDistricts()           | dynamic | Get all the rural districts of a county                           |
| getActiveRuralDistricts()     | dynamic | Get all the active rural districts of a county                    |
| getNotActiveRuralDistricts()  | dynamic | Get all the not active rural districts of a county                |
| getVillages()                 | dynamic | Get all the villages of a county                                  |
| getActiveVillages()           | dynamic | Get all the active villages of a county                           |
| getNotActiveVillages()        | dynamic | Get all the not active villages of a county                       |

---

**IranSector Model:**

| Method                        | Type    | Usage                                                             |
|-------------------------------|:-------:|:------------------------------------------------------------------|
| province()                    | dynamic | belongsTo() relation method for the province of a sector          |
| county()                      | dynamic | belongsTo() relation method for the county of a sector            |
| cities()                      | dynamic | hasMany() relation method for all the cities of a sector          |
| cityDistricts()               | dynamic | hasMany() relation method for all the city districts of a sector  |
| ruralDistricts()              | dynamic | hasMany() relation method for all the rural districts of a sector |
| villages()                    | dynamic | hasMany() relation method for all the villages of a sector        |                                     
| getProvince()                 | dynamic | Get the parent province of a sector                               |
| getCounty()                   | dynamic | Get the parent province of a sector                               |
| getCities()                   | dynamic | Get all the cities of a sector                                    |
| getActiveCities()             | dynamic | Get all the active cities of a sector                             |
| getNotActiveCities()          | dynamic | Get all the not active cities of a sector                         |
| getCityDistricts()            | dynamic | Get all the city districts of a sector                            |
| getActiveCityDistricts()      | dynamic | Get all the active city districts of a sector                     |
| getNotActiveCityDistricts()   | dynamic | Get all the not active city districts of a sector                 | 
| getRuralDistricts()           | dynamic | Get all the rural districts of a sector                           |
| getActiveRuralDistricts()     | dynamic | Get all the active rural districts of a sector                    |
| getNotActiveRuralDistricts()  | dynamic | Get all the not active rural districts of a sector                |
| getVillages()                 | dynamic | Get all the villages of a sector                                  |
| getActiveVillages()           | dynamic | Get all the active villages of a sector                           |
| getNotActiveVillages()        | dynamic | Get all the not active villages of a sector                       |

---

**IranCity Model:**

| Method                        | Type    | Usage                                                           |
|-------------------------------|:-------:|:--------------------------------------------------------------- |
| province()                    | dynamic | belongsTo() relation method for the province of a city          |
| county()                      | dynamic | belongsTo() relation method for the county of a city            |
| sector()                      | dynamic | belongsTo() relation method for the sector of a city            |                              |
| cityDistricts()               | dynamic | hasMany() relation method for all the city districts of a city  |
| getProvince()                 | dynamic | Get the parent province of a city                               |
| getCounty()                   | dynamic | Get the parent county of a city                                 |     
| getSector()                   | dynamic | Get the parent sector of a city                                 |
| getCityDistricts()            | dynamic | Get all the city districts of a city                            |
| getActiveCityDistricts()      | dynamic | Get all the active city districts of a city                     |
| getNotActiveCityDistricts()   | dynamic | Get all the not active city districts of a city                 |                     |

---

**IranCityDistrict Model:**

| Method                 | Type    | Usage                                                           |
|------------------------|:-------:|:--------------------------------------------------------------- |
| province()             | dynamic | belongsTo() relation method for the province of a city district |
| county()               | dynamic | belongsTo() relation method for the county of a city district   |
| sector()               | dynamic | belongsTo() relation method for the sector of a city district   |
| city()                 | dynamic | belongsTo() relation method for the city of a city district     |                              |
| getProvince()          | dynamic | Get the parent province of a city district                      |
| getCounty()            | dynamic | Get the parent county of a city district                        |
| getSector()            | dynamic | Get the parent sector of a city district                        |
| getCity()              | dynamic | Get the parent city of a city district                          | 

---

**IranRuralDistrict Model:**

| Method                  | Type    | Usage                                                                 |
|-------------------------|:-------:|:--------------------------------------------------------------------- |
| province()              | dynamic | belongsTo() relation method for the province of a rural district      |
| county()                | dynamic | belongsTo() relation method for the county of a rural district        |
| sector()                | dynamic | belongsTo() relation method for the sector of a rural district        |
| villages()              | dynamic | hasMany() relation method for all the villages of a rural district    |                                     
| getProvince()           | dynamic | Get the parent province of a rural district                           |
| getCounty()             | dynamic | Get the parent county of a rural district                             |
| getSector()             | dynamic | Get the parent sector of a rural district                             |
| getVillages()           | dynamic | Get all the villages of a rural district                              |
| getActiveVillages()     | dynamic | Get all the active villages of a rural district                       |
| getNotActiveVillages()  | dynamic | Get all the not active villages of a rural district                   |

---

**IranVillage Model:**

| Method                  | Type    | Usage                                                             |
|-------------------------|:-------:|:----------------------------------------------------------------- |
| province()              | dynamic | belongsTo() relation method for the province of a village         |
| county()                | dynamic | belongsTo() relation method for the county of a village           |
| sector()                | dynamic | belongsTo() relation method for the sector of a village           |
| ruralDistrict()         | dynamic | belongsTo() relation method for the rural district of a village   |
| getProvince()           | dynamic | Get the parent province of a village                              |
| getCounty()             | dynamic | Get the parent county of a village                                |
| getSector()             | dynamic | Get the parent sector of a village                                |
| getRuralDistrict()      | dynamic | Get the parent rural district of a village                           |

---

All models have relation methods between themselves.

**Examples:**

* IranCity Model:

```php

use App\Models\IranCity;

# Fetching collection of cities
$cities          = IranCity::getAll(); // returns collection of cities
$activeCities    = IranCity::getAllActive(); // returns collection of active cities
$notActiveCities = IranCity::getAllNotActive(); // returns collection of not active cities

# Getting County
$city = IranCity::find(1);

# A city belongs to a county
$county = $city->county()->first(); // returns County model
$county = $city->getCounty(); // returns County model

# A city belongs to one province
$province = $city->province()->first(); // returns Province model
$province = $city->getProvince(); // returns Province model

```

**Status Field**

Each table has a field named `status`. This field is a boolean type field so that `1` stands for active record and `0` stands
for not active record. to make sure that you always get active records, use the `active()` method:

```php

use App\Models\IranCity;
use App\Models\IranCounty;
use App\Models\IranProvince;

# To get active provinces or an active province:
$provinces = IranProvince::active()->get(); // returns collection of all active provinces
$provinces = IranProvince::notActive()->get(); // returns collection of all not active provinces

# You can even check if the record is active or not
$city = IranCity::find(1);

$city->isActive(); //returns true if the record is active false if is not active
$city->isNotActive(); //returns true if the record is not active false if is active

# You can even activate and deactivate records like so:
$county = IranCounty::find(1);

$county->activate(); // activates record by setting status field in db to 1
$county->deactivate(); // deactivates record by setting status field in db to 0

```

**Notice :** 

Deactivation will be applied by the hierarchy of divisions. For example:

* Province deactivation will deactivate all counties and cities and so on.
* County deactivation will deactivate all cities of that county and so on.

Note that the children's records will not change. 
They only will be unavailable if you try to get them via the `active()` scope.

For Example :

```php

use App\Models\IranProvince;
use App\Models\IranCity;

# assume that city with id `1` is belongs to province with id `1'
# if you deactivate province all the cities will be deactivated and not showed in the results.

$province = IranProvince::active()->find(1); // find the active province with id `1`

$province->deactivate(); // deactivate province with id `1`

# now if you try to get city:
$city = IranCity::active()->find(1); // returns null because the province of the city is deactivated

//or

$city = IranCity::find(1); // finds the record because you didn't use active() scope

$city->isActive(); // return false because the province of the city is not active but the status is still 1

```

## Todos

 - Write Tests
 - Add longitude and latitude of regions
 - Add geo locations of regions
 
Issues
----
You can report issues in github repository [here][link-issues] 

License
----
Typhoon-Iran-Cities is released under the MIT License.

Created by [Salar Bahador][link-github].

Built with ❤ for you.

Contributing
----
Contributions, useful comments, and feedback are most welcome!

Reference
----

Based on [ahmadazizi/iran-cities][link-reference-repo] git repository version 3. Take a look For more info.

[ico-laravel]: https://img.shields.io/badge/Laravel-≥5.0-ff2d20?style=flat-square&logo=laravel
[ico-php]: https://img.shields.io/badge/php-≥5.6-8892bf?style=flat-square&logo=php
[ico-downloads]: https://poser.pugx.org/salibhdr/typhoon-iran-cities/downloads
[ico-today-downloads]: https://img.shields.io/packagist/dd/salibhdr/typhoon-iran-cities.svg?style=flat-square
[ico-license]: https://poser.pugx.org/salibhdr/typhoon-iran-cities/v/unstable
[ico-version]: https://img.shields.io/packagist/v/salibhdr/typhoon-iran-cities.svg?style=flat-square

[link-logo]: https://drive.google.com/a/domain.com/thumbnail?id=12yntFCiYIGJzI9FMUaF9cRtXKb0rXh9X
[link-packagist]: https://packagist.org/packages/salibhdr/typhoon-iran-cities
[link-downloads]: https://packagist.org/packages/salibhdr/typhoon-iran-cities/stats
[link-packegist]: https://packagist.org/packages/salibhdr/typhoon-iran-cities
[link-issues]: https://github.com/salibhdr/typhoon-iran-cities/issues
[link-github]: https://github.com/salibhdr/typhoon-iran-cities/issues
[link-reference-repo]: https://github.com/salibhdr/typhoon-iran-cities/issues
