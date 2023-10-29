<?php
namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\BaseController;
use App\Models\Table;
use Hash;
use App\Models\Cuisine;
use App\Models\Menu; 
use App\Models\Image;
use App\Models\Reservation;
use App\Models\Reviews;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use App\Models\Resturant;
class UserController extends BaseController
{

   public function proposal_resturants(Request $request)
   {
//       ForYou(location - age. (ages accept from dashboard resturant))
// Featured(rating - reservations)
// Based on Your taste(algorithm  selected - dynamic)
// [nameCate - Desc - rest(image - name - cuisine - rating(number) - location) with distanse about location cureent].
// New Opening - Offers : [images just].
      //all resturants(id name location rating open.close deposit images) orderby cuisine(id name desc).
   $resturants=Cuisine::with(['resturants' => function ($query) {
   $query->select('id','name','time_start','time_end','deposit','rating')->with('location','images');}])->get();
   return $this->sendResponse($resturants,'proposal_resturants');
   }
   public function details($id) //with viewMap
   {
      // -------------------------
      // Details Resturant :
      // Name - location - Services(icon with name)
      // Num rating - rating -menu 
      // suggestion resturants similiar 
      // --------------------------------
      // Details bOOK Res :
      // image - images - description - services(icon with names) -location on map - 
      // location - phone - website - insta - deposite_information - refund Policy 
      // change Policy - CANCELLED POLICY
      // --------------------------------


      //images - Name - State - City - Description -  RATING(NUM)-  Reviews (stars mumb - num reviews)
      $resturant=Resturant::where('id',$id)->with('images','reviews','location') //,'reservations','location'
      ->withCount('reviews as count_reviews')->first();
      return $this->sendResponse($resturant,'resturant_details');
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
   $followings = Restaurant::whereIn('id', $followedRestaurantIds)
   ->select('id','name','time_start','time_end','deposit','rating')->with('location','images')
   ->get();
   $recommends=Resturants::select('id','name','time_start','time_end','deposit','rating')
   ->with('location','images')->get();
   return $this->sendResponse($resturants,'proposal_resturants');
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
   public function search(Request $request)//name 
    {
      //nameor cuisine or location or type
      $resturant=Resturant::where('name',$request->name)->with('images','reviews','location')
      ->withCount('reviews as count_reviews')->first();
      return $this->sendResponse($resturant,'search');

    } 
   public function advansearch(Request $request) // people date  time (return rsturants have reservation_available)
    { 
      $results=Reservation::where(
         [
            'reservation_time'=>$request->reservation_time,
             'reservation_date'=>$request->reservation_date,

         ])->with(['resturant' => function ($query) {
      $query->select('id','name','time_start','time_end','deposit','rating')->with('location','images');}])->get();
     }
   public function filtersearch(Request $request) //request : sort_type(rating - Distance )
   //Sort by rating Distance show following just price range Cuisine  Type
    {
//       sort by : revelance - distance 
// follow only 
// cuisine type(multiple)
// type_res
      $userLatitude = 'user_latitude_here';
      $userLongitude = 'user_longitude_here';
      $userState = 'user_state_here';
      $sortType = request('sort_type');
      $followedRestaurants = json_decode(Auth::user()->followed_restaurants); 
      $cuisineType = request('cuisine_type'); 
      $restaurantsQuery = Restaurant::with('images', 'cuisine')
          ->select('restaurants.*')
          ->selectRaw('( 6371 * acos( cos( radians(?) ) *
                                 cos( radians( latitude ) )
                                 * cos( radians( longitude ) - radians(?)
                                 ) + sin( radians(?) ) *
                                 sin( radians( latitude ) ) )
                               ) AS distance', [$userLatitude, $userLongitude, $userLatitude])
          ->join('locations', 'locations.restaurant_id', '=', 'restaurants.id')
          ->join('cuisines', 'cuisines.id', '=', 'restaurants.cuisine_id')
          ->where('locations.state', $userState)
          ->where('cuisines.name', $cuisineType)
          ->whereIn('restaurants.id', $followedRestaurants);
      if ($sortType === 'rating') {
          $restaurantsQuery = $restaurantsQuery->orderBy('restaurants.rating', 'DESC');
      } elseif ($sortType === 'distance') {
          $restaurantsQuery = $restaurantsQuery->orderBy('distance', 'ASC');
      }
      $restaurants = $restaurantsQuery->get();
      return $restaurants;
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
   }
   public function available_times($id)  //id res
   {
      // request : date - numPersone - return : time
   }
   public function nearest_resturants()
   {
     // name_cat : (rating - name - ? - available - distance)

   }
   public function category_resturants($id)
   {
     // page view_all_cat :
   }

}