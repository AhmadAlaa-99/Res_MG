<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens; 
class Customer extends Authenticatable
{
   
    use HasApiTokens, HasFactory, Notifiable;        
    // protected $fillable = [
    //     'name','email','password','phone','email_verified_at',
    // ];
    protected $guarded=[];
}
