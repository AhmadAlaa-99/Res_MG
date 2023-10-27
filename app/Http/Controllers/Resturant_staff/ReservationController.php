<?php
namespace App\Http\Controllers\Resturant_staff;
use App\Http\Controllers\Controller;
use App\Models\Resturant;
use Illuminate\Http\Request;
use App\Models\Table;
use App\Models\User;
use App\Models\Cuisine;
use Carbon\Carbon;
use Auth;
use App\Models\times;
use App\Models\Menu;
use App\Models\Reservation;
use App\Models\Reviews;
use Illuminate\Support\Facades\Validator;
class ReservationController extends Controller
{
    public function today_reservations($id)
    {
        $today=Carbon::now();
        $id=$id;
        $res=Resturant::where('id',$id)->with('tables')->first();
        $reservations=Reservation::where([
           'reservation_date'=>$today,
            'resturant_id'=>$id,
            ])->with('table')->get(); 
            $tables = Table::where('resturant_id', $id)
            ->whereHas('reservations', function ($query) use ($today) { 
                $query->whereDate('reservation_date', $today); 
            })->with(['reservations' => function ($query) use ($today) {
                $query->whereDate('reservation_date', $today);
            }])
            ->get(); 

            return view('staff.Reservations.index',compact('reservations','tables','today','id'));
     }

