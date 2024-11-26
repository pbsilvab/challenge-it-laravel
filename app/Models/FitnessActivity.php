<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FitnessActivity extends Model
{
    protected $fillable = [
        'type', 
        'activity_type', 
        'activity_date', 
        'name', 
        'name', 
        "properties"
    ];

    protected $casts = [
        'properties' => 'array',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Getter y Setter para propiedades custom de cada activity
    public function getProperty(string $key)
    {
        return $this->properties[$key] ?? null;
    }

    public function setProperty(string $key, $value)
    {
        $properties = $this->properties ?? [];
        $properties[$key] = $value;
        $this->properties = $properties;
    }
}
