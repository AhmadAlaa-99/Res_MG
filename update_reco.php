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
                       
        
                    return view('staff.work_time',compact('times'));
                return redirect()->route('tables.create');
                break;
             case 'regenerate';
             return redirect()->route('records_reservations');
             
             break;
            case 'cancel':
                return redirect()->route('today_reservations');
                break;
            }
      
        }
        public function update(Request request )
        Resturant : id name 
Reservations : customer_id - table_id - resturant_id - speacial_request - actual_price - reservation_time - reservation_date - party_size- status.
Times :  
id resturant_id date_start sat_from 
sat_to sun_from sun_to mon_from mon_to tue_from tue_to wed_from wed_to thu_from thu_to fri_from fri_to

One to many : time to reservations 
when update times :Request(time_id - sat_from - sat_end(or sun - mon -tue...))
i check all reserations for this time and check them accordin by today(sat-mon-..) accord cy request 
delete all reservation and regenerate but condition all reservation status=scheduled












public function updateTimes(Request $request)
{
    $restaurant = Restaurant::where('user_id', Auth::id())->first();
    $times = Times::find($request->input('time_id'));

    $times->sat_from = $request->input('sat_from');
    $times->sat_to = $request->input('sat_to');

    $times->save();

    Reservation::where('resturant_id', $restaurant->id)
        ->whereDate('reservation_date', '>=', $times->date_start)
        ->whereDate('reservation_date', '<=', $times->date_end)
        ->whereDay('reservation_date', Carbon::SATURDAY)
        ->where('status', 'scheduled')
        ->delete();

    // Generate new reservations for the updated time slots
    foreach ($restaurant->tables as $table) {
        $startDate = Carbon::parse($times->date_start);
        $endDate = Carbon::parse($times->date_end);
        $daysDiff = $startDate->diffInDays($endDate);

        for ($i = 0; $i <= $daysDiff; $i++) {
            $reservationDate = $startDate->addDays($i);
            $dayName = strtolower($reservationDate->format('D'));
            $startTime = Carbon::parse($times->{$dayName . '_from'});
            $endTime = Carbon::parse($times->{$dayName . '_to'});
            $totalRecords = $startTime->diffInMinutes($endTime) / 30;

            for ($j = 0; $j < $totalRecords; $j++) {
                $reservation = new Reservation();
                $reservation->table_id = $table->id;
                $reservation->resturant_id = $restaurant->id;
                $reservationTime = $startTime->addMinutes(30 * $j); 
                $reservation->reservation_time = $reservationTime->format('H:i');
                $reservation->reservation_date = $reservationDate->copy()->setTimeFromTimeString($reservationTime->toTimeString());
                $reservation->status = 'scheduled';
                $reservation->save();
            }
        }
    }

    // Redirect or return a response as needed
}
