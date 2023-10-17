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
class ReservationController extends Controller
{
    public function today_reservations()
    {
        $today=Carbon::now();
        $user_id=Auth::user()->id;
        $res=Resturant::where('user_id',$user_id)->with('tables')->first();
        $reservations=Reservation::where([
           'reservation_date'=>$today,
            'resturant_id'=>$res->id,
            ])->with('table')->get(); 
            $tables = Table::where('resturant_id', $res->id)
            ->whereHas('reservations', function ($query) use ($today) { 
                $query->whereDate('reservation_date', $today); 
            })->with(['reservations' => function ($query) use ($today) {
                $query->whereDate('reservation_date', $today);
            }])
            ->get(); 
            return view('staff.Reservations.index',compact('reservations','tables','today'));
     }

    public function date_reservations(Request $request)
    {
        $today=$request->date;
        $user_id=Auth::user()->id;
        $res=Resturant::where('user_id',$user_id)->with('tables')->first();
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
   
        
            return view('staff.Reservations.index',compact('reservations','tables','today'));
    }
    public function delete($id)
    {
        $table=Table::where('id',$id)->destroy();
        return redirect()->route('tables.index');
    }  
    public function index()
    {}

    public function reservations_generate(Request $request)
    {  
        $resturant = Resturant::where('user_id', Auth::id())->first();
        $times=times::where('resturant_id',$resturant->id)->first();
        return view('staff.work_time',compact('times'));
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
    
    
    public function reservations_generate_post(Request $request)
    {
        switch ($request->input('action')) {
            case 'submit':
                
                $resturant = Resturant::where('user_id', Auth::id())->first();
                
                

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
                foreach ($resturant->tables as $table) {
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
                       
        
                    return view('staff.work_time',compact('times'));
                return redirect()->route('tables.create');
                break;
    
            case 'cancel':
                return redirect()->route('today_reservations');
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
}
