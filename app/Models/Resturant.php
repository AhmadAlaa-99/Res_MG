<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Table;
use App\Models\Image;
use App\Models\Reservation;
use App\Models\Location;
use App\Models\times;

class Resturant extends Model
{
    use HasFactory;
    protected $guarded=[''];
 
    public function cuisine()
        {
            return $this->belongsTo(Cuisine::class);
        }
    public function staff()  //staff
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function menu()
    {
        return $this->hasMany(Menu::class,'resturant_id');
    }
    public function tables()
    {
        return $this->hasMany(Table::class,'resturant_id');
    }
    public function images()
    {
        return $this->hasMany(Image::class,'imageable_id');
    }
    public function reviews()
    {
        return $this->hasMany(Reviews::class,'resturant_id');
    }
    public function reservations()
    {
        return $this->hasMany(Reservation::class,'resturant_id');
    }
    public function location()  //staff
    {
        return $this->hasOne(Location::class,'resturant_id');
    }
    public function times()  //staff
    {
        return $this->hasMany(times::class,'resturant_id');
    }
}
