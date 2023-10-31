<?php
namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\BaseController;
use App\Models\Table;
use Illuminate\Support\Facades\DB;
use Hash;
use Carbon\Carbon;
use App\Models\images_offers;
use App\Models\Cuisine;
use App\Models\offer;
use App\Models\Menu; 
use App\Models\Image;
use App\Models\Reservation;
use App\Models\Reviews;
use App\Models\Customer;
use App\Models\Resturant;
class UserController extends BaseController
{

   public function proposal_resturants(Request $request)
   {
      //حسب الموقع الاقرب والعمر المناسب
      $userBirthDate = Customer::where('id',Auth::guard('customer-api')->id())->first()->birth_date;
      $userAge = \Carbon\Carbon::parse($userBirthDate)->age;
      
      $userLatitude = 30.0444;   
      $userLongitude = 31.2357; 
      
   //    $forYouResturants = Resturant::select(
   //       'resturants.*',
   //       DB::raw('ABS(TIMESTAMPDIFF(YEAR,?, CURDATE())) - age_range AS age_difference'),
   //       DB::raw('(6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance')
   //   )
   //   ->join('locations', 'resturants.id', '=', 'locations.resturant_id')
   //   ->orderBy('age_difference')
   //   ->orderBy('distance')
   //   ->setBindings([$userAge,$userLatitude, $userLongitude, $userLatitude])
   //   ->with('cuisine','images','location')->get();
    
     $forYouResturants = Resturant::select(
      'resturants.*',
      DB::raw('ABS(TIMESTAMPDIFF(YEAR,?, CURDATE())) - age_range AS age_difference'),
      DB::raw('(6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance')
  )
  ->join('locations', 'resturants.id', '=', 'locations.resturant_id')
  ->orderBy('age_difference')
  ->orderBy('distance')
  ->setBindings([$userAge, $userLatitude, $userLongitude, $userLatitude])
  ->with(['cuisine', 'images' => function ($query) {
      $query->where('type', 'main');
  }, 'location'])
  ->get()
  ->map(function ($restaurant) {
      return [
          'id'=>$restaurant->id,
          'name'=>$restaurant->name,
          'deposite'=>$restaurant->deposit,
          'cuisine_name' => $restaurant->cuisine->name,
          'category' => $restaurant->category,
          'location_text' => $restaurant->location->text,
          'rating_number' => $restaurant->rating,
          'images' => $restaurant->images->pluck('filename') // Assuming you only want the file names
      ];
  });
  
$featuredResturants = Resturant::with(['cuisine', 'images' => function ($query) {
   $query->where('type', 'main');
}, 'location'])
->get()
->map(function ($restaurant) {
   return [
       'id'=>$restaurant->id,
       'name'=>$restaurant->name,
       'deposite'=>$restaurant->deposit,
       'cuisine_name' => $restaurant->cuisine->name,
       'category' => $restaurant->category,
       'location_text' => $restaurant->location->text,
       'rating_number' => $restaurant->rating,
       'images' => $restaurant->images->pluck('filename') // Assuming you only want the file names
   ];
});

//مطاعم حسب اختيارات المسستخدم في الحجوزات الأخرى 
$userId=Auth::guard('customer-api')->id();
$basedOnYourTasteResturants = Resturant::select(
   'resturants.*',
   DB::raw('ABS(TIMESTAMPDIFF(YEAR,?, CURDATE())) - age_range AS age_difference'),
   DB::raw('(6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance')
)
->join('locations', 'resturants.id', '=', 'locations.resturant_id')
->orderBy('age_difference')
->orderBy('distance')
->setBindings([$userAge,$userLatitude, $userLongitude, $userLatitude])->with(['cuisine', 'images' => function ($query) {
   $query->where('type', 'main');
}, 'location'])
->get()
->map(function ($restaurant) {
   return [
       'id'=>$restaurant->id,
       'name'=>$restaurant->name,
       'deposite'=>$restaurant->deposit,
       'cuisine_name' => $restaurant->cuisine->name,
       'category' => $restaurant->category,
       'location_text' => $restaurant->location->text,
       'rating_number' => $restaurant->rating,
       'images' => $restaurant->images->pluck('filename') // Assuming you only want the file names
   ];
});
$new_opening = DB::table('images_offers')
    ->join('offers', 'images_offers.imageable_id', '=', 'offers.id')
    ->select('images_offers.id','images_offers.imageable_id', 'images_offers.filename')
    ->where('offers.type', 'new_opening')
    ->where('images_offers.type', 'cover')
    ->get();
    $offers = DB::table('images_offers')
    ->join('offers', 'images_offers.imageable_id', '=', 'offers.id')
    ->select('images_offers.id', 'images_offers.imageable_id', 'images_offers.filename')
    ->where('offers.type', 'offer')
    ->where('images_offers.type', 'cover')
    ->get();
   // $resturants=Cuisine::with(['resturants' => function ($query) {
   // $query->select('id','name','time_start','time_end','deposit','rating')->with('location','images');}])->get();
   // return $this->sendResponse($resturants,'proposal_resturants');
   $data = [
      'forYouResturants' => $forYouResturants,
      'featuredResturants' => $featuredResturants,
      'basedOnYourTasteResturants' => $basedOnYourTasteResturants,
      'offers' => $offers,
      'new_opening' => $new_opening,
  ];
  // Return the associative array as a JSON response
  return response()->json($data);
   }
   public function details($id) //with viewMap
   {
      // -------------------------
      // Details Resturant :
      // Name - location - Services(icon with name)
      // Num rating - rating -menu 
      // suggestion resturants similiar 
      // --------------------------------  services - suggestion.
      // Details bOOK Res :
      // image - images - description - services(icon with names) -location on map - 
      // location - phone - website - insta - deposite_information - refund Policy 
      // change Policy - CANCELLED POLICY
      // -------------------------------

      //images - Name - State - City - Description -  RATING(NUM)-  Reviews (stars mumb - num reviews)
      $resturant = Resturant::select(['id','time_start','cuisine_id','time_end', 'name', 'description', 
      'age_range', 'category', 'phone_number', 'deposit', 'rating', 'services'])
      ->where('id', $id)
      ->with([
          'images' => function ($query) {
              $query->select(['id', 'filename', 'type', 'imageable_id']); // Include the foreign key
          },
         
          
          'location' => function ($query) {
              $query->select(['id', 'latitude', 'longitude', 'state', 'text', 'resturant_id']); // Include the foreign key
          },
          'reviews',
          'cuisine',
      ])
      ->withCount('reviews as count_reviews')
      ->first();
      $suggestions = Resturant::where('category',$resturant->category)->select(
         'resturants.*')
     ->join('locations', 'resturants.id', '=', 'locations.resturant_id')
     ->with(['cuisine', 'images' => function ($query) {
         $query->where('type', 'main');
     }, 'location'])
     ->get()
     ->map(function ($restaurant) {
         return [
             'id'=>$restaurant->id,
             'name'=>$restaurant->name,
             'deposite'=>$restaurant->deposit,
             'cuisine_name' => $restaurant->cuisine->name,
             'category' => $restaurant->category,
             'location_text' => $restaurant->location->text,
             'rating_number' => $restaurant->rating,
             'images' => $restaurant->images->pluck('filename') // Assuming you only want the file names
         ];
     });
      return $this->sendResponse(['resturant_details'=>$resturant,'suggestions'=>$suggestions],'resturant_details');
   }
   public function available_reservations(Request $request,$id)
    //Request : id_res - num_persons - date    return -times_availables
   {
      $reservations=Reservation::where(
         [
            'resturant_id'=>$id,
            'reservation_date'=>$request->date,
            'status'=>'scheduled',
         ])->get();
         if($reservations)
         {
            $reservations=$reservations->reservation_time;
            return $this->sendResponse($reservation,'reservation_details');
         }
         else
         {
            return'not found';
         }
   }

