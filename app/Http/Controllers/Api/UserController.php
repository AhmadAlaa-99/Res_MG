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
use App\Models\Resturant;
class UserController extends BaseController
{

   public function proposal_resturants(Request $request)
   {
    $reaturants=Resturant::where('location',$request->location)->with('cuisine,menu')->get();
    return $this->sendResponse($reaturants,'proposal_resturants');
   }
   public function search(Request $request)  //name  -  location  - cuisine
   { 
      $query = Resturant::query();

      if ($request->has('name')) {
          $query->where('name', 'like', '%' . $request->name . '%');
      }
  
      if ($request->has('location'))
         {
          $query->where('location', 'like', '%' . $request->location . '%');
         }

      if ($request->has('cuisine')) 
      {
          $query->where('cuisine', 'like', '%' . $request->cuisine . '%');
      }
  
      $restaurants = $query->get();
     
      return response()->json($restaurants);
   }
   public function details($id)
   {
      $reservation=Reservation::where('id',$id)->with('table','user')->first();
      return $this->sendResponse($reservation,'reservation_details');
   }
   public function reversation(Request $request,$id) //id reservation
   {
      $reservation=Reservation::where('id',$id)->update([
         'customer_id'=>Auth::guard('customer-api')->id(),
         'speacial_request'=>$request->speacial_request,
         'status'=>'next',
      ]);
      
   }
   public function reversation_cancel($id)
   {
      Reservation::where('id',$id)->update([
         'customer_id'=>Auth::guard('customer-api')->id(),
         'speacial_request'=>'-',
         'status'=>'scheduled',
      ]);
   }
}