    public function date_reservations(Request $request)
    {
        $today=$request->date;
        $id=$request->res_id;
        $res=Resturant::where('id',$id)->with('tables')->first();

        $reservations=Reservation::where([
            'reservation_date'=>$request->date,
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
            //laravel : problem get all reservations all days not $today just
   
        
            return view('staff.Reservations.index',compact('reservations','tables','today','id'));
    }
    public function delete($id)
    {
        $table=Table::where('id',$id)->destroy();
        return redirect()->route('tables.index');
    }  
    public function index()
    {}

    public function reservations_generate(Request $request,$id)
    {  
        $resturant = Resturant::where('id',$id)->first();
        $times=times::where('resturant_id',$resturant->id)->first();
        $id=$id;
        return view('staff.work_time',compact('times','id'));
        }
    //     $resturant=Resturant::where('user_id',Auth::id())->first();
         
    //       foreach ($resturant->tables as $table) {
    //         $start = Carbon::parse($request->start);
    //         $end = Carbon::parse($request->end);
    //         $timeSlots = $start->diffInMinutes($end) / 30;
        
    //         for ($i = 0; $i < $timeSlots; $i++) {
    //             $reservation = new Reservation();
    //             $reservation->table_id = $table->id;
    //             $reservation->resturant_id = $resturant->id;
    //             $reservation->reservation_time = $start->format('H:i');
    //                $start->addMinutes(30);
    //             $reservation->save();
    //         }
          
    // }
    // return redirect()->route('today_reservations');
    

public function reservations_regenerate(Request $request)
{
    $resturant = Resturant::where('user_id', Auth::id())->first();
    $times=times::where('resturant_id',$resturant->id)->first();
    return view('staff.regenerate',compact('times'));
}
public function reservations_regenerate_post(Request $request)
{
    switch ($request->input('action')) {
        case 'submit':

            break;
            case 'generate':
                return redirect()->route('reservations_generate_get');
                break;
                case 'cancel':
                    return redirect()->route('today_reservations');
                    break;

}
}   
    public function reservations_generate_post(Request $request)
    {
        switch ($request->input('action')) {
            case 'submit':
         $rules = [
        'date_start' => 'required|date|after:today',
        'date_end' => 'required|date|after:date_start|before:+1 month',

        'sun_from' => 'required|date_format:H:i',
        'sun_to' => 'required|date_format:H:i|after:sun_from',

        'sat_from' => 'required|date_format:H:i',
        'sat_to' => 'required|date_format:H:i|after:sat_from',

        'mon_from' => 'required|date_format:H:i',
        'mon_to' => 'required|date_format:H:i|after:mon_from',

        'tue_from' => 'required|date_format:H:i',
        'tue_to' => 'required|date_format:H:i|after:tue_from',

        'wed_from' => 'required|date_format:H:i',
        'wed_to' => 'required|date_format:H:i|after:wed_from',

        'thu_from' => 'required|date_format:H:i',
        'thu_to' => 'required|date_format:H:i|after:thu_from',

        'fri_from' => 'required|date_format:H:i',
        'fri_to' => 'required|date_format:H:i|after:fri_from',
    ];
    // $messages = [
    //     'date_start.after' => 'تاريخ البداية يجب أن يكون من الغد فقط.',
    //     'date_end.before' => 'الفترة بين تاريخ البداية وتاريخ النهاية لا يجب أن تتجاوز شهر.',
    //     'sat_to.after','sun_to.after','mon_to.after' => 'وقت نهاية العمل اليوم  يجب أن يكون بعد وقت البداية.',
    // ];
    $validator = Validator::make($request->all(), $rules);
    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput(); }
                $resturant = Resturant::where('id',$request->res_id)->first();
                $times = Times::create([
                    'resturant_id' => $resturant->id,
                    'date_start' => $request->date_start,
                    'date_end' => $request->date_end,
                    'sat_from' => $request->sat_from,
                    'sat_to' => $request->sat_to,
                    'sun_from' => $request->sun_from,
                    'sun_to' => $request->sun_to,
                    'mon_from' => $request->mon_from,
                    'mon_to' => $request->mon_to,
                    'tue_from' => $request->tue_from,
                    'tue_to' => $request->tue_to,
                    'wed_from' => $request->wed_from,
                    'wed_to' => $request->wed_to,
                    'thu_from' => $request->thu_from,
                    'thu_to' => $request->thu_to,
                    'fri_from' => $request->fri_from,
                    'fri_to' => $request->fri_to,
                ]);
                // مصفوفة بأوقات البداية والنهاية لكل يوم من أيام الأسبوع
                $daysTimes = [
                    'sat' => ['from' => $times->sat_from, 'to' => $times->sat_to],
                    'sun' => ['from' => $times->sun_from, 'to' => $times->sun_to],
                    'mon' => ['from' => $times->mon_from, 'to' => $times->mon_to],
                    'tue' => ['from' => $times->tue_from, 'to' => $times->tue_to],
                    'wed' => ['from' => $times->wed_from, 'to' => $times->wed_to],
                    'thu' => ['from' => $times->thu_from, 'to' => $times->thu_to],
                    'fri' => ['from' => $times->fri_from, 'to' => $times->fri_to],
                ];
                foreach ($resturant->tables as $table) 
                {
                    $startDate = Carbon::parse($times->date_start);
                    $endDate = Carbon::parse($times->date_end);
                    // حساب الفرق بين تاريخ البداية وتاريخ النهاية بالأيام
                    $daysDiff = $startDate->diffInDays($endDate);
                    
                
                    for ($i = 0; $i <= $daysDiff; $i++) {
                      
                        $reservationDate = $startDate->addDays($i);
                        // الحصول على اسم اليوم لتحديد أوقات البداية والنهاية المناسبة
                        $dayName = strtolower($reservationDate->format('D'));
                        $startTime = Carbon::parse($daysTimes[$dayName]['from']);
                        $endTime = Carbon::parse($daysTimes[$dayName]['to']);
                        // حساب عدد السجلات المراد إنشاؤها لهذا اليوم
                        $totalRecords = $startTime->diffInMinutes($endTime) / 30;
                        for ($j = 0; $j < $totalRecords; $j++) {
                            $reservation = new Reservation();
                            $reservation->table_id = $table->id;
                            $reservation->resturant_id = $resturant->id;
                            // إضافة نصف ساعة إلى وقت الحجز
                            $reservationTime = $startTime->addMinutes(30 * $j); 
                            $reservation->reservation_time =  $reservationTime->format('H:i');
                             $reservation->reservation_date = $reservationDate->copy()->setTimeFromTimeString
                             ($reservationTime->toTimeString());
                               $reservation->save();
                               //    return redirect()->route('today_reservations');               
                        }
                    }
                    }
                    
                    $times=times::where('resturant_id',$resturant->id)->first();
                    
               return redirect()->route('reservations_generate_get',$resturant->id);
                break;
             case 'regenerate';
             return redirect()->route('records_reservations',$request->res_id);
             
             break;
            case 'cancel':
                return redirect()->route('today_reservations',$request->res_id);
                break;
            }
      
        }
    public function show($id)
    { 
        $reservation=Reservation::where('id',$id)->with('user')->first();
        return view('staff.Reservations.show',compact('reservation'));
     }
    public function create()
    {
      
     


              // : input hidden 
              //   input hidden 
                //  inpu hidden 
              // reservation_time input 
            
             
        
        //
        /*
        return view('staff.Reservations.create');
        */
    }
   
    public function store(Request $request)
    {
      
     // speacial_request
    // actual_price
    // reservation_time
    // party_size
    // status
    /*
        $user=Auth::user()->id;
        $res=Resturant::where('id',$user_id)->first();
     try {
      Reservations::create([
        'user_id'=>$request->user_id,
        'resturant_id'=>$res->id,
        'table_id'=>$request->table_id,
        'seating_configuration'=>$request->seating_configuration,
        'capacity'=>$request->capacity,
      ]);
      switch ($request->input('action')) {
        case 'more_add':
            return redirect()->route('tables.create');
            break;

        case 'add_and_cancel':
            return redirect()->route('tables.index');
            break;
        }
    }
    catch (\Exception $e)
    {
        return redirect()->back()->withErrors(['error' => $e->getMessage()]);
 }
 */
    }
    public function edit($id)
    {
       
        // $table=Table::where('id',$id)->first();
        // return view('staff.Tables.edit', compact('Resturant','cuisins'));
    }
    public function update(Request $request,$id)
    { 
        // switch ($request->input('action')) {
        //     case 'Save':
        
        //         $table=Table::where('id',$id)->update([
        //             'number'=>$request->number,
        //             'seating_configuration'=>$request->seating_configuration,
        //             'capacity'=>$request->capacity,
        //         ]);
               
        //           return redirect()->route('tables.show',$id);
        //         break;
    
        //     case 'Cancel':
        //         return redirect()->route('tables.index');
        //         break;   
        //  }        
    }
    public function reservations_start($id)
    {
        Reservation::where('id',$id)->update([
            'status'=>'current',
        ]);
        return redirect()->back();
    }
    public function reservations_end($id)
    {
        Reservation::where('id',$id)->update([
            'status'=>'finite',
        ]);
        return redirect()->back();

    }     
    public function reservations_start_ajax($id)
{
    Reservation::where('id',$id)->update([
        'status'=>'current',
    ]);

    return response()->json(['message' => 'Reservation started successfully']);
}

public function reservations_end_ajax($id)
{
    Reservation::where('id',$id)->update([
        'status'=>'finite',
    ]);
    return response()->json(['message' => 'Reservation ended successfully']);
}
public function records_reservations(Request $request,$id)
{
    $times=times::where('resturant_id',$id)->get();
    $resturant=Resturant::where('id',$id)->first();
    return view('staff.Reservations.records',compact('times','resturant'));
}
public function record_update(Request $request)
{
    $time=times::where('id',$request->time);
    //after accept (relation with time)
    //reservation : timex
}
}