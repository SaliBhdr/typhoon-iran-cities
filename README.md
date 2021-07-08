# Typhoon Iran Cities, Counties and Provinces

![Salibhdr|typhoon](https://drive.google.com/a/domain.com/thumbnail?id=12yntFCiYIGJzI9FMUaF9cRtXKb0rXh9X)

[![Total Downloads](https://poser.pugx.org/SaliBhdr/typhoon-iran-cities/downloads)](https://packagist.org/packages/SaliBhdr/typhoon-iran-cities)
[![Latest Stable Version](https://poser.pugx.org/SaliBhdr/typhoon-iran-cities/v/stable)](https://packagist.org/packages/SaliBhdr/typhoon-iran-cities)
[![Latest Unstable Version](https://poser.pugx.org/SaliBhdr/typhoon-iran-cities/v/unstable)](https://packagist.org/packages/SaliBhdr/typhoon-iran-cities)
[![License](https://poser.pugx.org/SaliBhdr/typhoon-iran-cities/license)](https://packagist.org/packages/SaliBhdr/typhoon-iran-cities)

## Introduction

Typhoon Iran Cities is a Laravel package for importing all provinces, counties, sectors, cities, city districts, rural districts and villages of Iran into your database with just 
only one console command.

This is the most accurate Laravel package for administrative divisions of Iran without a doubt.

![Administrative Divisions of Iran](./docs/images/administrative_divisions_of_Iran.jpg)

**Features**
- All provinces of Iran (استان)
- All counties of Iran (شهرستان)
- All sectors of Iran (بخش)
- All cities of Iran (شهر)
- All city districts of Iran (مناطق شهری)
- All rural districts of Iran (دهستان)
- All villages of Iran (آبادی)
- Compatible with Laravel
- Built-in models of provinces, counties, sectors, cities, city districts, rural districts and villages
- relational database between these tables

## Installation

#### Install with Composer
```sh
 $ composer require salibhdr/typhoon-iran-cities
```
## Getting started

##### Laravel

For Laravel < 5.5 Register the Service provider in your config/app.php configuration file:

---

```php
'providers' => [

     # Other service providers...
     
     SaliBhdr\TyphoonIranCities\IranCitiesServiceProvider::class,
],
```

Run `Iran:publish:migrations` command for copying migrations:

```sh

php artisan Iran:publish:migrations

```

It will generate the 7 migration files under database/migrations directory.

```
xxxx_xx_xx_xxxxxx_create_iran_provinces_table.php,
xxxx_xx_xx_xxxxxx_create_iran_counties_table.php,
xxxx_xx_xx_xxxxxx_create_iran_sectors_table.php,
xxxx_xx_xx_xxxxxx_create_iran_cities_table.php,
xxxx_xx_xx_xxxxxx_create_iran_city_districts_table.php,
xxxx_xx_xx_xxxxxx_create_iran_rural_districts_table.php,
xxxx_xx_xx_xxxxxx_create_iran_villages_table.php,

```
Then run `Iran:publish:models` command for copying models (If you don't want to use models skip this part) :

```sh

php artisan Iran:publish:models

```

This will copy `IranProvince.php`, `IranCounty.php`, `IranSector.php`, `IranCity.php`, `IranCityDistrict.php`, `IranRuralDistrict.php` and `IranVillage.php` models.

Run the `php artisan migrate` command to migrate all 7 tables:

## Usage

#### Data Import
At the end for importing data into related tables you can run one of these commands:

```

  iran:import                  Imports all regions into the database (Can be selected by option)
  iran:import:provinces        Imports provinces only into the database
  iran:import:counties         Imports counties and provinces without cities into the database
  iran:import:sectors          Imports sectors, counties and provinces into the database
  iran:import:cities           Imports cities, sectors, counties and provinces into the database
  iran:import:city-districts   Imports city districts, cities, sectors, counties and provinces into the database
  iran:import:rural-districts  Imports rural districts, sectors, counties and provinces into the database
  iran:import:villages         Imports villages, rural districts, sectors, counties and provinces into the database

```

This outputs one or more of these line based on the command :

```

Starting to import data...

Importing provinces...
 31/31 [============================] 100%
Importing counties...
 448/448 [============================] 100%
Importing sectors...
 1099/1099 [============================] 100%
Importing cities...
 1354/1354 [============================] 100%
Importing city districts...
 200/200 [============================] 100%
Importing rural districts...
 2637/2637 [============================] 100%
Importing villages...
  98100/98100 [============================] 100%

Data has been imported successfully!!!

```
#### Code Usage

All Available methods

This package uses 3 eloquent models to get data from the database. These models are Province, County, and City.
Some methods are common among these models, and some are not. 
Here is the list of all these methods with their usages:

**Common Methods for All models**

If you use `HasStatusField` trait these methods are available. By default, the `HasStatusField` is used.

| Method        | Type           | Usage                              |
|---------------|:--------------:|:-----------------------------------|
| active()      | static/dynamic | Query for get active records       |
| notActive()   | static/dynamic | Query for get not active records   |
| activate()    | dynamic        | Activates a record                 |
| deactivate()  | dynamic        | Deactivates a record               |
| isActive()    | dynamic        | Returns bool for record status     |
| isNotActive() | dynamic        | Get all the counties of a province |

---

**Province Model:**

| Method                 | Type    | Usage                                                         |
|------------------------|:-------:|:--------------------------------------------------------------|
| cities()               | dynamic | hasMany() relation method for all the cities of a province    |
| counties()             | dynamic | hasMany() relation method for all the Counties of a province  |
| getAll()               | static  | Get all provinces                                             |
| getAllActive()         | static  | Get all active provinces                                      |
| getAllNotActive()      | static  | Get all not active provinces                                  |
| getCounties()          | dynamic | Get all the counties of a province                            |
| getActiveCounties()    | dynamic | Get all the active counties of a province                     |
| getNotActiveCounties() | dynamic | Get all the not active counties of a province                 |
| getSectors()          | dynamic | Get all the counties of a province                            |
| getActiveSectors()    | dynamic | Get all the active counties of a province                     |
| getNotActiveSectors() | dynamic | Get all the not active counties of a province   
| getCities()            | dynamic | Get all the cities of a province                              |
| getActiveCities()      | dynamic | Get all the active cities of a province                       |
| getNotActiveCities()   | dynamic | Get all the not active cities of a province                   |

---

**County Model:**

| Method                 | Type    | Usage                                                       |
|------------------------|:-------:|:------------------------------------------------------------|
| province()             | dynamic | belongsTo() relation method for the province of a county    |
| cities()               | dynamic | hasMany() relation method for all the cities of a county    |
| getAll()               | static  | Get all counties                                            |
| getAllActive()         | static  | Get all active counties                                     |
| getAllNotActive()      | static  | Get all not active counties                                 |
| getProvince()          | dynamic | Get the parent province of a county                         |
| getCities()            | dynamic | Get all the cities of a county                              |
| getActiveCities()      | dynamic | Get all the active cities of a county                       |
| getNotActiveCities()   | dynamic | Get all the not active cities of a county                   |

---

**City Model:**

| Method                 | Type    | Usage                                                     |
|------------------------|:-------:|:--------------------------------------------------------- |
| province()             | dynamic | belongsTo() relation method for the province of a city    |
| county()               | dynamic | belongsTo() relation method for the county of a city      |
| getAll()               | static  | Get all cities                                            |
| getAllActive()         | static  | Get all active cities                                     |
| getAllNotActive()      | static  | Get all not active cities                                 |
| getProvince()          | dynamic | Get the parent province of a city                         |
| getCounty()            | dynamic | Get the parent county of a city                           |

All models have relation methods between themselves.

**Examples:**

* City Model:
```php

use App\City;

# Fetching collection of cities
$counties          = City::getAll(); // returns collection of cities
$activeCounties    = City::getAllActive(); // returns collection of active cities
$notActiveCounties = City::getAllNotActive(); // returns collection of not active cities

# Getting County
$city = City::find(1);

# A city belongs to a county
$county = $city->county()->first(); // returns County model
$county = $city->getCounty(); // returns County model

# A city belongs to one province
$province = $city->province()->first(); // returns Province model
$province = $city->getProvince(); // returns Province model

```

**Status Field**

If you want to be able to activate and deactivate provinces, counties, and cities by default each model uses
a trait named 'HasStatusField'. This trait allows you to access a bunch of methods that help you to manage all records. Here is how to use them:

Each table has a field named `status`. This field is a boolean type field so that `1` stands for active record and `0` stands
for not active record. to make sure that you always get active records, use `active()` method:

```php
use App\City;
use App\County;
use App\Province;

# To get active provinces or an active province:
$provinces = Province::active()->get(); // returns collection of all active provinces
$provinces = Province::notActive()->get(); // returns collection of all not active provinces

# You can even check if the record is active or not
$city = City::find(1);

$city->isActive(); //returns true if the record is active false if is not active
$city->isNotActive(); //returns true if the record is not active false if is active

# You can even activate and deactivate records like so:
$county = County::find(1);

$county->activate(); // activates record by setting status field in db to 1
$county->deactivate(); // deactivates record by setting status field in db to 0

```

**Notice:** If you want to deactivate a record the records that belong to that record will be deactivated as long 
as you use active() scope for fetching data.

* Province deactivation will deactivate all counties and cities of that province
* County deactivation will deactivate all cities of that county
* City deactivation only will deactivate that city and does not affect province and county of that record 

Example :

```php
use App\Province;
use App\City;

# assume that city with id `1` is belongs to province with id `1'
# if you deactivate province all the cities will be deactivated and not showed in the results.

$province = Province::active()->find(1); // find the active province with id `1`

$province->deactivate(); // deactivate province with id `1`

# now if you try to get city:
$city = City::active()->find(1); // returns null because the province of the city is deactivated

//or

$city = City::find(1); // finds the record because you didn't use active() scope

$city->isActive(); // return false because the province of the city is not active

```

## Todos

 - Write Tests
 - Add longitude and latitude of regions
 - Add geo locations of regions
 
Issues
----
You can report issues in github repository [here][lk1] 

License
----
Typhoon-Iran-Cities is released under the MIT License.

Created by [Salar Bahador][lkself].

Built with ❤ for you.

Contributing
----
Contributions, useful comments, and feedback are most welcome!

Reference
----

Based on [ahmadazizi/iran-cities][2k2] git repository version 3. Take a look For more info.

   [lk1]: <https://github.com/SaliBhdr/typhoon-iran-cities/issues>
   [lkself]: <https://github.com/SaliBhdr>
   [2k2]: <https://github.com/ahmadazizi/iran-cities>
