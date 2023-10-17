<?php

namespace App\Http\Controllers\Resturant_staff;
use App\Http\Controllers\Controller;
use App\Models\Reaturant;
use Illuminate\Http\Request;
use App\Models\Table;
use App\Models\User;
use App\Models\Cuisine;
use Auth;
use App\Models\Menu;
use App\Models\Reservation;
use App\Models\Reviews;
class DashboardController extends Controller
{
    public function staff_statistics()
    {
        $tables='2';
        $total_price='2';
        $reserv='32';
        $customers='423';
        return view('staff.statistics',compact('tables','total_price','reserv','customers'));
    }
    public function staff_profile()
{
    $user=User::where('id',Auth::id())->first();
    if($user->role_name=="staff")
    {
        return view('staff.profile',compact('user'));
    }
    else
    {
        return view('Admin.profile',compact('user'));
    }
   
}
public function update_profile(Request $request)
{
    $user=User::where('id',Auth::id())->first();
    $user->update([
        'name'=>$request->name,
        'phone'=>$request->phone,
    ]);
    return redirect()->back();

}
}
