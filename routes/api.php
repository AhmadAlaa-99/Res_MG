<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('customer/')->group(function ()
{
    Route::post('login',[AuthController::class,'login']);
    Route::post('register',[AuthController::class,'create'])->name('create');
    Route::post('verify',[AuthController::class,'verify'])->name('verify');  //WITH LOGIN_NUMBER
    Route::post('register_complete',[AuthController::class,'register_complete'])->name('register_complete');
            Route::group(["middleware"=>['auth:customer-api']],function()
            {
            Route::get('proposal_resturants',[UserController::class,'proposal_resturants'])->name('proposal_resturants');
            Route::post('details_offer/{id}',[UserController::class,'details_offer'])->name('details_offer');
            Route::get('details/{id}',[UserController::class,'details'])->name('details');
            Route::post('follow/{id}',[UserController::class,'follow'])->name('follow');
            Route::post('unfollow/{id}',[UserController::class,'unfollow'])->name('unfollow');
            Route::get('list_rec_follow',[UserController::class,'list_rec_follow'])->name('list_rec_follow');
            Route::post('search',[UserController::class,'search'])->name('search'); //name cuisine or location(state) or category
            Route::post('advansearch',[UserController::class,'advansearch'])->name('advansearch'); //
            Route::post('filtersearch',[UserController::class,'filtersearch'])->name('filtersearch'); 
            Route::post('review/{id}',[UserController::class,'review'])->name('review'); 
            Route::get('reviews/{id}',[UserController::class,'reviews'])->name('reviews'); 

    



            Route::get('nearest_resturants',[UserController::class,'nearest_resturants'])->name('nearest_resturants'); 
            Route::get('category_resturants/{id}',[UserController::class,'category_resturants'])->name('category_resturants'); 
            Route::post('map_res',[UserController::class,'map_res']); //check pass from front 
            Route::get('available_times/{id}',[UserController::class,'available_times'])->name('available_times');
            Route::post('reversation/{id}',[UserController::class,'reversation'])->name('reversation');
            Route::get('my_reservations',[UserController::class,'my_reservations'])->name('my_reservations');
            Route::post('reversation_cancel/{id}',[UserController::class,'reversation_cancel'])->name('reversation_cancel');
            Route::post('reversation_details/{id}',[UserController::class,'reversation_details'])->name('reversation_details');//==details : (details _res)
            Route::get('profile',[AuthController::class,'profile']);
            Route::post('edit_profile',[AuthController::class,'edit_profile']); //check pass from front 

         //   Route::get('available_reservations/{id}',[UserController::class,'available_reservations'])->name('available_reservations');        
          

        }); });

