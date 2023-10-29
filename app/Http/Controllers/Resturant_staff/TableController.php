<?php

namespace App\Http\Controllers\Resturant_staff;
use App\Http\Controllers\Controller;
use App\Models\Resturant;
use Illuminate\Http\Request;
use App\Models\Table;
use App\Models\User;
use App\Models\Cuisine;
use App\Models\Menu;
use Auth;
use App\Http\Requests\TableRequest;
use Carbon\Carbon;
use App\Models\Reservation;
use App\Models\Reviews;
class TableController extends Controller
{
//     number
// resturant_id
// seating_configuration
// capacity
    public function today_tables($id)
    {
        $today=carbon::now();
        $tab=Table::where('id',$id)->first();
        $table = Table::where('id',$id)
        ->whereHas('reservations', function ($query) use ($today) { 
            $query->whereDate('reservation_date', $today); 
        })
        ->with(['reservations' => function ($query) use ($today) {
            $query->whereDate('reservation_date', $today);
        }])
        ->first();
        return view('staff.Tables.show', compact('table','today','tab'));
    }
    public function date_tables(Request $request,$id) 
    {      
        $tab=Table::where('id',$id)->first();
        $today=$request->date;
      
        $table = Table::where('id',$id)
        ->whereHas('reservations', function ($query) use ($today) { 
            $query->whereDate('reservation_date', $today); 
        })
        ->with(['reservations' => function ($query) use ($today) {
            $query->whereDate('reservation_date', $today);
        }])
        ->first();
        
        return view('staff.Tables.show', compact('table','today','tab'));
    }
    public function index(Request $request)
    {
        return $request->all();
        $res=Resturant::where('id',$request->res_id)->first();
        $res_id=$res->id;
        
        $tables=Table::where('resturant_id',$res->id)->get();
        return view('staff.Tables.index',['tables' => $tables,'res_id' => $res_id]);
    }

    public function show($id)
    {
        $today=carbon::now();
        $table=Table::where('id',$id)->with('reservations')->first();
        return view('staff.Tables.show', compact('table','today'));
    }
    public function create(Request $request)
    {
        $res_id=$request->res_id;
        return view('staff.Tables.create',compact('res_id'));
    }
    public function store(TableRequest $request)
    {

        //$user=Auth::user()->id;
     //   $res=Resturant::where('user_id',$user)->first();
     try {
      Table::create([
        'number'=>$request->number,
        'resturant_id'=>$request->res_id,
        'seating_configuration'=>$request->seating_configuration,
        'capacity'=>$request->capacity,
      ]);
     // toastr()->success(trans('messages.success'));
      switch ($request->input('action')) {
        case 'more_add':
            return redirect()->route('tables.create',['res_id' => $res_id]);
            break;
        case 'add_and_cancel':
            return redirect()->route('rest_tables');
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
       
        $table=Table::where('id',$id)->first();
        return view('staff.Tables.edit', compact('table'));
    }
    public function update(Request $request,$id)
    { 
        switch ($request->input('action')) {
            case 'submit':
                $table=Table::where('id',$id)->update([
                    'number'=>$request->number,
                    'seating_configuration'=>$request->seating_configuration,
                    'capacity'=>$request->capacity,
                ]);
                  return redirect()->route('today_tables',$id);
                break;
            case 'cancel':
                return redirect()->route('tables.index');
                break;
            }  
    }
    public function destroy($id)
    {
      
        $table=Table::where('id',$id)->delete();
        return redirect()->route('tables.index');
    }   

}
