# Typhoon Url Signer

![Salibhdr|typhoon](https://drive.google.com/a/domain.com/thumbnail?id=12yntFCiYIGJzI9FMUaF9cRtXKb0rXh9X)

[![Total Downloads](https://poser.pugx.org/SaliBhdr/typhoon-iran-cities/downloads)](https://packagist.org/packages/SaliBhdr/typhoon-url-signer)
[![Latest Stable Version](https://poser.pugx.org/SaliBhdr/typhoon-iran-cities/v/stable)](https://packagist.org/packages/SaliBhdr/typhoon-url-signer)
[![Latest Unstable Version](https://poser.pugx.org/SaliBhdr/typhoon-iran-cities/v/unstable)](https://packagist.org/packages/SaliBhdr/typhoon-url-signer)
[![License](https://poser.pugx.org/SaliBhdr/typhoon-iran-cities/license)](https://packagist.org/packages/SaliBhdr/typhoon-url-signer)

## Introduction

Typhoon Iran Cities is a Laravel package for importing all provinces, counties and cities of iran into your database with just 
only one console command.

This is the most accurate laravel package for cities of iran without a doubt.

**Features**
- All provinces of iran (استان)
- All counties of iran (شهرستان)
- All cities of iran (شهر)
- Compatible with Laravel
- Built in models of provinces, counties and cities
- relational database between these tables

## Installation

#### Install with Composer
```sh
 $ composer require salibhdr/typhoon-iran-cities
```
## Getting started

##### Laravel

For laravel < 5.5 Register the Service provider in your config/app.php configuration file:

---

```php
'providers' => [

     # Other service providers...
     
     SaliBhdr\TyphoonIranCities\IranCitiesServiceProvider::class,
],
```

Run `vendor:publish` command:

```sh

php artisan vendor:publish --provider="SaliBhdr\TyphoonIranCities\IranCitiesServiceProvider"

```

It will generate the 3 migration files under database/migrations directory.

```
2018_02_10_115102_create_provinces_table.php,
2018_02_10_115103_create_counties_table.php,
2018_02_10_115104_create_cities_table.php,

```

And will copy `Province.php`,`County.php` and `City.php` models.

Run the `php artisan migrate` command to migrate all 3 tables:

## Usage

At the end for importing all provinces, counties and cities into these tables run this command in your console :

```

php artisan iran-cities:import

```

This outputs :

```

Starting to import data...

importing provinces...
importing counties...
importing cities...

Data has been imported successfully!!!

```

## Todos

 - Write Tests
 
Issues
----
You can report issues in github repository [here][lk1] 

License
----
Typhoon-Iran-Cities is released under the MIT License.

Created by Salar Bahador.

Built with ❤ for you.

**Free Software, Hell Yeah!**

Contributing
----
Contributions, useful comments, and feedback are most welcome!

Reference
----

Based on [ahmadazizi/iran-cities][2k2] git repository. Take a look For more info.

   [lk1]: <https://github.com/SaliBhdr/typhoon-iran-cities/issues>
   [2k2]: <https://github.com/ahmadazizi/iran-cities>