<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\resturant;

class Cuisine extends Model
{
    use HasFactory;
    protected $guarded=[''];
    public function resturants()
    {
        return $this->hasMany(Resturant::class);
    }
}
