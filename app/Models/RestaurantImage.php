<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RestaurantImage extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $fillable =['resturant_id','path','caption'];
  
    public function restaurant()
    {
    return $this->belongsTo(Restaurant::class);
    }

}
