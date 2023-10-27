<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Resturant;
use App\Models\times;
use Carbon\Carbon;
class UpdateResturantTimes implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle() 
    {
        $today = Carbon::now()->format('D'); // Get current day of the week
        $today_from = strtolower($today) . '_from';
        $today_to = strtolower($today) . '_to';
        // Get all Resturants with their times
        $Resturants = Resturant::with('times')->get();

        foreach ($Resturants as $Resturant) {
            foreach ($Resturant->times as $time) {
                // Check if the current date is within the date range for this time entry
                if (Carbon::now()->between(Carbon::parse($time->date_start), Carbon::parse($time->date_end))) {
                    $Resturant->time_start = $time->{$today_from};
                    $Resturant->time_end = $time->{$today_to};
                    $Resturant->save();
                    break; // Assuming only one time entry per day for a Resturant
                }
            }
        }
    }
    // ```bash
    // php artisan tinker
    // >>> dispatch(new App\Jobs\UpdateResturantTimes());
}
