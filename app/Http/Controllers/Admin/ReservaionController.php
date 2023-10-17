<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Table;
use Hash;
use App\Models\User;
use App\Models\Cuisine;
use App\Models\Menu;
use App\Models\Image;
use App\Models\Reservation;
use App\Models\Reviews;
use App\Models\Resturant;
class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $reservations=Reservation::with('cuisine','staff')->get();
        return view('Admin.Resturants.index', compact('reservations'));
    }
    public function show()
    {
        $Resturant=Resturant::where('id',$id)->with('cuisine','staff','menu')->first();
        return view('Admin.Resturants.show', compact('Resturant'));
    }
    public function create()
    {   
        $cuisins=Cuisine::all();
        return view('Admin.Resturants.create', compact('cuisins'));
    }
    public function store(Request $request)
    {
     try {
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
        'location'=>$request->location,
        'Activation_start'=>$request->Activation_start,
        'Activation_end'=>$request->Activation_end,
        'phone_number'=>$request->resturant_phone,
      //  'work_time'=>$request->work_time,
        //'images'=>$request->images,
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
      switch ($request->input('action')) {
        case 'more_add':
            return redirect()->route('resturants.create');
            break;

        case 'add_and_cancel':
            return redirect()->route('resturants.index');
            break;
        }
    }
    catch (\Exception $e)
    {
        return redirect()->back()->withErrors(['error' => $e->getMessage()]);
 }
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
                    'location'=>$request->location,
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
    public function delete($id)
    {

        $resturant=Resturant::where('id',$id)->destroy();
        return redirect()->route('resturants.index');

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
//  number
// seating_configuration
// capacity
        $res_id=$id;
        $tables=Table::where('resturant_id',$id)->get();
        return view('Admin.Tables.rest_tables',compact('tables','res_id'));
    }

    public function table_details($id)   //id table
    {
        $table=Table::where('id',$id)->first();
        return view('Admin.Resturants.table_details',compact('table'));
    }
    

public function staff_all()
{
    $users=User::where('role_name','staff')->get();
    return view('Admin.Users.staff',compact('users'));

}
public function customers()
{
    $users=User::where('role_name','customer')->get();
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
public function table_reservations($id)
{

//     user_id
// table_id
// resturant_id
// speacial_request
// actual_price
// reservation_time
// party_size
// status

}


}