   public function reversation(Request $request,$id) //id reservation
   {
//       date - num person - st_time - end_time - location
// --.
// firstname - last - phone - cooments - PAYMENT_METHOD - CODE PROMO
// gROUP BROOKING AND TPTAL 
      $reservation=Reservation::where('id',$id)->first();
      $reservation->update([
         'customer_id'=>Auth::guard('customer-api')->id(),
         'speacial_request'=>'-',
         'status'=>'next',
      ]);
      return $this->sendResponse($reservation,'reservation_details');
   }
   public function follow($id) //id reservation
   {
      $resturant=Resturant::where('id',$id)->first();
    // Get the current array of followed restaurants
    $user=Auth::user();
    $followed = $user->followed_restaurants;
    // Add the new restaurant ID
    $followed[] = $id;
    // Remove duplicates, if any
    $followed = array_unique($followed);
    // Save back to the user
    $user->followed_restaurants = $followed;
    $user->save();
  }
  public function unfollow($id) //id reservation
  {
   $resturant=Resturant::where('id',$id)->first();
   $user=Auth::user();
   $followed = $user->followed_restaurants;
   // Remove the restaurant ID
   $followed = array_diff($followed, [$id]);

   // Save back to the user
   $user->followed_restaurants = $followed;
   $user->save();
 }
 public function list_rec_follow(Request $request)
 {
//    NUM 
// LIST RES : LOGO - NAME - DSESC - RATING 
// Recommend based on you followed : 
   $customer = Customer::find(Auth::guard('customer-api')->id());
   $followedRestaurantIds = $customer->followed_restaurants; 
   $followings = Resturant::whereIn('id', $followedRestaurantIds)
   ->select('id','name','description','rating')->with(['images' => function($query) {
      $query->select('id','imageable_id','filename')->where('type','logo');
  }])->get();
   $recommends=Resturant::select('id','name','description','rating')->with(['images' => function($query) {
      $query->select('id','imageable_id','filename')->where('type','logo');
  }])->get();
   return $this->sendResponse(['followings'=>$followings,'recommends'=>$recommends],'followings_recommends');
 }
 public function my_reservations()
 {
   
// Page Bookings :
// History :
// Upcoming :
// (num_person - date - st_end - location - status(confirmed - rejected - pending - completed - cancelled - ))
   // Upcoming - History  (num person - date with time) 
   // - map(state - city) - image  - status(completed - paid - cancelled)
      $my_reservations=Reservation::where('customer_id',Auth::guard('customer-api')->id())
      ->with(['resturant' => function ($query) {
      $query->select('id','name','time_start','time_end','deposit','rating')->with('location','images');}])->get();
      return $this->sendResponse($my_reservations,'my_reservations');
 }
 public function reversation_details($id)
 {
   $reservation=Reservation::where('id',$id)->with(['resturant' => function ($query) {
      $query->select('id','name','time_start','time_end','deposit','rating')->with('location','images');}])->get();
   return $this->sendResponse($reservation,'reversation_details');
 }
 public function reversation_cancel($id)
 {
     $reservation=Reservation::where('id',$id)->first();
     $reservation->update([
       'customer_id'=>Auth::guard('customer-api')->id(),
       'speacial_request'=>'-',
       'status'=>'cancelled',
    ]);
    return $this->sendResponse($reservation,'cancelled successfully');
 }
 public function map_res(Request $request)
 {
   //       == page_map :
// list res_nearby :
// image - name- type - availble - distanse - 

   // return list nearest : images large small - name - location - x,y - distanse between location and res
$userLatitude =$request->user_latitude;
$userLongitude =$request->user_longitude;
$userState =$request->user_state;
$restaurants = Restaurant::with('images', 'cuisine')
    ->select('restaurants.*') 
    ->selectRaw('( 6371 * acos( cos( radians(?) ) *
                           cos( radians( latitude ) )
                           * cos( radians( longitude ) - radians(?)
                           ) + sin( radians(?) ) *
                           sin( radians( latitude ) ) )
                         ) AS distance', [$userLatitude, $userLongitude, $userLatitude])
    ->join('locations', 'locations.restaurant_id', '=', 'restaurants.id') 
    ->where('locations.state', $userState) 
    ->havingRaw('distance < ?', [20]) 
    ->orderBy('distance', 'ASC')
    ->limit(10) 
    ->get();

 }
 public function search(Request $request)
{
    // Name, cuisine, location (state), or category search term
    $word = $request->input('word');
    if (empty($word)) {
        return 'Please enter a search term';
    }
    $resturants = Resturant::where('name', 'LIKE', '%' . $word . '%')
        ->orWhereHas('cuisine', function ($query) use ($word) {
            $query->where('name', 'LIKE', '%' . $word . '%');
        })
        ->orWhereHas('location', function ($query) use ($word) {
            $query->where('state', 'LIKE', '%' . $word . '%');
        })
        ->select('id','name','description','rating')->with(['images' => function($query) {
         $query->select('id','imageable_id','filename')->where('type','logo');
     }])->get();
    $userFollowedResturantIds = auth()->user()->followed_restaurants ?? [];
    $followedResturants = [];
    $otherResturants = [];
    foreach ($resturants as $resturant) {
        if (in_array($resturant->id, $userFollowedResturantIds)) {
            $followedResturants[] = $resturant;
        } else {
            $otherResturants[] = $resturant;
        }
    }
    $result = [
        'following' => $followedResturants,
        'others' => $otherResturants,
    ];
    return $this->sendResponse($result, 'search_results');
}

   public function advansearch(Request $request) 
    {
      //people  date  time (return rsturants have reservation_available) 
      $people = $request->input('people');
      $time = $request->input('time');
      $date = $request->input('date');
      $reservationDateTime = Carbon::parse($date . ' ' . $time);
      $resturants = Resturant::whereHas('tables', function ($query) use ($people, $reservationDateTime) {
          $query->where('capacity', '=', $people)
                ->whereHas('reservations', function ($query) use ($reservationDateTime) {
                    $query->where('status', '=', 'scheduled')
                          ->where('reservation_time', '=', $reservationDateTime->format('H:i:s'))
                          ->where('reservation_date', '=', $reservationDateTime->toDateString());
                });
      })->select('id','name','description','rating')->with(['images' => function($query) {
         $query->select('id','imageable_id','filename')->where('type','logo');
     }])->get();
    $userFollowedResturantIds = auth()->user()->followed_restaurants ?? [];
    $followedResturants = [];
    $otherResturants = [];
    foreach ($resturants as $resturant) {
        if (in_array($resturant->id, $userFollowedResturantIds)) {
            $followedResturants[] = $resturant;
        } else {
            $otherResturants[] = $resturant;
        }
    }
    $result = [
        'following' => $followedResturants,
        'others' => $otherResturants,
    ];
    return $this->sendResponse($result, 'search_results');
   
     }
