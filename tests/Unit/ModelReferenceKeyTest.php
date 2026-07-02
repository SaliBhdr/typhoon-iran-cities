<?php

namespace SaliBhdr\TyphoonIranCities\Tests\Unit;

use ReflectionMethod;
use SaliBhdr\TyphoonIranCities\Models\IranCityDistrict;
use SaliBhdr\TyphoonIranCities\Models\IranVillage;
use SaliBhdr\TyphoonIranCities\Tests\TestCase;

class ModelReferenceKeyTest extends TestCase
{
    public function test_models_expose_expected_reference_keys(): void
    {
        $this->assertSame(
            'city_district_id',
            $this->referenceKey(new IranCityDistrict())
        );
        $this->assertSame(
            'village_id',
            $this->referenceKey(new IranVillage())
        );
    }

    private function referenceKey(object $model): string
    {
        $method = new ReflectionMethod($model, 'getReferenceKey');
        $method->setAccessible(true);

        return $method->invoke($model);
    }
}
