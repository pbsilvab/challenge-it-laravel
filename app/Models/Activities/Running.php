<?php

namespace App\Models\Activities;

use Illuminate\Database\Eloquent\Model;

class Running extends Model
{
    public function validProperties() 
    {
        return [
            'distance' => 'required|string',
            'distance_unit' => 'required|string',
            'elapsed_time' => 'required|date',
        ];
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
        $this->setProperty('distanceUnit', $du);
    }
    
    public function getDistanceUnit()
    {
        $this->getProperty('distanceUnit');
    }

    public function setElapsedTime(int $et)
    {
        $this->setProperty('elapsedTime', $et);
    }

    public function getElapsedTime()
    {
        $this->getProperty('elapsedTime');
    }

}
