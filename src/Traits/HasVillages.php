<?php

namespace SaliBhdr\TyphoonIranCities\Traits;

use SaliBhdr\TyphoonIranCities\Models\IranVillage;

trait HasVillages
{
    /**
     * rural district has many districts
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function villages()
    {
        return $this->hasMany(IranVillage::class, $this->getReferenceKey());
    }

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection|IranVillage[]
     */
    public function getVillages($paginate = false)
    {
        $query = $this->villages()->orderBy('id','ASC');

        if ($paginate)
            return $query->paginate();

        return $query->get();
    }

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection|IranVillage[]
     */
    public function getActiveVillages($paginate = false)
    {
        $query = $this->villages()->active()->orderBy('id','ASC');

        if ($paginate)
            return $query->paginate();

        return $query->get();
    }

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection|IranVillage[]
     */
    public function getNotActiveVillages($paginate = false)
    {
        $query = $this->villages()->notActive()->orderBy('id','ASC');

        if ($paginate)
            return $query->paginate();

        return $query->get();
    }
}
