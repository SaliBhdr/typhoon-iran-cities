<?php

namespace SaliBhdr\TyphoonIranCities\Traits;

use SaliBhdr\TyphoonIranCities\Models\IranRuralDistrict;

trait HasRuralDistricts
{
    /**
     * Sector has many rural districts
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ruralDistricts()
    {
        return $this->hasMany(IranRuralDistrict::class, $this->getReferenceKey());
    }

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection|IranRuralDistrict[]
     */
    public function getRuralDistricts($paginate = false)
    {
        $query = $this->ruralDistricts()->orderBy('id', 'ASC');

        if ($paginate)
            return $query->paginate();

        return $query->get();
    }

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection|IranRuralDistrict[]
     */
    public function getActiveRuralDistricts($paginate = false)
    {
        $query = $this->ruralDistricts()->active()->orderBy('id', 'ASC');

        if ($paginate)
            return $query->paginate();

        return $query->get();
    }

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection|IranRuralDistrict[]
     */
    public function getNotActiveRuralDistricts($paginate = false)
    {
        $query = $this->ruralDistricts()->notActive()->orderBy('id', 'ASC');

        if ($paginate)
            return $query->paginate();

        return $query->get();
    }
}
