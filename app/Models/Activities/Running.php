<?php

namespace App\Models\Activities;

use Illuminate\Database\Eloquent\Model;
use App\Models\FitnessActivity;

class Running extends FitnessActivity
{
    public function validProperties() 
    {
        return [
            'distance' => 'required|string',
            'distance_unit' => 'required|string',
            'elapsed_time' => 'required|int',
        ];
    }

    public function completeValues(Running $instancia, array $values) 
    {
        $instancia->user_id = \Auth::user()->id;
        $instancia->name = $values['name'];
        $instancia->activity_type = $values['activity_type'];
        $instancia->activity_date = $values['activity_date'];
        $instancia->type = $this->activityType();
        $instancia->setDistance($values['distance']);
        $instancia->setDistanceUnit($values['distance_unit']);
        $instancia->setElapsedTime($values['elapsed_time']);
        
        return  $instancia;
    }
    
    public function activityType()
    {
        return Running::class;
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
