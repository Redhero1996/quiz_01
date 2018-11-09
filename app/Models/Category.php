<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
    ];

    public function topics()
    {
        return $this->hasMany(Topic::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
