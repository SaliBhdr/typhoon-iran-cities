<?php
/**
 * Created by PhpStorm.
 * User: s.bahador
 * Date: 2/16/2020
 * Time: 2:14 PM
 */

namespace SaliBhdr\TyphoonIranCities;

use Illuminate\Database\Query\Builder as QueryBuilder;

/**
 * @method QueryBuilder active() gets records where status is 1
 * @method QueryBuilder notActive() gets records where status is 0
 * Trait useActiveField
 * @package SaliBhdr\TyphoonIranCities
 */
trait useActiveField
{
    public static $active = 1;
    public static $notActive = 1;

    /**
     * query for get active records
     *
     * @param $query
     * @return mixed
     */
    public function scopeActive($query)
    {
        return $query->whereStatus(static::$active);
    }

    /**
     * query for get not active records
     *
     * @param $query
     * @return mixed
     */
    public function scopeNotActive($query)
    {
        return $query->whereStatus(static::$notActive);
    }

    /**
     * activates record by updating status
     *
     * @return $this
     */
    public function activate()
    {
        $this->updateStatus(static::$active);

        return $this;
    }

    /**
     * activates record by updating status
     *
     * @return $this
     */
    public function deactivate()
    {
        $this->updateStatus(static::$notActive);

        return $this;
    }

    /**
     * checked if record status is 1 : active
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->isStatus(static::$active);
    }

    /**
     * checked if record status is 0 : deactive
     *
     * @return bool
     */
    public function isNotActive()
    {
        return $this->isStatus(static::$notActive);
    }

    private function isStatus($status){

        $recordStatus = $this->status;

        if (is_string($recordStatus))
            $recordStatus = (int)$recordStatus;

        return $recordStatus === $status;
    }

    private function updateStatus($status){

        $this->status = $status;

        $this->save();
    }
}