<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cuisine extends Model
{

    use HasFactory;

    protected $guarded =[];

     public function restaurants()
    {
        return $this->hasMany(Restaurant::class);
    }
}
