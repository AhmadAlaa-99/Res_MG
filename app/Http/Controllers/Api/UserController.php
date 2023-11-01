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
   DB::raw('(6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) 
   + sin(radians(?)) * sin(radians(latitude)))) AS distance')
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
      // - 
      // Deposite_information - refund policy - change policy - cancellition policy 

      //images - Name - State - City - Description -  RATING(NUM)-  Reviews (stars mumb - num reviews)
      $resturant = Resturant::select(['id','time_start','cuisine_id','time_end', 'name', 'description', 
      'age_range', 'category', 'phone_number', 'deposit', 'rating', 'services'])
      ->where('id', $id)
      ->with([
          'images' => function ($query) {
              $query->select(['id', 'filename', 'type', 'imageable_id']); 
          },
          'location' => function ($query) {
              $query->select(['id', 'latitude', 'longitude', 'state', 'text', 'resturant_id']); 
          },'reviews','cuisine','menu'])->withCount('reviews as count_reviews')->first();
          $currentLocation = [
              'latitude' => '3242.4234',//request('lat'), // get latitude from request
              'longitude' => '43242.664554',//request('long'), // get longitude from request
          ];
          $suggestions = Resturant::where('category', $resturant->category)
              ->selectRaw('resturants.*, locations.latitude, locations.longitude, 
                           (6371 * acos(cos(radians(?)) * cos(radians(locations.latitude)) 
                           * cos(radians(locations.longitude) - radians(?)) + sin(radians(?)) 
                           * sin(radians(locations.latitude)))) AS distance', 
                           [$currentLocation['latitude'], $currentLocation['longitude'], $currentLocation['latitude']])
              ->join('locations', 'resturants.id', '=', 'locations.resturant_id')
              ->with(['cuisine', 'images' => function ($query) {
                  $query->where('type', 'main');
              }, 'location'])
              ->get()
              ->map(function ($resturant) {
                  return [
                      'id' => $resturant->id,
                      'name' => $resturant->name,
                      'deposit' => $resturant->deposit,
                      'cuisine_name' => $resturant->cuisine->name,
                      'category' => $resturant->category,
                      'location_text' => $resturant->location->text,
                      'rating_number' => $resturant->rating,
                      'images' => $resturant->images->pluck('filename'), // Assuming you only want the file names
                      'distance' => $resturant->distance,
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
 {      $my_reservations=Reservation::where('customer_id',Auth::guard('customer-api')->id())
      ->with(['resturant' => function ($query) {
      $query->select('id','name','time_start','time_end','deposit','rating')
      ->with('location','images');}])->with('table')->get();
      $upcoming = $my_reservations->where('status','next')->map(function ($reservation) {
         return [
             'id' => $reservation->id,
             'customer_id' => $reservation->customer_id,
             'table_id' => $reservation->table_id,
             'resturant_id' => $reservation->resturant_id,
             'speacial_request' => $reservation->speacial_request,
             'actual_price' => $reservation->actual_price,
             'reservation_time' => $reservation->reservation_time,
             'reservation_time_end' => $reservation->reservation_time_end,
             'reservation_date' => $reservation->reservation_date,
             'party_size' => $reservation->party_size,
             'status' => $reservation->status,
             'created_at' => $reservation->created_at,
             'updated_at' => $reservation->updated_at,
             'capacity' => optional($reservation->table)->capacity,
             'name_resturant' => optional($reservation->resturant)->name,
             'location' => optional(optional($reservation->resturant)->location)->text,
             'image_logo' => optional($reservation->resturant->images->where('type', 'logo')->first())->filename
         ];
     });
     $history=$my_reservations->where('status','next')->map(function ($reservation) {
      return [
          'id' => $reservation->id,
          'customer_id' => $reservation->customer_id,
          'table_id' => $reservation->table_id,
          'resturant_id' => $reservation->resturant_id,
          'speacial_request' => $reservation->speacial_request,
          'actual_price' => $reservation->actual_price,
          'reservation_time' => $reservation->reservation_time,
          'reservation_time_end' => $reservation->reservation_time_end,
          'reservation_date' => $reservation->reservation_date,
          'party_size' => $reservation->party_size,
          'status' => $reservation->status,
          'created_at' => $reservation->created_at,
          'updated_at' => $reservation->updated_at,
          'capacity' => optional($reservation->table)->capacity,
          'name_resturant' => optional($reservation->resturant)->name,
          'location' => optional(optional($reservation->resturant)->location)->text,
          'image_logo' => optional($reservation->resturant->images->where('type', 'logo')->first())->filename
      ];
  });
      return $this->sendResponse(['upcoming'=>$upcoming,'history'=>$history],'my_reservations');
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

   // return list nearest : images main logo - name - name_cuisine-category distanse between location and res
$userLatitude ='32423';//$request->user_latitude;
$userLongitude ='34242342.4322';//$request->user_longitude;
$map_res = Resturant::with('images','cuisine')
    ->select('resturants.*') 
    ->selectRaw('( 6371 * acos( cos( radians(?) ) *
                           cos( radians( latitude ) )
                           * cos( radians( longitude ) - radians(?)
                           ) + sin( radians(?) ) *
                           sin( radians( latitude ) ) )
                         ) AS distance', [$userLatitude, $userLongitude, $userLatitude])
    ->join('locations', 'locations.resturant_id', '=', 'resturants.id') 
    //->havingRaw('distance < ?', [20]) 
    ->orderBy('distance', 'ASC')
    ->limit(10) 
    ->get()
    ->map(function ($resturant) {
        return [
            'id' => $resturant->id,
            'name' => $resturant->name,
            'deposit' => $resturant->deposit,
            'cuisine_name' => $resturant->cuisine->name,
            'category' => $resturant->category,
            'location_text' => $resturant->location->text,
            'rating_number' => $resturant->rating,
            'images' => $resturant->images->pluck('filename','type'), // Assuming you only want the file names
            'distance' => $resturant->distance,
        ];
    });
    return $this->sendResponse($map_res,'map_res');
    
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
    $nameCuisines = $request->input('name_cuisine');
    $categories = $request->input('category');
    $query = Resturant::query();

    if ($followOnly) {
        $query->whereIn('id', Auth::guard('customer-api')->user()->followed_resturants ?? []);
    }
    if (empty($nameCuisines)) {
        $nameCuisines = []; // Convert to an empty array if it's empty
    }
   // return $nameCuisines; //response : ['عربي']
   if (!empty($nameCuisines))
    {
      // Ensure that $nameCuisines is an array
      if (!is_array($nameCuisines)) {
          $nameCuisines = [$nameCuisines];
      }
  
      $query->whereIn('cuisine_id', function ($query) use ($nameCuisines) {
          $query->select('id')
              ->from('cuisines')
              ->whereIn('name', $nameCuisines);
      });
  }
  if (!empty($categories))
  {
    // Ensure that $nameCuisines is an array
    if (!is_array($categories)) {
        $categories = [$categories];
    }

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
       $offer = offer::where('id', $id)
           ->with(['images' => function ($query) {
               $query->select('id', 'imageable_id', 'filename', 'type');
           }])->first();
   
       // Extract the path_main from the images array
       $pathMain = null;
       $filteredImages = [];
   
       foreach ($offer->images as $image) {
           if ($image->type === 'main') {
               $pathMain = $image->filename;
           } elseif ($image->type === 'others') {
               $filteredImages[] = $image;
           }
       }
   
       // Create the modified response
       $modifiedOffer = [
           'id' => $offer->id,
           'resturant_id' => $offer->resturant_id,
           'price_old' => $offer->price_old,
           'price_new' => $offer->price_new,
           'desc' => $offer->desc,
           'name' => $offer->name,
           'type' => $offer->type,
           'open_year' => $offer->open_year,
           'status' => $offer->status,
           'featured' => $offer->featured,
           'path_main' => $pathMain,
           'created_at' => $offer->created_at,
           'updated_at' => $offer->updated_at,
           'images' => $filteredImages,
       ];
       return $this->sendResponse($modifiedOffer, 'details_offer');
   }


   
   public function available_times_res(Request $request,$id)  //id res
   {
      // request : date - numPersone - return : reservations(id,time)-times_availables
   }
   public function nearest_resturants(Request $request)
   {
     // name_cuisine : (rating - name - category - available - distance)
   //   resturants : id cuisine_id name description   category is_available deposit  rating
   //   cuisines : id name
   //   images : filename  type imageable_id  imageable_type
   $lat='fdsfdsfsd';
   $lng='rwerwewfs';
   $currentLocation = [
      'latitude' => '3242.4234',//request('lat'), // get latitude from request
      'longitude' => '43242.664554',//request('long'), // get longitude from request
   ];
     $nearest_resturants = Cuisine::with(['resturants' => function($query) use ($lat, $lng,$currentLocation) {
      $query->with(['images' => function($query) {
          $query->where('type', 'main');
      }]);
      $query->selectRaw('resturants.*, locations.latitude, locations.longitude, 
      (6371 * acos(cos(radians(?)) * cos(radians(locations.latitude)) 
      * cos(radians(locations.longitude) - radians(?)) + sin(radians(?)) 
      * sin(radians(locations.latitude)))) AS distance', 
      [$currentLocation['latitude'], $currentLocation['longitude'], $currentLocation['latitude']]);

   // $query->having('distance', '<', 50); 
   $query->join('locations', 'resturants.id', '=', 'locations.resturant_id'); 
  }])->get();
    return $this->sendResponse($nearest_resturants,'nearest_resturants');
   }
   public function cuisine_resturants($id)
   {
     // page view_all_cat :
     $lat='fdsfdsfsd';
     $lng='rwerwewfs';
     $currentLocation = [
        'latitude' => '3242.4234',//request('lat'), // get latitude from request
        'longitude' => '43242.664554',//request('long'), // get longitude from request
     ];
       $cuisine_resturants = Cuisine::where('id',$id)->with(['resturants' => function($query) use ($lat, $lng,$currentLocation) {
        $query->with(['images' => function($query) {
            $query->where('type', 'main');
        }]);
        $query->selectRaw('resturants.*, locations.latitude, locations.longitude, 
        (6371 * acos(cos(radians(?)) * cos(radians(locations.latitude)) 
        * cos(radians(locations.longitude) - radians(?)) + sin(radians(?)) 
        * sin(radians(locations.latitude)))) AS distance', 
        [$currentLocation['latitude'], $currentLocation['longitude'], $currentLocation['latitude']]);
  
     // $query->having('distance', '<', 50); 
     $query->join('locations', 'resturants.id', '=', 'locations.resturant_id'); 
    }])->first();
      return $this->sendResponse($cuisine_resturants,'cuisine_resturants');

   }

}