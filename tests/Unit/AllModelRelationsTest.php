<?php

namespace SaliBhdr\TyphoonIranCities\Tests\Unit;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use SaliBhdr\TyphoonIranCities\Models\IranCity;
use SaliBhdr\TyphoonIranCities\Models\IranCityDistrict;
use SaliBhdr\TyphoonIranCities\Models\IranCounty;
use SaliBhdr\TyphoonIranCities\Models\IranProvince;
use SaliBhdr\TyphoonIranCities\Models\IranRuralDistrict;
use SaliBhdr\TyphoonIranCities\Models\IranSector;
use SaliBhdr\TyphoonIranCities\Models\IranVillage;
use SaliBhdr\TyphoonIranCities\Tests\Concerns\SeedsIranHierarchy;
use SaliBhdr\TyphoonIranCities\Tests\TestCase;

class AllModelRelationsTest extends TestCase
{
    use SeedsIranHierarchy;

    protected function setUp(): void
    {
        parent::setUp();

        $this->migrateAllSeparateTables();
        $this->seedFullHierarchy();
    }

    public function test_province_exposes_all_child_collections(): void
    {
        $province = IranProvince::find(1);
        $inactiveProvince = IranProvince::find(2);

        $this->assertCount(1, $province->counties);
        $this->assertCount(1, $province->getCounties());
        $this->assertCount(1, $province->getActiveCounties());
        $this->assertCount(1, $inactiveProvince->getNotActiveCounties());
        $this->assertInstanceOf(LengthAwarePaginator::class, $province->getCounties(true));
        $this->assertInstanceOf(LengthAwarePaginator::class, $province->getActiveCounties(true));
        $this->assertInstanceOf(LengthAwarePaginator::class, $inactiveProvince->getNotActiveCounties(true));

        $this->assertCount(1, $province->getSectors());
        $this->assertCount(1, $province->getActiveSectors());
        $this->assertCount(1, $inactiveProvince->getNotActiveSectors());
        $this->assertInstanceOf(LengthAwarePaginator::class, $province->getSectors(true));
        $this->assertInstanceOf(LengthAwarePaginator::class, $province->getActiveSectors(true));
        $this->assertInstanceOf(LengthAwarePaginator::class, $inactiveProvince->getNotActiveSectors(true));

        $this->assertCount(1, $province->getCities());
        $this->assertCount(1, $province->getActiveCities());
        $this->assertCount(1, $inactiveProvince->getNotActiveCities());
        $this->assertInstanceOf(LengthAwarePaginator::class, $province->getCities(true));
        $this->assertInstanceOf(LengthAwarePaginator::class, $province->getActiveCities(true));
        $this->assertInstanceOf(LengthAwarePaginator::class, $inactiveProvince->getNotActiveCities(true));

        $this->assertCount(1, $province->getCityDistricts());
        $this->assertCount(1, $province->getActiveCityDistricts());
        $this->assertCount(1, $inactiveProvince->getNotActiveCityDistricts());
        $this->assertInstanceOf(LengthAwarePaginator::class, $province->getCityDistricts(true));
        $this->assertInstanceOf(LengthAwarePaginator::class, $province->getActiveCityDistricts(true));
        $this->assertInstanceOf(LengthAwarePaginator::class, $inactiveProvince->getNotActiveCityDistricts(true));

        $this->assertCount(1, $province->getRuralDistricts());
        $this->assertCount(1, $province->getActiveRuralDistricts());
        $this->assertCount(1, $inactiveProvince->getNotActiveRuralDistricts());
        $this->assertInstanceOf(LengthAwarePaginator::class, $province->getRuralDistricts(true));
        $this->assertInstanceOf(LengthAwarePaginator::class, $province->getActiveRuralDistricts(true));
        $this->assertInstanceOf(LengthAwarePaginator::class, $inactiveProvince->getNotActiveRuralDistricts(true));

        $this->assertCount(1, $province->getVillages());
        $this->assertCount(1, $province->getActiveVillages());
        $this->assertCount(1, $inactiveProvince->getNotActiveVillages());
        $this->assertInstanceOf(LengthAwarePaginator::class, $province->getVillages(true));
        $this->assertInstanceOf(LengthAwarePaginator::class, $province->getActiveVillages(true));
        $this->assertInstanceOf(LengthAwarePaginator::class, $inactiveProvince->getNotActiveVillages(true));
    }

