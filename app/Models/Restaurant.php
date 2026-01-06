<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;

    protected $fillable = [
        'cuisine_id',
        'name',
        'slug',
        'address',
        'lat',
        'lng',
        'rating',
        'description',
    ];

    public function cuisine()
    {
        return $this->belongsTo(Cuisine::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
