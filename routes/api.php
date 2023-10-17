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
           Route::post('register',[AuthController::class,'register'])->name('register_customer');
           Route::post('ActivateEmail',[AuthController::class,'ActivateEmail']);
           Route::post('login_customer',[AuthController::class,'Login'])->name('login_customer');
           Route::group(["middleware"=>['auth:customer-api']],function(){
           Route::post('reversation/{id}',[UserController::class,'reversation'])->name('reversation');
           Route::get('details/{id}',[UserController::class,'details'])->name('details');
           Route::post('reversation_cancel/{id}',[UserController::class,'reversation_cancel'])->name('reversation_cancel');
           Route::get('search',[UserController::class,'search'])->name('search');
           Route::get('proposal_resturants',[UserController::class,'proposal_resturants'])->name('proposal_resturants');


           Route::get('profile',[AuthController::class,'profile']);
           Route::post('edit_profile',[AuthController::class,'edit_profile']);

    });
}
);

