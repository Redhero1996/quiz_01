<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $perPage;

    protected $fillable = [
        'name',
        'slug',
        'category_id',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->perPage = config('pagination.topic');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class)->withTimestamps();
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot([
            'id',
            'answered',
            'total',
        ]);
    }

    public function getCreatedAtAttribute()
    {
        $dateTime = explode(' ', $this->attributes['created_at']);
        $date = explode('-', $dateTime[0]);
        $result = [];
        $result['year'] = $date[0];
        $result['month'] = $date[1];
        $result['day'] = $date[2];

        return $result;
    }
}
