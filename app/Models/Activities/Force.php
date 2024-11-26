<?php

namespace App\Models\Activities;

use Illuminate\Database\Eloquent\Model;

class Force extends Model
{
    public function validProperties() 
    {
        return [
            'weight_lifted' => 'required|int',
        ];
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
