<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Table;
use App\Models\Image;

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

}
