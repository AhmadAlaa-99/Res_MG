<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\OfferController;
use App\Http\Controllers\Admin\CuisineController; 
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Resturant_staff\DashboardController as staff_DashboardController ;
use App\Http\Controllers\Resturant_staff\ReservationController as staff_ReservationController ;
use App\Http\Controllers\Resturant_staff\TableController as staff_TableController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('post-login');

Route::get('/clear', function() {
	$exitCode = Artisan::call('cache:clear');
	$exitCode = Artisan::call('route:cache');
    $exitCode = Artisan::call('route:clear');
	$exitCode = Artisan::call('config:cache');
    $exitCode = Artisan::call('view:clear');
    return 'All routes cache has just been removed';
    });
Route::group([
    //'prefix' => 'admin',
   // 'namespace' => 'Admin',
    //'as' => 'admin.',
    //'middleware' => 'auth:admnin',
    'middleware' => ['auth'],
], function() {
    Route::resource('resturants', DashboardController::class);
    Route::resource('reservations', DashboardController::class);
    Route::resource('cuisines', CuisineController::class);

    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);

    Route::resource('offers', OfferController::class);
    Route::get('/offers_index/{id}', [OfferController::class, 'offers_index'])->name('offers_index');
    Route::get('/act_inact__offer/{id}', [DashboardController::class, 'act_inact__offer'])->name('act_inact__offer');  //id resturant
    



    Route::get('/managers', [UserController::class, 'managers'])->name('managers');
    Route::get('/', [DashboardController::class, 'statistics'])->name('statistics');
    Route::get('/staff_all', [DashboardController::class, 'staff_all'])->name('staff_all');
    Route::get('/customers', [DashboardController::class, 'customers'])->name('customers');
    Route::any('/update_profile_admin', [DashboardController::class,'update_profile_admin'])->name('update_profile_admin');	


    Route::get('/rest_tables/{id}', [DashboardController::class, 'rest_tables'])->name('rest_tables');
    Route::get('/table_add/{id}', [DashboardController::class, 'table_add'])->name('table_add');
    
    Route::get('/table_reservations/{id}', [DashboardController::class, 'table_reservations'])->name('table_reservations');
    Route::post('/table_store/{id}', [DashboardController::class, 'table_store'])->name('table_store');
    Route::get('/act_inact__resturant/{id}', [DashboardController::class, 'act_inact__resturant'])->name('act_inact__resturant');  //id resturant
    Route::get('/admin_profile', [DashboardController::class, 'admin_profile'])->name('admin_profile');
    Route::get('/resturant_reservations/{id}', [DashboardController::class, 'resturant_reservations'])->name('resturant_reservations');
    Route::get('/all_notifications', [DashboardController::class, 'all_notifications'])->name('all_notifications');
    Route::post('/date_reservations/{id}', [DashboardController::class, 'dat_reservations'])->name('dat_reservations');


    Route::any('user/notifications/get', [DashboardController::class, 'getNotifications'])->name('getNotifications');
    Route::any('user/notifications/read', [DashboardController::class, 'markAsRead'])->name('markAsRead');
    Route::any('/user/notifications/read/{id}', [DashboardController::class, 'markAsReadAndRedirect'])->name('markAsReadAndRedirect');

    ////////staff 
    Route::resource('tables', staff_TableController::class);
    Route::get('/today_tables/{id}', [staff_TableController::class, 'today_tables'])->name('today_tables');	
    Route::post('/date_tables/{id}', [staff_TableController::class, 'date_tables'])->name('date_tables');	


    Route::get('/reservations_generate/{id}', [staff_ReservationController::class, 'reservations_generate'])->name('reservations_generate_get');	
    Route::post('/reservations_generate', [staff_ReservationController::class, 'reservations_generate_post'])->name('reservations_generate_post');
    Route::get('/record_update', [staff_ReservationController::class, 'record_update'])->name('record_update');	
    Route::get('/records_reservations/{id}', [staff_ReservationController::class, 'records_reservations'])->name('records_reservations');


    Route::get('/reservations_regenerate', [staff_ReservationController::class, 'reservations_regenerate'])->name('reservations_regenerate_get');	
    Route::post('/reservations_regenerate', [staff_ReservationController::class, 'reservations_regenerate_post'])->name('reservations_regenerate_post');	



    Route::get('/reservations_start/{id}', [staff_ReservationController::class, 'reservations_start'])->name('reservations_start');	

    Route::get('/reservations_end/{id}', [staff_ReservationController::class, 'reservations_end'])->name('reservations_end');	

    
    Route::get('/reservations_start_ajax/{id}', [staff_ReservationController::class, 'reservations_start_ajax'])->name('reservations_start_ajax');
    Route::get('/reservations_end_ajax/{id}', [staff_ReservationController::class, 'reservations_end_ajax'])->name('reservations_end_ajax');

    
    Route::resource('reservations', staff_ReservationController::class);
    Route::get('/today_reservations/{id}', [staff_ReservationController::class, 'today_reservations'])->name('today_reservations');	
    Route::post('/date_reservations', [staff_ReservationController::class, 'date_reservations'])->name('date_reservations');	

    Route::get('/staff_statistics', [staff_DashboardController::class, 'staff_statistics'])->name('staff_statistics');

    Route::get('/profile', [staff_DashboardController::class, 'staff_profile'])->name('staff_profile');
    
    Route::post('/update_profile_staff', [staff_DashboardController::class, 'update_profile'])->name('update_profile_staff');	



});




Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
