<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Table;
use App\Models\User;
use App\Models\Cuisine;
use Auth;
use App\Models\Menu;
use App\Models\Image;
use App\Models\Reservation;
use App\Models\Reviews;
use App\Models\Customer;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return 'fds';
        if(Auth::user()->role_name="staff")
        {
            return 'fds';
            return redirect()->route('staff_statistics');

        }
        if(Auth::user()->role_name=="admin")
        {
            $resturants_number=User::Where('role_name','staff')->count();
            $act=User::Where(
                ['role_name'=>'staff',
                'status'=>'active',
                ])->count();
            $reserv=Reservation::count();
            $customers=Customer::count();
            return view('Admin.statistics',compact('resturants_number','act','reserv','customers'));            
        }
   
    }
}
