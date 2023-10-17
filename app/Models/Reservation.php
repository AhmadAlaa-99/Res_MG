<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Table;
use App\Models\User;
use App\Models\Customer;
class Reservation extends Model
{
    use HasFactory;
    protected $guarded=[''];
    public function table()
    {
        return $this->belongsTo(Table::class);
    }
    public function user()
    {
        return $this->belongsTo(Customer::class,'customer_id');
    }
}