//    public function filtersearch(Request $request) 
//     {
//     $longitude ='12.675657';// $request->input('longitude'); 
//     $latitude ='43243523.464363'; //$request->input('latitude');  
//     $sortType = $request->input('sort_type', 'rating'); 
//     $followOnly = $request->input('follow_only', false);
//     $nameCuisines = $request->input('name_cuisine',[]);
//     $categories = $request->input('category',[]);   
//     $query = Resturant::query();
//     if ($followOnly) {
//         $query->whereIn('id',Auth::guard('customer-api')->followed_restaurants ?? []);
//     }
//     if (!empty($nameCuisines)) {
//         $query->whereIn('cuisine_id', function ($query) use ($nameCuisines) {
//             $query->select('id')
//                 ->from('cuisines')
//                 ->whereIn('name', $nameCuisines);
//         });
//     }

//     if (!empty($categories)) {
//         $query->whereIn('category', $categories);
//     }

//     // Sort the results based on the chosen sort type
//     if ($sortType === 'distance' && $longitude && $latitude) {
//         $query->selectRaw(
//             '(6371 * acos(cos(radians(?)) * cos(radians(locations.latitude)) * 
//             cos(radians(locations.longitude) - radians(?)) + sin(radians(?)) * 
//             sin(radians(locations.latitude)))) as distance',
//             [$latitude, $longitude, $latitude]
//         )->orderBy('distance', 'asc');
//         $query->join('location', 'resturants.id', '=', 'locations.resturant_id');
//     } else {
//         $query->orderBy('rating', 'desc');
//     }

