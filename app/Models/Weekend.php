<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Weekend extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'weekends' => 'array',
    ];

    public function setWeekendsAttribute($value)
    {
        $this->attributes['weekends'] = json_encode($value);
    }

    public function getWeekendsAttribute($value)
    {
        return json_decode($value);
    }
}
