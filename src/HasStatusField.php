<?php
/**
 * Created by PhpStorm.
 * User: s.bahador
 * Date: 2/16/2020
 * Time: 2:14 PM
 */

namespace SaliBhdr\TyphoonIranCities;

use Illuminate\Database\Eloquent\Builder;

/**
 * @method static active() gets records where status is 1
 * @method static notActive() gets records where status is 0
 * Trait HasStatusField
 */
trait HasStatusField
{
    public static $ACTIVE = 1;
    public static $NOT_ACTIVE = 0;

    /**
     * query for get active records
     *
     * @param $query
     * @return Builder
     */
    public function scopeActive(Builder $query)
    {
        return $this->statusQuery($query, static::$ACTIVE);
    }

    /**
     * query for get not active records
     *
     * @param $query
     * @return Builder
     */
    public function scopeNotActive(Builder $query)
    {
        return $this->statusQuery($query, static::$NOT_ACTIVE);
    }

    /**
     * generates status query based on relation
     *
     * @param Builder $query
     * @param $status
     * @return Builder
     */
    private function statusQuery(Builder $query, $status)
    {
        $query->where('status', $status);

        if (method_exists($this, 'province')) {
            $query->whereHas('province', function ($q) use ($status) {
                return $q->where('provinces.status', $status);
            });
        }

        if (method_exists($this, 'county')) {
            $query->whereHas('county', function ($q) use ($status) {
                return $q->where('counties.status', $status);
            });
        }

        return $query;
    }

    /**
     * activates record by updating status to 1
     *
     * @return $this
     */
    public function activate()
    {
        $this->updateStatus(static::$ACTIVE);

        return $this;
    }

    /**
     * de activates record by updating status to 0
     *
     * @return $this
     */
    public function deactivate()
    {
        $this->updateStatus(static::$NOT_ACTIVE);

        return $this;
    }

    /**
     * checked if record status is 1 : active
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->isStatus(static::$ACTIVE);
    }

    /**
     * checked if record status is 0 : no active
     *
     * @return bool
     */
    public function isNotActive()
    {
        return $this->isStatus(static::$NOT_ACTIVE);
    }

    /**
     * checks the status
     *
     * @param $status
     * @return bool
     */
    private function isStatus($status)
    {
        if ($this->status != $status)
            return false;

        if (method_exists($this, 'county')) {
            $county = $this->county()->first();

            if ($this->status != $county->status)
                return false;
        }

        if (method_exists($this, 'province')) {
            $province = $this->province()->first();

            if ($this->status != $province->status)
                return false;
        }

        return true;
    }

    /**
     * updates the status
     *
     * @param $status
     */
    private function updateStatus($status)
    {
        $this->status = $status;

        $this->save();
    }
}