//     // Retrieve the filtered and sorted restaurants
//     $resturants = $query->select('id','name','description','rating')->with(['images' => function($query) {
//       $query->select('id','imageable_id','filename')->where('type','logo');
//   }])->get();
//  $userFollowedResturantIds = auth()->user()->followed_restaurants ?? [];
//  $followedResturants = [];
//  $otherResturants = [];
//  foreach ($resturants as $resturant) {
//      if (in_array($resturant->id, $userFollowedResturantIds)) {
//          $followedResturants[] = $resturant;
//      } else {
//          $otherResturants[] = $resturant;
//      }
//  }
//  $result = [
//      'following' => $followedResturants,
//      'others' => $otherResturants,
//  ];
//  return $this->sendResponse($result, 'search_results');
//     }
public function filtersearch(Request $request)
{
    $longitude = '12.675657'; // $request->input('longitude');
    $latitude = '43243523.464363'; // $request->input('latitude');
    $sortType = $request->input('sort_type', 'rating');
    $followOnly = $request->input('follow_only', false);
    $nameCuisines = $request->input('name_cuisine', []);
    $categories = $request->input('category', []);
    $query = Resturant::query();

    if ($followOnly) {
        $query->whereIn('id', Auth::guard('customer-api')->user()->followed_resturants ?? []);
    }

    if (empty($nameCuisines)) {
        $nameCuisines = []; // Convert to an empty array if it's empty
    }

    if (!empty($nameCuisines)) {
        $query->whereIn('cuisine_id', function ($query) use ($nameCuisines) {
            $query->select('id')
                ->from('cuisines')
                ->whereIn('name', $nameCuisines);
        });
    }

    if (!empty($categories)) {
        $query->whereIn('category', $categories);
    }

    // Sort the results based on the chosen sort type
    if ($sortType === 'distance' && $longitude && $latitude) {
        $query->selectRaw(
            '(6371 * acos(cos(radians(?)) * cos(radians(locations.latitude)) * 
            cos(radians(locations.longitude) - radians(?)) + sin(radians(?)) * 
            sin(radians(locations.latitude)))) as distance',
            [$latitude, $longitude, $latitude]
        )->orderBy('distance', 'asc');
        $query->join('locations', 'resturants.id', '=', 'locations.resturant_id');
    } else {
        $query->orderBy('rating', 'desc');
    }
    // Retrieve the filtered and sorted resturants
    $resturants = $query->select('id', 'name', 'description', 'rating')
        ->with(['images' => function ($query) {
            $query->select('id', 'imageable_id', 'filename')->where('type', 'logo');
        }])
        ->get();
    $userFollowedResturantIds = auth()->guard('customer-api')->user()->followed_restaurants ?? [];
    $followedResturants = [];
    $otherResturants = [];

    foreach ($resturants as $resturant) {
        if (in_array($resturant->id, $userFollowedResturantIds)) {
            $followedResturants[] = $resturant;
        } else {
            $otherResturants[] = $resturant;
        }
    }
    $result = [
        'following' => $followedResturants,
        'others' => $otherResturants,
    ];

    return $this->sendResponse($result, 'search_results');
}

   public function review(Request $request,$id)
   {
  
      Reviews::create([
         'customer_id'=>Auth::guard('customer-api')->id(),
         'resturant_id'=>$id,
         'rating'=>$request->rating,
         'comment'=>$request->comment,
      ]);
      $resturant=Resturant::where('id',$id)->first();  
    $averageRating = Reviews::where('resturant_id', $id)->avg('rating');
    $resturant->update([
        'rating' => $averageRating,
    ]);
    return $resturant;
   }
   public function reviews($id)
   {
      $reviews=Resturant::where('id',$id)->with('reviews')->withCount('reviews as count_reviews')->first();
      return $reviews;
   }
   public function details_offer($id)
   {
      // IMAGE - PRICE_OLD - PRICE_NEW - DESC - NAME_OFFER - FEATURES - IMAGES
      $offer=offer::where('id',$id)
      ->with(['images' => function($query) {
          $query->select('id','imageable_id','filename','type');
      }])->first();
      return $this->sendResponse($offer,'details_offer');
   }
   public function available_times($id)  //id res
   {
      // request : date - numPersone - return : time
   }
   public function nearest_resturants(Request $request)
   {
     // name_cat : (rating - name - ? - available - distance)
    return $this->sendResponse($resturants,'details_offer');
   }
   public function category_resturants($id)
   {
     // page view_all_cat :
   }

}