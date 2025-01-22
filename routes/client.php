<?php
// require __DIR__ . '/auth.php';

use App\Http\Controllers\ClientAuth\LoginController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */
// Route::middleware('auth:client')->get('/clientDash/login', function () {
//     return view('middleware.login');
// });

// Route::middleware('IsClient')->group(function () {
    Route::get('clientDash/login', [LoginController::class, 'showLoginForm']);
    Route::post('clientDash/login', [LoginController::class, 'login'])->name('client.login');
    // Route::get('clientDash/index', [LoginController::class, 'index'])->name('client.index');
    Route::get('/clientDash/index', function () {
        return view('clientDashboard.index');
    })->name('client.index');
    Route::post('clientDash/logout', [LoginController::class, 'logout'])->name('client.logout');

// });

   
// Route::prefix('clientDash')->name('client.')->group(function () {
//     // dd("client");
   
//       Route::middleware('IsClient')->group(function () {
//         // dd("client");
//         Route::view('index','clientDashboard.index');
//         // Route::get('clientDash', function () {
            
//         // })->name('index');
//     });
    
// });
// require __DIR__ . '/client.php';



