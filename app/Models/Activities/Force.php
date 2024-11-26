<?php

namespace App\Models\Activities;

use Illuminate\Database\Eloquent\Model;
use App\Models\FitnessActivity;

class Force extends FitnessActivity
{
    public function validProperties() 
    {
        return [
            'weight_lifted' => 'required|int',
        ];
    }

    public function completeValues(Force $instancia, array $values) 
    {
        $instancia->user_id = \Auth::user()->id;
        $instancia->setExercise($values['name']);
        $instancia->activity_type = $values['activity_type'];
        $instancia->activity_date = $values['activity_date'];
        $instancia->type = $this->activityType();
        $instancia->setWeightLifted($values['weight_lifted']);
        
        return  $instancia;
    }

    public function activityType()
    {
        return Force::class;
    }

    public function setWeightLifted(float $weight)
    {
        $this->setProperty('weight_lifted', $weight);
    }

    public function getWeightLifted()
    {
        return $this->getProperty('weight_lifted');
    }

    public function setExercise(string $name)
    {
        return $this->name = $name;
    }

    public function getExercise()
    {
        return $this->name;
    }
}
