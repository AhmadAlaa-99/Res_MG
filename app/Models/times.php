<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class times extends Model
{
    use HasFactory;
    protected $guarded=[''];
    public function resturant()  //resturant
    {
        return $this->belongsToMany(Resturant::class,'resturant_id');
    }
}
