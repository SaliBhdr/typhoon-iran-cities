<?php

namespace SaliBhdr\TyphoonIranCities\Traits;

use SaliBhdr\TyphoonIranCities\Models\IranCity;

trait HasCities
{
    /**
     * Sector has many cities
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     *
     */
    public function cities()
    {
        return $this->hasMany(IranCity::class, $this->getReferenceKey());
    }

    /**
     * @param boolean $paginate
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection|IranCity[]
     */
    public function getCities($paginate = false)
    {
        $query = $this->cities()->orderBy('id', 'ASC');

        if ($paginate)
            return $query->paginate();

        return $query->get();
    }

    /**
     * @param boolean $paginate
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection|IranCity[]
     */
    public function getActiveCities($paginate = false)
    {
        $query = $this->cities()->active()->orderBy('id', 'ASC');

        if ($paginate)
            return $query->paginate();

        return $query->get();
    }

    /**
     * @param boolean $paginate
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection|IranCity[]
     */
    public function getNotActiveCities($paginate = false)
    {
        $query = $this->cities()->notActive()->orderBy('id', 'ASC');

        if ($paginate)
            return $query->paginate();

        return $query->get();
    }
}
