<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ResturantRequest;
use App\Models\Table;
use Auth;
use Hash;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Cuisine;
use App\Models\Menu;
use App\Models\Image;
use App\Models\Reservation;
use App\Models\Reviews;
use App\Models\Location;
use App\Models\Customer;
use App\Models\Resturant;
use App\Notifications\Account_Active;
class DashboardController extends Controller
{
    public function statistics()
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
    public function index()
    {
    //    $resturants=User::All();
        $all=Resturant::with('cuisine','staff')->get();
       
        $status="active";
        $active=Resturant::with('cuisine','staff')->whereHas('staff', function ($query) use ($status) {
            $query->where('status','active');
        })->get();
     
        $status="inactive";
        $pending=Resturant::with('cuisine','staff')->whereHas('staff', function ($query) use ($status) {
            $query->where('status','inactive');
        })->get();
       // return $resturants
        return view('Admin.Resturants.index', compact('all','active','pending'));
    }

    public function show($id)
    {
        $Resturant=Resturant::where('id',$id)->with('cuisine','staff','menu','location')->first();
     
        return view('Admin.Resturants.show', compact('Resturant'));
    }
    
    public function create()
    {
        
        $cuisins=Cuisine::all();
        return view('Admin.Resturants.create', compact('cuisins'));
    }

    public function store(Request $request)
    {
    // try {
      // resturant : name - description - location(text - map ) - cuisine(type) - images
      User::create([
        'name'=>$request->user_name,
        'email'=>$request->email,
        'phone'=>$request->user_phone,
        'password'=>bcrypt($request->password),
        'role_name'=>'staff',
        'status'=>'active',
      ]);
      $user=User::latest()->first();
     

      Resturant::create([
        'user_id'=>$user->id,
        'cuisine_id'=>$request->cuisine_id,
        'description'=>$request->description,
        'name'=>$request->resturant_name,
        'Activation_start'=>$request->Activation_start,
        'Activation_end'=>$request->Activation_end,
        'phone_number'=>$request->resturant_phone,
        'deposit'=>$request->deposite
      //  'work_time'=>$request->work_time,
        //'images'=>$request->images,
      ]);
    $resturant=Resturant::latest()->first();
    $user= User::latest()->first(); 
      if($request->hasfile('images'))
      {
          foreach($request->file('images') as $file)
          {
              $name = $file->getClientOriginalName();
              $file->storeAs('attachments/resturants/'.$resturant->name, $file->getClientOriginalName(),'upload_images');
              // insert in image_table
              $images= new Image();
              $images->filename=$name;
              $images->imageable_id= $resturant->id;
              $images->imageable_type='App\Models\Resturant';
              $images->save();
          }
      }
      if($request->hasfile('logo'))
      {
              $file=$request->file('logo');
              $name = $file->getClientOriginalName();
              $file->storeAs('attachments/resturants/'.$resturant->name, $file->getClientOriginalName(),'upload_images');
              // insert in image_table
              $image= new Image();
              $image->filename=$name;
              $image->imageable_id= $resturant->id;
              $image->type='logo';
              $image->imageable_type='App\Models\Resturant';
              $image->save();
      }
    $resturant=Resturant::latest()->first();
    Location::create([
        'resturant_id'=>$resturant->id,
        'latitude'=>$request->latitude,
        'longitude'=>$request->longitude,
        'state'=>$request->state,
        'text'=>$request->location,
    ]);
      //$user->notify(new Account_Active());
      switch ($request->input('action')) {
        case 'more_add':
            return redirect()->route('resturants.create');
            break;

        case 'add_and_cancel':
            return redirect()->route('resturants.index');
            break;  }
    //}
   // catch (\Exception $e)
//     {
//         return redirect()->back()->withErrors(['error' => $e->getMessage()]);
//  }
    }
    public function edit($id)
    {
        $cuisins=Cuisine::all();
        $Resturant=Resturant::where('id',$id)->with('cuisine','staff','menu')->first();
        return view('Admin.Resturants.edit', compact('Resturant','cuisins'));
    }
    public function update(Request $request,$id)
    { 
        switch ($request->input('action')) {
            case 'Save':
                
                $resturant=Resturant::where('id',$id)->first();
            
                $resturant=Resturant::where('id',$id)->update([
                    'cuisine_id'=>$request->cuisine_id,
                    'description'=>$request->description,
                    'name'=>$request->Resturant_name,
                 
                    'Activation_start'=>$request->Activation_start,
                    'Activation_end'=>$request->Activation_end,
                    'phone_number'=>$request->Resturant_phone,
                ]);
                $resturant = Resturant::find($id);
                $userid = $resturant->user_id;
              
                $user=User::where('id',$userid)->update([
                     'name'=>$request->user_name,
                     'email'=>$request->email,
                     'phone'=>$request->user_phone,
                      'password'=>bcrypt($request->password),
         
                  ]);
                  if($request->hasfile('images'))
                  {
                      foreach($request->file('images') as $file)
                      {
                          $name = $file->getClientOriginalName();
                          $file->storeAs('attachments/resturants/'.$resturant->name, $file->getClientOriginalName(),'upload_images');
                          // insert in image_table
                          $images= new Image();
                          $images->filename=$name;
                          $images->imageable_id= $resturant->id;
                          $images->imageable_type='App\Models\Resturant';
                          $images->save();
                      }
                  } 
                  return redirect()->route('resturants.show',$id);
                break;
    
            case 'Cancel':
                return redirect()->route('resturants.index');
                break;
            }
    }
    public function destroy($id)
    {

        $resturant=Resturant::where('id',$id)->delete();
        return redirect()->route('resturants.index');
    }   
    public function update_profile_admin(Request $request)
    { 
        $user=User::where('id',Auth::id())->first();
        return $request->name;
        $user->update([
            'name'=>$request->name,
            'phone'=>$request->phone,
            'email'=>$request->email,
            'password'=>bcrypt($request->password),
         
        ]);
        return redirect()->back();
    }
    public function active($id)
    {
        $user=User::where('id',$id)->update([
                   'status'=>'active'
        ]);
    }