    public function test_county_exposes_child_collections_and_parent(): void
    {
        $county = IranCounty::find(1);
        $inactiveCounty = IranCounty::find(2);

        $this->assertSame('Active Province', $county->getProvince()->name);
        $this->assertCount(1, $county->getSectors());
        $this->assertCount(1, $county->getActiveSectors());
        $this->assertCount(1, $inactiveCounty->getNotActiveSectors());
        $this->assertInstanceOf(LengthAwarePaginator::class, $county->getSectors(true));

        $this->assertCount(1, $county->getCities());
        $this->assertCount(1, $county->getActiveCities());
        $this->assertCount(1, $inactiveCounty->getNotActiveCities());
        $this->assertInstanceOf(LengthAwarePaginator::class, $county->getCities(true));

        $this->assertCount(1, $county->getCityDistricts());
        $this->assertCount(1, $county->getActiveCityDistricts());
        $this->assertCount(1, $inactiveCounty->getNotActiveCityDistricts());
        $this->assertInstanceOf(LengthAwarePaginator::class, $county->getCityDistricts(true));

        $this->assertCount(1, $county->getRuralDistricts());
        $this->assertCount(1, $county->getActiveRuralDistricts());
        $this->assertCount(1, $inactiveCounty->getNotActiveRuralDistricts());
        $this->assertInstanceOf(LengthAwarePaginator::class, $county->getRuralDistricts(true));

        $this->assertCount(1, $county->getVillages());
        $this->assertCount(1, $county->getActiveVillages());
        $this->assertCount(1, $inactiveCounty->getNotActiveVillages());
        $this->assertInstanceOf(LengthAwarePaginator::class, $county->getVillages(true));
    }

    public function test_sector_exposes_child_collections_and_parents(): void
    {
        $sector = IranSector::find(1);
        $inactiveSector = IranSector::find(2);

        $this->assertSame('Active Province', $sector->getProvince()->name);
        $this->assertSame('Active County', $sector->getCounty()->name);

        $this->assertCount(1, $sector->getCities());
        $this->assertCount(1, $sector->getActiveCities());
        $this->assertCount(1, $inactiveSector->getNotActiveCities());
        $this->assertInstanceOf(LengthAwarePaginator::class, $sector->getCities(true));

        $this->assertCount(1, $sector->getCityDistricts());
        $this->assertCount(1, $sector->getActiveCityDistricts());
        $this->assertCount(1, $inactiveSector->getNotActiveCityDistricts());
        $this->assertInstanceOf(LengthAwarePaginator::class, $sector->getCityDistricts(true));

        $this->assertCount(1, $sector->getRuralDistricts());
        $this->assertCount(1, $sector->getActiveRuralDistricts());
        $this->assertCount(1, $inactiveSector->getNotActiveRuralDistricts());
        $this->assertInstanceOf(LengthAwarePaginator::class, $sector->getRuralDistricts(true));

        $this->assertCount(1, $sector->getVillages());
        $this->assertCount(1, $sector->getActiveVillages());
        $this->assertCount(1, $inactiveSector->getNotActiveVillages());
        $this->assertInstanceOf(LengthAwarePaginator::class, $sector->getVillages(true));
    }

    public function test_city_exposes_districts_and_parents(): void
    {
        $city = IranCity::find(1);
        $inactiveCity = IranCity::find(2);

        $this->assertSame('Active Province', $city->getProvince()->name);
        $this->assertSame('Active County', $city->getCounty()->name);
        $this->assertSame('Active Sector', $city->getSector()->name);

        $this->assertCount(1, $city->getCityDistricts());
        $this->assertCount(1, $city->getActiveCityDistricts());
        $this->assertCount(1, $inactiveCity->getNotActiveCityDistricts());
        $this->assertInstanceOf(LengthAwarePaginator::class, $city->getCityDistricts(true));
    }

    public function test_city_district_exposes_all_parents(): void
    {
        $district = IranCityDistrict::find(1);

        $this->assertSame('Active Province', $district->getProvince()->name);
        $this->assertSame('Active County', $district->getCounty()->name);
        $this->assertSame('Active Sector', $district->getSector()->name);
        $this->assertSame('Active City', $district->getCity()->name);
    }

    public function test_rural_district_exposes_villages_and_parents(): void
    {
        $rural = IranRuralDistrict::find(1);
        $inactiveRural = IranRuralDistrict::find(2);

        $this->assertSame('Active Province', $rural->getProvince()->name);
        $this->assertSame('Active County', $rural->getCounty()->name);
        $this->assertSame('Active Sector', $rural->getSector()->name);

        $this->assertCount(1, $rural->getVillages());
        $this->assertCount(1, $rural->getActiveVillages());
        $this->assertCount(1, $inactiveRural->getNotActiveVillages());
        $this->assertInstanceOf(LengthAwarePaginator::class, $rural->getVillages(true));
    }

    public function test_village_exposes_all_parents(): void
    {
        $village = IranVillage::find(1);

        $this->assertSame('Active Province', $village->getProvince()->name);
        $this->assertSame('Active County', $village->getCounty()->name);
        $this->assertSame('Active Sector', $village->getSector()->name);
        $this->assertSame('Active Rural', $village->getRuralDistrict()->name);
    }
}
