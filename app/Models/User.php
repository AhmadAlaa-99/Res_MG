<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Resturant;
class User extends Authenticatable
{
    use  HasRoles,HasApiTokens, HasFactory, Notifiable;        
    protected $fillable = [
        'name','email','password','role_name','status', 'phone','email_verified_at',
    ];
    public function resturant()
    {
        return $this->hasOne(Resturant::class);
    }

}