    public function in_active($id)
    {
        $user=User::where('id',$id)->update([
            'status'=>'inactive'
        ]);
    }

    public function check_account()  //jop every 12 
    {
        Resturant::all();
    }

    public function rest_tables($id)  //id resturant
    {
       
        $res=Resturant::where('id',$id)->first();
        $res_id=$res->id;
        $tables=Table::where('resturant_id',$res->id)->get();
        return view('staff.Tables.index', compact('tables','res_id'));
    }

    public function table_details($id)   //id table
    {
        $table=Table::where('id',$id)->first();
        return view('Admin.Resturants.table_details',compact('table'));
    }
    

public function staff_all()
{
    $users=User::where('role_name','staff')->with('resturant')->get();
    return view('Admin.Users.staff',compact('users'));

}
public function customers()
{
    $users=Customer::get();
    return view('Admin.Users.customers',compact('users'));

}
public function table_add(Request $request,$id)
{
    $res_id=$id;
    return view('Admin.Tables.create',compact('res_id'));
   
    return redirect()->route('rest_tables',$id);
}

public function table_store(Request $request,$id)
{
    Table::create([
          'number'=>$request->number,
          'resturant_id'=>$id,
          'seating_configuration'=>$request->seating_configuration,
          'capacity'=>$request->capacity,
    ]);
    switch ($request->input('action')) {
        case 'more_add':
            return redirect()->route('table_add',$id);
            break;

        case 'add_and_cancel':
            return redirect()->route('rest_tables',$id);
            break;
        }
}
public function resturant_reservations($id)
{
    $today=Carbon::now();
    $res_id=$id;
    $res=Resturant::where('id',$id)->with('tables')->first();
    $reservations=Reservation::where([
        'reservation_date'=>$request->date ?? $today,
        'resturant_id'=>$res->id,
        ])->with('table')->get(); 
        $tables = Table::where('resturant_id', $res->id)
        ->whereHas('reservations', function ($query) use ($today) { 
            $query->whereDate('reservation_date', $today); 
        })
        ->with(['reservations' => function ($query) use ($today) {
            $query->whereDate('reservation_date', $today);
        }])
        ->get();
        return view('Admin.Reservations.index',compact('reservations','tables','today','id'));
}
public function dat_reservations(Request $request,$id)
{
    $today=$request->date;
    $res=Resturant::where('id',$id)->with('tables')->first();
    $reservations=Reservation::where([
        'reservation_date'=>$request->date,
        'resturant_id'=>$id,
        ])->with('table')->get(); 
        $tables = Table::where('resturant_id',$id)
        ->whereHas('reservations', function ($query) use ($today) { 
            $query->whereDate('reservation_date', $today); 
        })
        ->with(['reservations' => function ($query) use ($today) {
            $query->whereDate('reservation_date', $today);
        }])
        ->get();
        return view('Admin.Reservations.index',compact('reservations','tables','today','id'));

}
public function table_reservations($id)
{
//     user_id
// table_id
// resturant_id
// speacial_request
// actual_price
// reservation_time// party_size// status
}
public function act_inact__resturant($id)
{
$resturant=Resturant::where('id',$id)->first();
$staff=User::where('id',$resturant->user_id)->first();
if($staff->status=="active")
{
    $staff->update(['status'=>'inactive']);
    //notify email
}
else
{
    $staff->update(['status'=>'active']);
        //notify email
}
return redirect()->route('resturants.index');  
}
public function admin_profile()
{
    $user=User::where('id',Auth::id())->first();
    return view('Admin.profile',compact('user'));
}
public function all_notifications()
{
    return view('notifications');
}
public function getNotifications()
{
    return [
        'read'      => auth()->user()->readNotifications,
        'unread'    => auth()->user()->unreadNotifications,
        'usertype'  => auth()->user()->role_name,
    ];
}

public function markAsRead(Request $request)
{
    return auth()->user()->notifications->where('id', $request->id)->markAsRead();
}

// public function markAsReadAndRedirect($id)
// {
//     $notification = auth()->user()->notifications->where('id', $id)->first();
//     $notification->markAsRead();

//     if (auth()->user()->roles->first()->name == 'user') {

//         if ($notification->type == 'App\Notifications\NewCommentForPostOwnerNotify') {
//             return redirect()->route('users.comment.edit', $notification->data['id']);
//         } else {
//             return redirect()->back();
//         }
//     }

// }



}
