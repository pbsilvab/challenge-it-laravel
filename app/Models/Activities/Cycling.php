<?php

namespace App\Models\Activities;

use Illuminate\Database\Eloquent\Model;
use App\Models\FitnessActivity;

class Cycling extends FitnessActivity
{
    public function validProperties() 
    {
        return [
            'cadence' => 'required|int',
            'distance' => 'required|string',
            'distance_unit' => 'required|string',
            'elapsed_time' => 'required|date',
        ];
    }

    public function setCadence(int $cadence)
    {
        $this->setProperty('cadence', $cadence);
    }

    public function getCadence()
    {
        return $this->getProperty('cadence');
    }

    public function setDistance(int $distance)
    {
        $this->setProperty('distance', $distance);
    }

    public function getDistance()
    {
        return $this->getProperty('distance');
    }

    public function setDistanceUnit(string $du)
    {
        $this->setProperty('distance_unit', $du);
    }

    public function getDistanceUnit()
    {
        $this->getProperty('distance_unit');
    }

    public function setElapsedTime(int $et)
    {
        $this->setProperty('elapsed_time', $et);
    }

    public function getElapsedTime()
    {
        $this->getProperty('elapsed_time');
    }
}
