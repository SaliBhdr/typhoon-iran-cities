<?php

namespace SaliBhdr\TyphoonIranCities\Traits;

use SaliBhdr\TyphoonIranCities\Models\IranCityDistrict;

trait HasCityDistricts
{
    /**
     * city has many city districts
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cityDistricts()
    {
        return $this->hasMany(IranCityDistrict::class, $this->getReferenceKey());
    }

    /**
     * @param boolean $paginate
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection|IranCityDistrict[]
     */
    public function getCityDistricts($paginate = false)
    {
        $query = $this->cityDistricts()->orderBy('id', 'ASC');

        if ($paginate)
            return $query->paginate();

        return $query->get();
    }

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection|IranCityDistrict[]
     */
    public function getActiveCityDistricts($paginate = false)
    {
        $query = $this->cityDistricts()->active()->orderBy('id', 'ASC');

        if ($paginate)
            return $query->paginate();

        return $query->get();
    }

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection|IranCityDistrict[]
     */
    public function getNotActiveCityDistricts($paginate = false)
    {
        $query = $this->cityDistricts()->notActive()->orderBy('id', 'ASC');

        if ($paginate)
            return $query->paginate();

        return $query->get();
    }
}
